<?php

require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\GigHub\Profile;

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//grab the MySQL connection
$pdo    = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );
$config = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
$oauth  = json_decode( $config["oauth"] );

$provider = new \League\OAuth2\Client\Provider\Facebook([
'clientId'                => $oauth->facebook->app_id,    // The client ID assigned to you by the provider
'clientSecret'            => $oauth->facebook->secret_id,   // The client password assigned to you by the provider
'redirectUri'             => 'https://bootcamp-coders.cnm.edu/~jramirez98/gighub/public_html/api/profile',
'urlAuthorize'            => 'https://www.facebook.com/v2.8/dialog/oauth',
'urlAccessToken'          => 'https://graph.facebook.com/v2.8/oauth/access_token',
'urlResourceOwnerDetails' => 'https://bootcamp-coders.cnm.edu/~jramirez98/gighub/public_html/facebook-login'
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

// Fetch the authorization URL from the provider; this returns the
// urlAuthorize option and generates and applies any necessary parameters
// (e.g. state).
$authorizationUrl = $provider->getAuthorizationUrl();

// Get the state generated for you and store it to the session.
$_SESSION['oauth2state'] = $provider->getState();

// Redirect the user to the authorization URL.
header('Location: ' . $authorizationUrl);
exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

if (isset($_SESSION['oauth2state'])) {
unset($_SESSION['oauth2state']);
}

exit('Invalid state');

} else {

try {

// Try to get an access token using the authorization code grant.
$accessToken = $provider->getAccessToken('authorization_code', [
'code' => $_GET['code']
]);

// We have an access token, which we may use in authenticated
// requests against the service provider's API.
echo 'Access Token: ' . $accessToken->getToken() . "<br>";
echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

// Using the access token, we may look up details about the
// resource owner.
$resourceOwner = $provider->getResourceOwner($accessToken);

var_export($resourceOwner->toArray());

// The provider provides a way to get an authenticated API request for
// the service, using the access token; it returns an object conforming
// to Psr\Http\Message\RequestInterface.
$request = $provider->getAuthenticatedRequest(
'GET',
'https://graph.facebook.com/me',
$accessToken
);

} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

// Failed to get the access token or user details.
exit($e->getMessage());

}

}