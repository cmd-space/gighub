<?php
namespace Edu\Cnm\Bsteider\Gighub\Test;

use Edu\Cnm\Bsteider\Gighub\{Post, Tag};
use Edu\Cnm\GigHub\PostTag;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHPUit test for the PostTag class
 *
 * This is a complete PHPUnit test of the PostTag class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see PostTag
 * @author Brandon Steider <bsteider@cnm.edu>
 **/
class PostTagTest extends GigHubTest {
	/**
	 * content of the PostTag
	 * @var string $VALID_POSTTAG
	 **/
	protected $VALID_POSTTAG = "PHPUnit test passing";
	/**
	 * content of the updated PostTagId
	 * @var string $VALID_POSTTAGID
	 **/
	protected $VALID_POSTTAGID = "PHPUnit test still passing";
	/**
	 * id of the post tag tag id
	 * @var string $VALID_POSTTAGTAGID
	 **/
	protected $VALID_POSTTAGTAGID = null;
	/**
	 * id of the post tag post id
	 * @var string $VALID_POSTTAGPOSTID
	 **/
	protected $VALID_POSTTAGPOSTID = null;
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test PostTag
		$this->profile = new Profile(null, "@phpunit", "test@phpunit.de", "121255512120");
		$this->profile-insert($this->getPDO());

		// calculate the data (just use the time the unit test was setup)
		$this->VALID_PROFILEDATE = new \DateTime();
			/***********************
			 * do i need the date because the post tag and profile tag classes dont use date?
			 *************************/
	}

	/**
	 * test inserting a valid postTag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPostTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new post tag and insert into mySQL
		$postTag = new PostTag(null, $this->profile->getProfileId(), $this->VALID_POSTTAGCONTENT, $this->VALID_POSTTAGDATE)
			/*****************************
			 * FER REAL THO DO I NEED THIS DATE STUFF
			 *
			 *
			 *
			 *
			 *
			 *
			 *
			 *
			 *****************************/
	}
}