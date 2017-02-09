<?php
namespace Edu\Cnm\GigHub\OAuth\Test;

use Edu\Cnm\GigHub\OAuth;
use Edu\Cnm\GigHub\OAuth\{OAuth};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the OAuth class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete, because ALL mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see OAuth
 * @author Mason Crane <cmd-space.com>
 */
class OAuthTest extends GigHubTest {
	/**
	 * service name of the OAuth
	 * @var string $VALID_SERVICENAME
	 */
	protected $VALID_SERVICENAME = "PHPUnit test passing????";

	/**
	 * test inserting a valid OAuth and verify that the actual mySQL data matches
	 */
	public function testInsertValidOAuth() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("oauth");

		// create a new OAuth and insert it into mySQL
		$oAuth = new OAuth(null, $this->oAuth->getOAuthId(), $this->VALID_SERVICENAME);
		$oAuth->insert($this->getPDO());

		// grab the data from mySQL and enforce fields match expectations... or die
		$pdoOAuth = OAuth::getOAuthByOAuthId($this->getPDO(), $oAuth->getOAuthId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("oAuth"));
		$this->assertEquals($pdoOAuth->getOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoOAuth->getOAuthServiceName(), $this->VALID_SERVICENAME);
	}

	/**
	 * test inserting an OAuth that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testInsertInvalidOAuth() {
		// create an OAuth with a non-null oAuth id and see the hackers cry
		$oAuth = new OAuth(GigHubTest::INVALID_KEY, $this->oAuth->getOAuthId(), $this->VALID_SERVICENAME);
		$oAuth->insert($this->getPDO());
	}

	/**
	 * test getting an OAuth by OAuth service name
	 */
	public function testGetValidOAuthByServiceName() {

	}
}