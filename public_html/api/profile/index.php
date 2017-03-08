<?php
//TODO: rename variables to match class
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\Profile;


/**
 * api for the Profile class
 *
 * @author Mason Crane <cmd-space.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}



//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/gighub.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$oAuthId = filter_input(INPUT_GET, "oAuthId", FILTER_VALIDATE_INT);
	$type = filter_input(INPUT_GET, "type", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$location = filter_input(INPUT_GET, "location", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$oAuthToken = filter_input(INPUT_GET, "oAuthToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$soundCloudUser = filter_input(INPUT_GET, "soundCloudUser", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userName = filter_input(INPUT_GET, "userName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that profile is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific profile
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($oAuthId) === false) {
			$profile = Profile::getProfileByProfileOAuthId($pdo, $oAuthId);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($type) === false) {
			$profiles = Profile::getProfileByProfileTypeId($pdo, $type);
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		} else if(empty($location) === false) {
			$profiles = Profile::getProfileByLocationContent($pdo, $location);
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		} else if(empty($soundCloudUser) === false) {
			$profiles = Profile::getProfileBySoundCloudUser($pdo, $soundCloudUser);
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		} else if(empty($userName) === false) {
			$profiles = Profile::getProfileByProfileUserName($pdo, $userName);
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		}
	} else if($method === "PUT") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//perform the actual put or post
		if($method === "PUT") {

			// Make sure that only one can edit one's own profile <--- referenced from https://github.com/zlaudick/dev-connect
			// retrieve the profile to update
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null) {
				throw(new RuntimeException("Profile does not exist", 404));
			}


			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileOAuthToken() !== $profile->getProfileOAuthToken()) {
				throw(new \InvalidArgumentException("You do not have permission to edit this profile... Login, why don't you?", 403));
			}

			// retrieve the profile to update
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null) {
				throw(new RuntimeException("Profile does not exist", 404));
			}

			// update all attributes
			$profile->setProfileBio($requestObject->profileBio);
			$profile->setProfileImageCloudinaryId($requestObject->profileImageCloudinaryId);
			$profile->setProfileLocation($requestObject->profileLocation);
			$profile->setProfileOAuthToken($requestObject->profileOAuthToken);
			$profile->setProfileSoundCloudUser($requestObject->profileSoundCloudUser);
			$profile->setProfileUserName($requestObject->profileUserName);
			$profile->update($pdo);

			// update reply
			$reply->message = "Profile updated OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileOAuthToken() !== $profile->getProfileOAuthToken()) {
			throw(new \InvalidArgumentException("You do not have permission to edit this profile... Login, why don't you?", 403));
		}

		// retrieve the Profile to be deleted
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		// delete profile
		$profile->delete($pdo);

		// update reply
		$reply->message = "Profile deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);