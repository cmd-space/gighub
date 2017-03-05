<?php

require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\{Profile, Post};

/**
 *  api for post class
 *
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 */

// verify session status. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

// Here we create a new stdClass named $reply. a stdClass is basically an empty bucket we can use to store things in.
//we will use this object named $reply to store the results of the call to our API. the status 200 line line adds a state variable to $reply called status and initializes with the integer 200 (success code). the proceeding line adds a state variable to $reply called data. This is where the result of the API call will be stored. we will also update $reply->message as we proceed through the API.

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/gighub.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$venueId = filter_input(INPUT_GET, "venueId", FILTER_VALIDATE_INT);
	$content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$title = filter_input(INPUT_GET, "title", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventDate= filter_input(INPUT_GET, "eventDate", FILTER_SANITIZE_STRING);
	$imageCloudinaryId= filter_input(INPUT_GET, "imageCloudinaryId",FILTER_SANITIZE_STRING);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

// handle GET request - if id is present, that post is returned, otherwise all posts are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a post by content
	if(empty($id) === false) {
		$post = Post::getPostByPostId($pdo, $id);
		if($post !== null) {
			$reply->data = $post;
		}
	} else if(empty($profileId) === false) {
		$posts = Post::getPostByPostProfileId($pdo, $profileId);
		if($posts !== null) {
			$reply->data = $posts;
		}
	} else if(empty($content) === false) {
		$posts = Post::getPostByPostContent($pdo, $content);
		if($posts !== null) {
			$reply->data = $posts;
		}
	} else {
		$posts = Post::getAllPosts($pdo);
		if($posts !== null) {
			$reply->data = $posts;
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

	// make sure post content is available (require field)
	if(empty($requestObject->postContent) === true) {
		throw(new \InvalidArgumentException ("this is shitty.", 405));
	}
	// make sure post created  date is accurate (optional field)
	if(empty($requestObject->postCreatedDate) === true) {
		$requestObject->postCreatedDate = new \DateTime();
	}
	// make sure post Event date is accurate (optional field)
	if(empty($requestObject->postEventDate) === true) {
		$requestObject->postEventDate = new \DateTime();
	}
	// make sure profileId is available
	if(empty($requestObject->postProfileId) === true) {
		throw(new \InvalidArgumentException ("No Profile ID", 405));
	}
	// make sure VenueId is available
	if(empty($requestObject->postVenueId) === true) {
		throw(new \InvalidArgumentException ("No Venue ID", 405));
	}
	// make sure the is a ImageCloudinaryId available
	if(empty($requestObject->postImageCloudinaryId) === true) {
		throw(new \InvalidArgumentException ("No Venue ID", 405));
	}
	// make sure there is a PostTitle in the Post
	if(empty($requestObject->postTitle) === true) {
		throw(new \InvalidArgumentException ("No content for Title", 405));
	}

	// perform the actual put or post
	if($method === "PUT") {
		// retrieve the post to update
		$post = Post::getPostByPostId($pdo, $id);
		if($post === null) {
			throw(new RuntimeException("Post does no exist", 404));
		}
			// update all attributes
			$post->setPostProfileId($requestObject->postProfileId);
			$post->setPostVenueId($requestObject->postVenueId);
			$post->setPostContent($requestObject->postContent);
			$post->setPostCreatedDate($requestObject->postCreatedDate);
			$post->setEventDate($requestObject->postEventDate);
			$post->setImageCloudinaryId($requestObject->postImageCloudinaryId);
			$post->setPostTitle($requestObject->postTitle);

			// update reply
			$reply->message = "Post updated ok";

		} else if($method === "POST") {

			// create new post and insert into the database
			$post = new Post(null, $requestObject->postProfileId, $requestObject->postVenueId, $requestObject->postContent, $requestObject->postCreatedDate, $requestObject->postEventDate, $requestObject->postImageCloudinaryId, $requestObject->postTitle);
			$post->insert($pdo);

			//update reply
			$reply->message = "Post created ok";
		}

	} else if($method === "DELETE") {
		verifyXsrf();

		// Make sure that only one can edit one's own profile <--- referenced from https://github.com/zlaudick/dev-connect
		$profile = Profile::getProfileByProfileOAuthToken($pdo, $oAuthToken);
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileOAuthToken() !== $profile->getProfileOAuthToken()) {
			throw(new \InvalidArgumentException("You do not have permission to edit this profile... Login, why don't you?", 403));
		}

		//retrieve the post to be deleted
		$post = Post::getPostByPostId($pdo, $id);
		if($post === null) {
			throw(new RuntimeException("post does not exist", 404));
		}

			// delete post
			$post->delete($pdo);

			// update reply
			$reply->message = "Post deleted Ok";

		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}

		// update reply with exception information
	} catch(Exception $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	} catch(TypeError $typeError) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}

	header("Content-Type: application/json");
	if($reply->data === null) {
		unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);