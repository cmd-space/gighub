<?php

namespace Edu\Cnm\GigHub\Profile;

require_once( dirname( __DIR__, 3 ) . "/php/classes/autoload.php" );
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once( dirname( __DIR__, 3 ) . "/vendor/autoload.php" );
require_once( "/etc/apache2/capstone-mysql/encrypted-config.php" );

use Edu\Cnm\GigHub\Profile;

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$pdo    = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );
	$config = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
	$oauth  = json_decode( $config["oauth"] );

	$REDIRECT_URI           = 'https://bootcamp-coders.cnm.edu/~jramirez98/gighub/public_html/api/oauth/';
	$AUTHORIZATION_ENDPOINT = 'https://www.facebook.com/v2.8/dialog/oauth';
	$TOKEN_ENDPOINT         = 'https://graph.facebook.com/v2.8/oauth/access_token';

	$client = new \OAuth2\Client( $oauth->facebook->app_id, $oauth->facebook->secret_id );
	if ( ! isset( $_GET['code'] ) ) {
		$auth_url = $client->getAuthenticationUrl( $AUTHORIZATION_ENDPOINT, $REDIRECT_URI );
		header( 'Location: ' . $auth_url );
		die( 'Redirect' );
	} else {
		$params   = array( 'code' => $_GET['code'], 'redirect_uri' => $REDIRECT_URI );
		$response = $client->getAccessToken( $TOKEN_ENDPOINT, 'authorization_code', $params );
		parse_str( $response['result'], $info );
		$client->setAccessToken( $info['access_token'] );
		$response = $client->fetch( 'https://graph.facebook.com/1878867439052171' );
//	    TODO: reinstate this foreach after var_dump verifies actual return values
      foreach ( $response['result'] as $result ) {
			if ( $result['primary'] === true ) {
				$profileOAuthToken = $result[''];
				break;
			}
		}
		var_dump( $response, $response['result'] );
	}

// TODO: uncomment below code after verifying var_dump data
	// get profile by email to see if it exists, if it does not then create a new one
	$profile = Profile::getProfileByProfileOAuthToken($pdo, $profileOAuthToken);
	if(empty($profile) === true) {
		// create a new profile
		$profile = new Profile(null, "Please update your profile content!", "Please update your location!");
		$profile->insert($pdo);
		$reply->message = "Welcome to GigHub! Party on!";
	} else {
		$reply->message = "So glad to see you back!";
	}
	//grab profile from database and put into a session
	$profile = Profile::getProfileByProfileOAuthToken($pdo, $profileOAuthToken);
	$_SESSION["profile"] = $profile;
	header("Location: ../../../");

} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
