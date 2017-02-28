<?php

require_once( dirname( __DIR__, 3 ) . "/vendor/autoload.php" );
require_once( dirname( __DIR__, 3 ) . "/php/classes/autoload.php" );
require_once( "/etc/apache2/capstone-mysql/encrypted-config.php" );

try {


//grab the MySQL connection
	$pdo    = connectToEncryptedMySQL( "/etc/apache2/capstone-mysql/gighub.ini" );
	$config = readConfig( "/etc/apache2/capstone-mysql/gighub.ini" );
	$oauth  = json_decode( $config["oauth"] );

	const REDIRECT_URI           = 'https://bootcamp-coders.cnm.edu/~jramirez98/gighub/public_html/api/oauth/';
	const AUTHORIZATION_ENDPOINT = 'https://www.facebook.com/v2.8/dialog/oauth';
	const TOKEN_ENDPOINT         = 'https://graph.facebook.com/v2.8/oauth/access_token';

	$client = new \OAuth2\Client( $oauth->facebook->clientId, $oauth->facebook->clientKey );
	if ( ! isset( $_GET['code'] ) ) {
		$auth_url = $client->getAuthenticationUrl( AUTHORIZATION_ENDPOINT, REDIRECT_URI );
		header( 'Location: ' . $auth_url );
		exit;
	} else {
		$params   = array( 'code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI );
		$response = $client->getAccessToken( TOKEN_ENDPOINT, 'authorization_code', $params );
		parse_str( $response['result'], $info );
		$client->setAccessToken( $info['access_token'] );
		$response = $client->fetch( 'https://graph.facebook.com/me' );
		var_dump( $response, $response['result'] );
	}
} catch(\Exception $exception) {
	throw(new);
}
//How can I add a new Grant Type ?
//================================
//Simply write a new class in the namespace OAuth2\GrantType. You can place the class file under GrantType.
//Here is an example :

namespace OAuth2\GrantType;

/**
 * MyCustomGrantType Grant Type
 */
class MyCustomGrantType implements IGrantType {
	/**
	 * Defines the Grant Type
	 *
	 * @var string  Defaults to 'my_custom_grant_type'.
	 */
	const GRANT_TYPE = 'my_custom_grant_type';

	/**
	 * Adds a specific Handling of the parameters
	 *
	 * @return array of Specific parameters to be sent.
	 *
	 * @param  mixed $parameters the parameters array (passed by reference)
	 */
	public function validateParameters( &$parameters ) {
		if ( ! isset( $parameters['first_mandatory_parameter'] ) ) {
			throw new \Exception( 'The \'first_mandatory_parameter\' parameter must be defined for the Password grant type' );
		} elseif ( ! isset( $parameters['second_mandatory_parameter'] ) ) {
			throw new \Exception( 'The \'seconde_mandatory_parameter\' parameter must be defined for the Password grant type' );
		}
	}
}

//call the OAuth client getAccessToken with the grantType you defined in the GRANT_TYPE constant, As following :
$response = $client->getAccessToken( TOKEN_ENDPOINT, 'my_custom_grant_type', $params );
