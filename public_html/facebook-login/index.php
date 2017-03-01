<?php

require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//grab the MySQL connection
//$pdo    = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );
$config = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
$oauth  = json_decode( $config["oauth"] );

$fb = new Facebook\Facebook([
'app_id' => $oauth->facebook->app_id, // Replace {app-id} with your app id
'app_secret' => $oauth->facebook->secret_id,
'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
//TODO change the url to actual api url
$loginUrl = $helper->getLoginUrl('https://bootcamp-coders.cnm.edu/~jramirez98/gighub/public_html/api/oauth/', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';