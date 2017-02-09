<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\Dconley6\GigHub\{
	Profle, PostTag, Post
};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "../classes/autoload.php");

/**
 * Full PHPUnit test for the Tag class
 *
 * This is a complete PHPUnit test of the Tag class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tag
 * @author Dante Conley <dconley6@cnm.edu>
 **/
class TagTest extends GigHubTest {

	/**
	 * content of the TagContent
	 * @var string $VALID_TAGCONTENT
	 **/
	protected $VALID_TAGCONTENT = "Yup. It's a Tag!";

	/**
	 * create dependent objects before running each test
	 **/

	public

	final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test Tag
		$this->Tag = new Profile(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->profile->getProfileId(), $this->VALID_TAGCONTENT,);
		$tag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $this->tag->getTagId());
		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAGCONTENT);

	}

	/**
	 * test inserting a Tag that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidTag() {
		// create a Tag with a non null tag id and watch it fail
		$tag = new Tag(DataDesignTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_TAGCONTENT);
		$tag->insert($this->getPDO());
	}

	/**
	 * test inserting a Tag
	 **/
	public function testInsertValidTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->profile->getProfileId(), $this->VALID_TAGCONTENT);
		$tag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $this->tag->getTagId());
		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAGONTENT);

	}

	/**
	 * test grabbing a Tag by tag content
	 **/
	public function testGetValidTagByTagContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->profile->getProfileId(), $this->VALID_TAGCONTENT);
		$tag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getTagByTagContent($this->getPDO(), $tag->getTagContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\Gighub\\Tag", $results);

		// grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $this->profile->getTagId());
		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAGCONTENT);
	}

	/**
	 * test grabbing a Tag by content that does not exist
	 **/
	public function testGetInvalidTagByTagContent() {
		// grab a tag by searching for content that does not exist
		$tag = Tag::getTagByTagContent($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $tag);
	}

	/**
	 * test grabbing all Tags
	 **/
	public function testGetAllValidTags() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tag = new Tag(null, $this->tag->getTagId(), $this->VALID_TAGCONTENT;
		$tag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getAllTagss($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\Gighub\\Test", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $this->profile->getTagId());
		$this->assertEquals($pdoTag->getTagContent(), $this->VALID_TAGCONTENT);
	}
}

