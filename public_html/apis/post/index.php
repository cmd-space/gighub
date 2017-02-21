<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once "/etc/apache2/GigHub-mysql/encrypted-config.php";

use Edu\Cnm\Jramirez98\GigHub;

/**
 *  api for post class
 *
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 */

// check session status. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Check an empty reply
$reply = new stdClass();
$reply->status = 200;

// handle GET request - if id is present, that post is returned, otherwise all posts are returned
	if($method === "GET") {

		//gets a post by content
		if(empty($content) === false) {
			$post = Post::getPostByPostContent($pdo, $content);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} else if(empty($postId) === false) {
			$posts = Post::getPostByPostId($pdo, $postId);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} else if(empty($profileId) === false) {
			$posts = Post::getPostByPostProfileId($pdo, $profileId);
			if($posts !== null) {
				$reply->data = $posts;
			}
				}
		} else {
			$posts = Post::getAllPosts($pdo);
			if($posts !== null) {
				$reply->data = $posts;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		// make sure post content is available (require field)
		if(empty($requestObject->postContent) === true) {
			throw(new \InvalidArgumentException ("No content for post.", 405));
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
	if(empty($requestObject->venueId) === true) {
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
	}