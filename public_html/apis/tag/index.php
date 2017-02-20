<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\Tag;


/**
 * api for the Tag class
 *
 * @author Brandon Steider find me on myspace <bsteider@cnm.edu>
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
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/tag.ini");

		//determine which HTTP method was used
		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that tag is returned, otherwise all tags are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific tag or all tweets and update reply
		if(empty($id) === false) {
			$tweet = Tag::getTagByTagId($pdo, $id);
			if($tag !== null) {
				$reply->data = $tag;
			}
			if($tags !== null) {
				$reply->data = $tags;
			}
		} else if(empty($content) === false) {
			$tags = Tag::getTagByTagContent($pdo, $content);
			if($tag !== null) {
				$reply->data = $tags;
			}
		} else {
			$tags = Tags::getAllTags($pdo);
			if($tags !== null) {
				$reply->data = $tags;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure tag content is available (required field)
		if(empty($requestObject->tagContent) === true) {
			throw(new \InvalidArgumentException ("No content for Tag.", 405));
		}

		// make sure tweet date is accurate (optional field)
		if(empty($requestObject->tweetDate) === true) {
			$requestObject->tweetDate = new \DateTime();
		}

		//  make sure profileId is available
		if(empty($requestObject->profileId) === true) {
			throw(new \InvalidArgumentException ("No Profile ID.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {