<?php

require_once "../../../php/classes/autoload.php";
require_once "../../lib/xsrf.php";
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
	$pdo = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/profile.ini" );

	//determine which HTTP method was used
	$method = array_key_exists( "HTTP_X_HTTP_METHOD", $_SERVER ) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id                = filter_input( INPUT_GET, "id", FILTER_VALIDATE_INT );
	$oAuthId           = filter_input( INPUT_GET, "oAuthId", FILTER_VALIDATE_INT );
	$type              = filter_input( INPUT_GET, "type", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$bio               = filter_input( INPUT_GET, "bio", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$imageCloudinaryId = filter_input( INPUT_GET, "imageCloudinaryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$location          = filter_input( INPUT_GET, "location", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$oAuthToken        = filter_input( INPUT_GET, "oAuthToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$soundCloudUser    = filter_input( INPUT_GET, "soundCloudUser", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$userName          = filter_input( INPUT_GET, "userName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );

	//make sure the id is valid for methods that require it
	if ( ( $method === "DELETE" || $method === "PUT" ) && ( empty( $id ) === true || $id < 0 ) ) {
		throw( new InvalidArgumentException( "id cannot be empty or negative", 405 ) );
	}

	// handle GET request - if id is present, that profile is returned, otherwise all profiles are returned
	if ( $method === "GET" ) {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific tweet or all tweets and update reply
		if ( empty( $id ) === false ) {
			$profile = Profile::getProfileByProfileId( $pdo, $id );
			if ( $profile !== null ) {
				$reply->data = $profile;
			}
		} else if ( empty( $oAuthId ) === false ) {
			$profile = Profile::getProfileByProfileOAuthId( $pdo, $oAuthId );
			if ( $profile !== null ) {
				$reply->data = $profile;
			}
		} else if ( empty( $type ) === false ) {
			$profiles = Profile::getProfileByProfileTypeId( $pdo, $type );
			if ( $profiles !== null ) {
				$reply->data = $profiles;
			}
		} else if ( empty( $location ) === false ) {
			$profiles = Profile::getProfileByLocationContent( $pdo, $location );
			if ( $profiles !== null ) {
				$reply->data = $profiles;
			}
		} else if ( empty( $soundCloudUser ) === false ) {
			$profiles = Profile::getProfileBySoundCloudUser( $pdo, $soundCloudUser );
			if ( $profiles !== null ) {
				$reply->data = $profiles;
			}
		} else if ( empty( $userName ) === false ) {
			$profiles = Profile::getProfileByProfileUserName( $pdo, $userName );
			if ( $profiles !== null ) {
				$reply->data = $profiles;
			}
		}

//		else {
//			$profiles = Profile::get($pdo);
//			if($tweets !== null) {
//				$reply->data = $tweets;
//			}
		}
	}