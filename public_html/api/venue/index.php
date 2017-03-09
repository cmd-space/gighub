<?php

require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\{Profile, Venue};


/**
 * api for the Venue class
 *
 * @author Dante Conley <danteconley.com>
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
	$venueProfileId = filter_input(INPUT_GET, "VenueProfileId", FILTER_VALIDATE_INT);
	$venueCity = filter_input(INPUT_GET, "VenueCity", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$venueName = filter_input(INPUT_GET, "VenueName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$venueState = filter_input(INPUT_GET, "VenueState", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$venueStreet1 = filter_input(INPUT_GET, "VenueStreet1", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$venueStreet2 = filter_input(INPUT_GET, "VenueStreet2", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$venueZip = filter_input(INPUT_GET, "VenueZip", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that venue is returned, otherwise all profiles are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific venue or all venues and update reply
		if(empty($id) === false) {
			$venue = Venue::getVenueByVenueId($pdo, $id);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($venueProfileId) === false) {
			$venue = Venue::getVenueByVenueProfileId($pdo, $venueProfileId);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($venueCity) === false) {
			$venue = Venue::getVenueByVenueCity($pdo, $venueCity);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($venueName) === false) {
			$venue = Venue::getVenueByVenueName($pdo, $venueName);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($venueStreet1) === false) {
			$venue = Venue::getVenueByVenueStreet1($pdo, $venueStreet1);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($venueZip) === false) {
			$venue = Venue::getVenueByVenueZip($pdo, $venueZip);
			if($venue !== null) {
				$reply->data = $venue;
			}
		}

	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);



		//make sure venue profile id is available (required field)
		if(empty($requestObject->venueProfileId) === true) {
		throw(new \InvalidArgumentException ("This is where it is dying", 405));
		}
		if(empty($requestObject->venueCity) === true) {
			throw(new \InvalidArgumentException ("This is where it is dying", 405));
		}
		if(empty($requestObject->venueName) === true) {
			throw(new \InvalidArgumentException ("This is where it is dying", 405));
		}
		if(empty($requestObject->venueState) === true) {
			throw(new \InvalidArgumentException ("This is where it is dying", 405));
		}
		if(empty($requestObject->venueStreet1) === true) {
			throw(new \InvalidArgumentException ("This is where it is dying", 405));
		}
		if(empty($requestObject->venueZip) === true) {
			throw(new \InvalidArgumentException ("This is where it is dying", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the venue to update
			$venue = Venue::getVenueByVenueId($pdo, $id);
			if($venue === null) {
				throw(new RuntimeException("Venue does not exist", 404));
			}


			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $venue->getVenueProfileId()) {
				throw(new \InvalidArgumentException("You do not have permission to edit this venue... Login, why don't you?", 403));
			}

			// update all attributes
			$venue->setVenueCity($requestObject->venueCity);
			$venue->setVenueName($requestObject->venueName);
			$venue->setVenueState($requestObject->venueState);
			$venue->setVenueStreet1($requestObject->venueStreet1);
			$venue->setVenueStreet2($requestObject->venueStreet2);
			$venue->setVenueZip($requestObject->venueZip);
			$venue->update($pdo);

			// update reply
			$reply->message = "Venue updated OK";
		} else if($method === "POST") {


			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You do not have permission to edit this venue... Login, why don't you?", 403));
			}


			// create new venue and insert into the database
			$venue = new Venue(null, $requestObject->venueProfileId, $requestObject->venueCity, $requestObject->venueName, $requestObject->venueState, $requestObject->venueStreet1, $requestObject->venueStreet2, $requestObject->venueZip);
			$venue->insert($pdo);

			// update reply
			$reply->message = "Venue created OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Venue to be deleted
		$venue = Venue::getVenueByVenueId($pdo, $id);
		if($venue === null) {
			throw(new RuntimeException("Venue does not exist", 404));
		}

		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $venue->getVenueProfileId()) {
			throw(new \InvalidArgumentException("You do not have permission to edit this venue... Login, why don't you?", 403));
		}


		// delete profile
		$venue->delete($pdo);

		// update reply
		$reply->message = "Venue deleted OK";
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
