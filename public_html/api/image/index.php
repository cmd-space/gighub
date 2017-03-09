<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * api for the images
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
	$pdo = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );

//determine which HTTP method was used
	$method = array_key_exists( "HTTP_X_HTTP_METHOD", $_SERVER ) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

// Cloudinary setup. Big thanks to the sprout-swap.com team!
	$config     = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
	$cloudinary = json_decode( $config["cloudinary"] );
	\Cloudinary::config( [
		"cloud_name" => $cloudinary->cloudName,
		"api_key"    => $cloudinary->apiKey,
		"api_secret" => $cloudinary->apiSecret
	] );

	if ( $method === "POST" ) {

		// again, thanks to the team at sprout-swap.com!
		//assigning variables to the user image name, MIME type, and image extension
		$tempUserFileName = $_FILES["userImage"]["tmp_name"];
		var_dump( $tempUserFileName );
		$userFileType = $_FILES["userImage"]["type"];
		var_dump( $userFileType );
		$userFileExtension = strtolower( strrchr( $_FILES["userImage"]["name"], "." ) );
		var_dump( $userFileExtension );
		var_dump( $_FILES );

		//upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload( $_FILES["userImage"]["tmp_name"] );

		// create new post and insert into the database
		$post = new Post( null, $requestObject->postProfileId, $requestObject->postVenueId, $requestObject->postContent, $requestObject->postCreatedDate, $requestObject->postEventDate, $cloudinaryResult["public_id"], $requestObject->postTitle );
		$post->insert( $pdo );

		//update reply
		$reply->message = "Post created ok";
	}
}
// update reply with exception information
catch( Exception $exception ) {
	$reply->status  = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch( TypeError $typeError ) {
	$reply->status  = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header( "Content-type: application/json" );
if ( $reply->data === null ) {
	unset( $reply->data );
}

// encode and return reply to front end caller
echo json_encode( $reply );