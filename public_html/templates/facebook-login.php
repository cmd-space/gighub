<?php

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 2) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//grab the MySQL connection
//$pdo    = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );
$config = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
$oauth  = json_decode( $config["oauth"] );

$fb = new Facebook\Facebook([
'app_id' => $oauth->facebook->app_id, // Replace {app-id} with your app id
'app_secret' => $oauth->facebook->secret_id,
'default_graph_version' => 'v2.8'
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'user_location']; // Optional permissions
//TODO change the url to actual api url
$loginUrl = $helper->getLoginUrl('https://bootcamp-coders.cnm.edu/~jramirez98/gighub/public_html/api/oauth/', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '" class="btn btn-info"><i class="fa fa-facebook-official"></i>Sign up/Login with Facebook!</a>';