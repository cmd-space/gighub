<?php

require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\Venue;


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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/profile.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$city = filter_input(INPUT_GET, "city", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$state = filter_input(INPUT_GET, "state", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$street1 = filter_input(INPUT_GET, "street1", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$street2 = filter_input(INPUT_GET, "street2", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$zip = filter_input(INPUT_GET, "zip", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

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
		} else if(empty($profileId) === false) {
			$venue = Venue::getVenueByVenueProfileId($pdo, $profileId);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($profileId) === false) {
			$venue = Venue::getVenueByVenueName($pdo, $name);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($profileId) === false) {
			$venue = Venue::getVenueByVenueCity($pdo, $city);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($profileId) === false) {
			$venue = Venue::getVenueByVenueStreet1($pdo, $street1);
			if($venue !== null) {
				$reply->data = $venue;
			}
		} else if(empty($profileId) === false) {
			$venue = Venue::getVenueByVenueZip($pdo, $zip);
			if($venue !== null) {
				$reply->data = $venue;
			}
		}

	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure profile venue id is available (required field)
		if(empty($requestObject->venueId) === true) {
			throw(new \InvalidArgumentException ("No venue id for this venue.", 405));
		}