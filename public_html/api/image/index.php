<?php

//grab the mySQL connection
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/gighub.ini");

//determine which HTTP method was used
$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

// Cloudinary setup. Big thanks to the sprout-swap.com team!
$config = readConfig("/etc/apache2/capstone-mysql/gighub.ini");
$cloudinary = json_decode($config["cloudinary"]);
\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

if($method === "POST") {

	// again, thanks to the team at sprout-swap.com!
	//assigning variables to the user image name, MIME type, and image extension
	$tempUserFileName = $_FILES["userImage"]["tmp_name"];
	var_dump($tempUserFileName);
	$userFileType = $_FILES["userImage"]["type"];
	var_dump($userFileType);
	$userFileExtension = strtolower(strrchr($_FILES["userImage"]["name"], "."));
	var_dump($userFileExtension);
	var_dump($_FILES);

	//upload image to cloudinary and get public id
	$cloudinaryResult = \Cloudinary\Uploader::upload($_FILES["userImage"]["tmp_name"]);

	// create new post and insert into the database
	$post = new Post(null, $requestObject->postProfileId, $requestObject->postVenueId, $requestObject->postContent, $requestObject->postCreatedDate, $requestObject->postEventDate, $cloudinaryResult["public_id"], $requestObject->postTitle);
	$post->insert($pdo);

	//update reply
	$reply->message = "Post created ok";
}