<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\{
	Profile, ProfileType
};

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
			$profileTypes = ProfileType::getProfileTypesByProfileTypeName($pdo, $profileTypeName)->toArray();
			if($profileTypes !== null) {
				$reply->data = $profileTypes;
			}
		} else {
			$profileTypes = ProfileType::getAllProfileTypes($pdo)->toArray();
			if($profileTypes !== null) {
				$reply->data = $profileTypes;
			}
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

