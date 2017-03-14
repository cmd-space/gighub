<?php

require_once( dirname( __DIR__, 3 ) . "/vendor/autoload.php" );
require_once( dirname( __DIR__, 3 ) . "/php/classes/autoload.php" );
require_once( dirname( __DIR__, 3 ) . "/php/lib/xsrf.php" );
require_once( "/etc/apache2/capstone-mysql/encrypted-config.php" );

use Edu\Cnm\GigHub\{
	Profile, Post
};

/**
 * api for the images
 *
 * @author Mason Crane <cmd-space.com>
 **/

//verify the session, start if not active
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

//prepare an empty reply
$reply         = new stdClass();
$reply->status = 200;
$reply->data   = null;

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

	$profileId = filter_input( INPUT_POST, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
	$postId    = filter_input( INPUT_POST, "postId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );

	//make sure the id is valid for methods that require it
	if ( ( $method === "POST" ) &&
	     (
		     ( empty( $profileId ) === true || $profileId < 0 ) &&
		     ( empty( $postId ) === true || $postId < 0 )
	     )
	) {
		throw( new InvalidArgumentException( "id cannot be empty or negative", 405 ) );
	}

	if ( $method === "POST" ) {

		verifyXsrf();
		$requestContent = file_get_contents( "php://input" );
		$requestObject  = json_decode( $requestContent );

		// TODO: accept one of three parameters: profile id, venue id & post id use:... throw exception if nothing
		// TODO: INPUT_POST for all ids, figure out what id it belongs to
		// TODO: dynamic binding if post, get by postid, use foo object name run update method no matter what

		if ( ! empty( $profileId ) ) {

			// Make sure that only one can edit one's own profile <--- referenced from https://github.com/zlaudick/dev-connect
			// retrieve the profile to update
			$profile = Profile::getProfileByProfileId( $pdo, $profileId );
			if ( $profile === null ) {
				throw( new RuntimeException( "Profile does not exist", 404 ) );
			}

			if ( empty( $_SESSION["profile"] ) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId() ) {
				throw( new \InvalidArgumentException( "You do not have permission to edit this profile image... Login, why don't you?", 403 ) );
			} else {
				// again, thanks to the team at sprout-swap.com!
				//assigning variables to the user image name, MIME type, and image extension
				$tempUserFileName = $_FILES["file"]["tmp_name"];
				var_dump( $tempUserFileName );
				$userFileType = $_FILES["file"]["type"];
				var_dump( $userFileType );
				$userFileExtension = strtolower( strrchr( $_FILES["file"]["name"], "." ) );
				var_dump( $userFileExtension );
				var_dump( $_FILES );

				//upload image to cloudinary and get public id
				$cloudinaryResult = \Cloudinary\Uploader::upload( $_FILES["file"]["tmp_name"] );

				// update all attributes
				$profile->setProfileBio( $requestObject->profileBio );
				$profile->setProfileImageCloudinaryId( $cloudinaryResult["public_id"] );
				$profile->setProfileLocation( $requestObject->profileLocation );
				$profile->setProfileOAuthToken( $requestObject->profileOAuthToken );
				$profile->setProfileSoundCloudUser( $requestObject->profileSoundCloudUser );
				$profile->setProfileUserName( $requestObject->profileUserName );
				$profile->update( $pdo );

				// update reply
				$reply->message = "Profile image updated OK";
			}
		}

		if ( ! empty( $postId ) ) {
			// Make sure that only one can edit one's own post <--- referenced from https://github.com/zlaudick/dev-connect
			// retrieve the post to update
			$post = Post::getPostByPostId( $pdo, $postId );
			if ( $post === null ) {
				throw( new RuntimeException( "Post does not exist", 404 ) );
			}

			$postProfileId = $post->getPostProfileId();

			if ( empty( $_SESSION["profile"] ) === true || $_SESSION["profile"]->getProfileId() !== $post->getPostByPostProfileId( $pdo, $postProfileId ) ) {
				throw( new \InvalidArgumentException( "You do not have permission to edit this post image... Login, why don't you?", 403 ) );
			} else {
				// again, thanks to the team at sprout-swap.com!
				//assigning variables to the user image name, MIME type, and image extension
				$tempUserFileName = $_FILES["file"]["tmp_name"];
				var_dump( $tempUserFileName );
				$userFileType = $_FILES["file"]["type"];
				var_dump( $userFileType );
				$userFileExtension = strtolower( strrchr( $_FILES["file"]["name"], "." ) );
				var_dump( $userFileExtension );
				var_dump( $_FILES );

				//upload image to cloudinary and get public id
				$cloudinaryResult = \Cloudinary\Uploader::upload( $_FILES["file"]["tmp_name"] );

				// update all attributes
				$post->setPostProfileId( $requestObject->postProfileId );
				$post->setPostVenueId( $requestObject->postVenueId );
				$post->setPostContent( $requestObject->postContent );
				$post->setPostCreatedDate( $requestObject->postCreatedDate );
				$post->setPostEventDate( $requestObject->postEventDate );
				$post->setPostImageCloudinaryId( $cloudinaryResult["public_id"] );
				$post->setPostTitle( $requestObject->postTitle );

				// update reply
				$reply->message = "Post updated ok";
			}
		}
	}
} // update reply with exception information
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