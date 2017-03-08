<?php

require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\{Profile, ProfileType};

/**
 * api for the ProfileType class
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
	$profileTypeName = filter_input(INPUT_GET, "profileTypeName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that ProfileType is returned, otherwise all ProfileTypes are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific ProfileType or all ProfileTypes and update reply
		if(empty($id) === false) {
			$profileType = ProfileType::getProfileTypeByProfileTypeId($pdo, $id);
			if($profileType !== null) {
				$reply->data = $profileType;
			}
		} else if(empty($profileTypeName) === false) {
			$profileTypes = ProfileType::getProfileTypesByProfileTypeName($pdo, $profileTypeName);
			if($profileTypes !== null) {
				$reply->data = $profileTypes;
			}
		} else {
			$profileTypes = ProfileType::getAllProfileTypes($pdo);
			if($profileTypes !== null) {
				$reply->data = $profileTypes;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// Make sure that only one can edit one's own profile <--- referenced from https://github.com/zlaudick/dev-connect
		$profile = Profile::getProfileByProfileOAuthToken($pdo, $oAuthToken);
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileOAuthToken() !== $profile->getProfileOAuthToken()) {
			throw(new \InvalidArgumentException("You do not have permission to edit this profile... Login, why don't you?", 403));
		}

		//make sure profile type content is available (required field)
		if(empty($requestObject->profileTypeName) === true) {
			throw(new \InvalidArgumentException ("Y U NO include name for profile type?", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the tweet to update
			$profileType = ProfileType::getProfileTypeByProfileTypeId($pdo, $id);
			if($profileType === null) {
				throw(new RuntimeException("Profile Type does not exist", 404));
			}

			// update all attributes
			$profileType->setProfileTypeName($requestObject->profileTypeName);
			$profileType->update($pdo);

			// update reply
			$reply->message = "Profile Type updated OK";

		} else if($method === "POST") {

			// create new tweet and insert into the database
			$profileType = new ProfileType(null, $requestObject->profileTypeName);
			$profileType->insert($pdo);

			// update reply
			$reply->message = "Profile Type created OK";
		}
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

