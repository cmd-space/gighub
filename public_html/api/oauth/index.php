<?php

require_once( dirname( __DIR__, 3 ) . "/vendor/autoload.php" );
require_once( dirname( __DIR__, 3 ) . "/php/classes/autoload.php" );
require_once( dirname( __DIR__, 3 ) . "/php/lib/xsrf.php" );
require_once( "/etc/apache2/capstone-mysql/encrypted-config.php" );

use Edu\Cnm\GigHub\Profile;

//verify the session, start if not active
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

//grab the MySQL connection
$pdo    = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );
$config = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
$oauth  = json_decode( $config["oauth"] );

$fb = new Facebook\Facebook( [
	'app_id'                => $oauth->facebook->app_id, // Replace {app-id} with your app id
	'app_secret'            => $oauth->facebook->secret_id,
	'default_graph_version' => 'v2.8',
] );

$helper = $fb->getRedirectLoginHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch( Facebook\Exceptions\FacebookResponseException $e ) {
// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch( Facebook\Exceptions\FacebookSDKException $e ) {
// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if ( ! isset( $accessToken ) ) {
	if ( $helper->getError() ) {
		header( 'HTTP/1.0 401 Unauthorized' );
		echo "Error: " . $helper->getError() . "\n";
		echo "Error Code: " . $helper->getErrorCode() . "\n";
		echo "Error Reason: " . $helper->getErrorReason() . "\n";
		echo "Error Description: " . $helper->getErrorDescription() . "\n";
	} else {
		header( 'HTTP/1.0 400 Bad Request' );
		echo 'Bad request';
	}
	exit;
}

// Logged in
echo '<h3>Access Token</h3>';
//var_dump( $accessToken->getValue() );

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();


// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken( $accessToken );
echo '<h3>Metadata</h3>';
//var_dump( $tokenMetadata );

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId( $oauth->facebook->app_id ); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

//var_dump( $accessToken );

if ( ! $accessToken->isLongLived() ) {
// Exchanges a short-lived access token for a long-lived one
	try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken( $accessToken );
	} catch( Facebook\Exceptions\FacebookSDKException $e ) {
		echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
		exit;
	}

	echo '<h3>Long-lived</h3>';
	var_dump( $accessToken->getValue() );
}

try {
	// Returns a `Facebook\FacebookResponse` object
	$response = $fb->get('/me?fields=id,name,email,location', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

$user = $response->getGraphUser();

$_SESSION['fbUserId'] = $user['id'];

$_SESSION['fb_access_token'] = (string) $accessToken;
//var_dump($_SESSION['fb_access_token']);
if(empty($_SESSION["fb_access_token"] || empty($_SESSION['fbUserId']) === true)) {
	throw(new \InvalidArgumentException("Please return to homepage and sign up or login", 403));
}

// logic to check if profile already exists
$profile = Profile::getProfileByProfileOAuthToken($pdo, $_SESSION['fbUserId']);

if(!empty($profile)) {
	$_SESSION['profile'] = $profile;
	$profile_id = $_SESSION['profile']->getProfileId();
	// User is logged in with a long-lived access token.
	// You can redirect them to a members-only page.
	header( 'Location: https://bootcamp-coders.cnm.edu/~mcrane2/gighub/public_html/feed' );
} else {
	// generate unique-ish username to be changed by user later
	$uniqueUserName = uniqid('user');
	// create new profile
	$userLocation = $user['location']['name'] ?? "Sonoyta, Sonora";
	$newProfile= new Profile(null, 1, 1, "change me!", "dakota fanning", $userLocation, $_SESSION['fbUserId'], "something", $uniqueUserName);
	$newProfile->insert($pdo);
	// retrieve profile id to redirect to their new profile
	$newId = $newProfile->getProfileId();
	// set session data for new profile
	$_SESSION['profile'] = $newProfile;

	// User is logged in with a long-lived access token.
	// You can redirect them to profile to update new profile
	header( 'Location: https://bootcamp-coders.cnm.edu/~mcrane2/gighub/public_html/feed');
}