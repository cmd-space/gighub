<?php

require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\Tag;


/**
 * api for the Tag class
 *
 * @author Brandon Steider aka Saltine <bsteider@cnm.edu>
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
	$content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that Tag is returned, otherwise all Tags are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific Tag or all Tags and update reply
		if(empty($id) === false) {
			$tag = Tag::getTagByTagId($pdo, $id);
			if($tag !== null) {
				$reply->data = $tag;
			}
		} else if(empty($content) === false) {
			$tags = Tag::getTagByTagContent($pdo, $content);
			if($tags !== null) {
				$reply->data = $tags;
			}
		} else {
			$tags = Tag::getAllTags($pdo);
			if($tags !== null) {
				$reply->data = $tags;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure tweet content is available (required field)
		if(empty($requestObject->tagContent) === true) {
			throw(new \InvalidArgumentException ("No Tag content.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the tag to update
			$tag = Tag::getTagByTagId($pdo, $id);
			if($tag === null) {
				throw(new RuntimeException("Tag does not exist", 404));
			}

			// update all attributes
			$tag->setTagContent($requestObject->tagContent);
			$tag->update($pdo);

			// update reply
			$reply->message = "Tag updated OK";

		} else if($method === "POST") {

			// create new tag and insert into the database
			$tag = new Tag(null, $requestObject->tagContent);
			$tag->insert($pdo);

			// update reply
			$reply->message = "Tag created OK";
		}
		// TODO: Should we add a DELETE in our PDO?
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