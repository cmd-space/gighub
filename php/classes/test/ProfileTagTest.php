<?php
namespace Edu\Cnm\GigHub\ProfileTag\Test;

use Edu\Cnm\GigHub\{Oauth, ProfileType, Profile, Venue, Tag};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

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

		// create and insert an OAuth to own the test ProfileTag
		$this->oAuth = new OAuth(null, "Mail.ru");
		$this->oAuth->insert($this->getPDO());
		// create and sinsert an ProfileType to own the test ProfileTag
		$this->profileType = new ProfileType(null, "Musician");
		$this->profileType->insert($this->getPDO());
		// create and insertg a Profile to own the test ProfileTag
		$this->profile = new Profile(null, $this->profile->getProfileOAuthId(), $this->profile->getProfileTypeId(), "bio break", "blahblahblah", "Albuquerque", "this is a toekn", "SoundClouduser","Long Duck Dong");
		$this->profile->insert($this->getPDO());
		// create and insert a Tag to own the test
		$this->tag = new Tag(null, "sausage");
		$this->tag->insert($this->getPDO());

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

	/**
	 * test inserting a ProfileTag, editing it, and then updating it
	 **/
	public function testUpdateValidProfileTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileTag");

		// create a new ProfileTag and insert to into mySQL
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAG);
		$profileTag->insert($this->getPDO());

		// edit the ProfileTag and update it in mySQL
		$ProfileTag->setProfileTagTagId($this->VALID_PROFILETAGPROFILEID);
		$profileTag->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileTag = ProfileTag::getProfileTagByProfileTagId($this->getPDO(), $profileTag->getProfileTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileTag"));
		$this->assertEquals($pdoProfileTag->getProfileTagId(), $this->profile->TaggetProfileTagId());
		$this->assertEquals($pdoProfileTag->getProfileTagTagId(), $this->VALID_PROFILETAGPROFILEID);
	}

	/**
	 * test updating a ProfileTag that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProfileTag() {
		// create a ProfileTag, try to update it without actually updating it and watch it fail
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAG);
		$profileTag->update($this->getPDO());

	}

	/**
	 * test creating a ProfileTag and then deleting it
	 **/
	public function testDeleteValidProfileTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileTag");

		// create a new ProfileTag and insert to into mySQL
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAG);
		$profileTag->insert($this->getPDO());

		// delete the ProfileTag from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileTag"));
		$profileTag->delete($this->getPDO());

		// grab the data from mySQL and enforce the ProfileTag does not exist
		$pdoTweet = ProfileTag::getTweetByProfileTagId($this->getPDO(), $profileTag->getProfileTagId());
		$this->assertNull($pdoProfileTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profileTag"));
	}

	/**
	 * test deleting a ProfileTag that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProfileTag() {
		// create a ProfileTag and try to delete it without actually inserting it
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAG);
		$profileTag->delete($this->getPDO());
	}

	/**
	 * test grabbing a ProfileTag by profile tag tag
	 **/
	public function testGetValidProfileTagByProfileTagTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileTag");

		// create a new ProfileTag and insert to into mySQL
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAG);
		$profileTag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProfileTag::getProfileTagByProfileTagTag($this->getPDO(), $profileTag->getProfileTagTag());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Bsteider\\GigHub\\ProfileTag", $results);

		// grab the result from the array and validate it
		$pdoProfileTag = $results[0];
		$this->assertEquals($pdoProfileTag->getProfileTagId(), $this->profileTag->getProfileTagId());
		$this->assertEquals($pdoProfileTag->getProfileTagTag(), $this->VALID_PROFILETAGTAG);
	}

	/**
	 * test grabbing a ProfileTag by content that does not exist
	 **/
	public function testGetInvalidProfileTagByProfileTagTag() {
		// grab a profile tag by searching for content that does not exist
		$profileTag = ProfileTag::getProfileTagByProfileTagTag($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profileTag);
	}

	/**
	 * test grabbing all ProfileTag
	 **/
	public function testGetAllValidProfileTags() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileTag");

		// create a new ProfileTag and insert to into mySQL
		$profileTag = new ProfileTag(null, $this->profileTag->getProfileTagId(), $this->VALID_PROFILETAGTAG);
		$profileTag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = ProfileTag::getAllProfileTag($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Bsteider\\GigHub\\ProfileTag", $results);

		// grab the result from the array and validate it
		$pdoProfileTag = $results[0];
		$this->assertEquals($pdoProfileTag->getProfileTagId(), $this->profile->getProfileTagId());
		$this->assertEquals($pdoProfileTag->getProfileTagTag(), $this->VALID_PROFILETAGTAG);
	}
}