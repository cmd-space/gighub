<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\bsteider\GigHub\{Profile, Tag};

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHPUnit test for the ProfileTag class
 *
 * This is a complete PHPUnit test of the ProfileTag class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProfileTag
 * @author Brandon Steider <bsteider@cnm.edu>
 **/

class ProfileTagTest extends GigHubTest {
	/**
	 * content of the ProfileTag
	 * @var string $VALID_PROFILETAGTAGID
	 **/
	protected $VALID_PROFILETAGTAG = "PHPUnit test passing";
	/**
	 * content of the updated ProfileTagTagId
	 * @var string $VALID_PROFILETAGTAGID
	 **/
	protected $VALID_PROFILETAGPROFILEID = "PHPUnit test still passing";
	/**
	 *WORDS
	 **/

	protected $profile = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a ProfileTag to own the test ProfileTag
		$this->profileTag = new ProfileTag(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->profileTag->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ProfileTag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfileTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileTag");

		// create a new ProfileTag and insert to into mySQL
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileId(), $this->VALID_PROFILETAGTAGID);
		$profiletag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileTag = ProfileTag::getProfileTagByProfileTagId($this->getPDO(), $profileTag->getProfileTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileTag"));
		$this->assertEquals($pdoTweet->getProfileTagId(), $this->profileTag->getProfileTagId());
		$this->assertEquals($pdoTweet->getProfileTagProfile(), $this->VALID_PROFILETAGTAG);

	}

	/**
	 * test inserting a ProfileTag that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfileTag() {
		// create a ProfileTag with a non null profileTag id and watch it fail
		$profileTag = new ProfileTag(GigHubTest::INVALID_KEY, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAGID);
		$profileTag->insert($this->getPDO());
	}