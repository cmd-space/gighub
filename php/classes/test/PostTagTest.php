<?php
namespace Edu\Cnm\Gighub\Test;

use Edu\Cnm\Gighub\{OAuth, Post, Profile, Tag, ProfileType};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

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
	protected $VALID_POSTTAGTAG = "PHPUnit test still passing";
	/**
	 * id of the post tag tag id
	 * @var string $VALID_POSTTAGTAGID
	 **/
	protected $VALID_POSTTAGTAGID = null;
	/**
	 * id of the post tag post id
	 * @var Post
	 **/
	private $post = null;
	/**
	 * create dependent objects before running each  test
	 * @var OAuth
	 **/
	private $OAuth = null;

	/**
	 * create dependent objects to own the test
	 * @var ProfileType
	 **/
	 private $profileType = null;

	/**
	 * content of the tag class
	 * @var string for tag
	 **/
	protected $tag = null;

	/**
	 * create dependent objects to own the test
	 * @var Profile
	 **/

	private $profile = null;

	/**
	 * create dependent objects
	 * @var venue
	 **/
	private $venue = null;

	/**
	 * create object
	 * @var profile tag
	 **/
	private $profileTag = null;

	/**
	 * create date
	 * @var VALID_DATE
	 **/
	protected $VALID_DATE = null;

	/**
	 * create date
	 * @var VALID_DATE2
	 **/
	protected $VALID_DATE2 = null;


	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert an OAuth to own the test ProfileTag
		$this->OAuth = new OAuth(null, "Mail.ru");
		$this->OAuth->insert($this->getPDO());

		// create and insert a Profile to own the test ProfileTag
		$this->profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), "bio break", "blahblahblah", "Albuquerque", "this is a toekn", "SoundClouduser","Long Duck Dong");
		$this->profile->insert($this->getPDO());

		// create and insert a venue
		$this->venue = new Venue(null, "yah");
		$this->venue->insert($this->getPDO());

		// create dependent profile type
		$this->profileType = new ProfileType(null, "venue");
		$this->profileType->insert($this->getPDO());

	}

	/**
	 * test inserting a valid ProfileTag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPostTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

//		var_dump($this->post);

		// create a new PostTag and insert to into mySQL
		$postTag = new PostTag($this->post->getPostId(), $this->tag->getTagId());
		$postTag->insert($this->getPDO());

//		var_dump($postTag);

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPostTag = PostTag::getPostTagByPostTagTagIdAndPostTagPostId($this->getPDO(), $postTag->getPostTagPostId(), $postTag->getPostTagTagId());
		var_dump($pdoPostTag);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$this->assertEquals($pdoPostTag->getPostTagPostId(), $postTag->getPostTagPostId());
		$this->assertEquals($pdoPostTag->getPostTagTagId(), $postTag->getPostTagTagId());

	}

	/**
	 * test inserting a valid postTag and verify that the actual mySQL data matches
	 **/
	//public function testInsertinvalidPostTag() {
		// count the number of rows and save it for later
		//$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new post tag and insert into mySQL
		//$postTag = new PostTag(null, $this->tag->gettagId(), $this->VALID_POSTTAGTAG);
			
			// grab the data from mySQL and enforce the fields match our expectations
		//$pdoPostTag= PostTag::getPostTagbyPostTagId($this->getPDO(), $postTag->getPostTagId());
		//$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		//$this->assertEquals($pdoPostTag->gettagId(), $this->postTag->getPostTagId());
		//$this->assertEquals($pdoPostTag->getPostTagTagId(), $this->VALID_POSTTAGTAGID);
	}

	/**
	 * test inserting a PostTag that already exists
	 *
	 * @expdctedException PDOException
	 **/
	//public function testUpdateValidPostTag() {
		// count the number of rows and save it for later
		//$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new PostTag and insert into mySQL
		//$postTag = new PostTag($this->postTag->getPostTagPostId(), $this->postTag->getPostTagId());
		//$postTag->insert($this->getPDO());

		// edit the PostTag and update it in mySQL
		//$postTag->setPostTagTagId($this->VALID_POSTTAGPOSTID);
		//$postTag->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		//$pdoPostTag = PostTag::getPostTagByPostTagId($this->getPDO(), //$postTag->getPostTagId());
		//$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		//$this->assertEuals($pdoPostTag->getPostTagPostId(), //$this->postTagPost->getPostTagPostId());
		//$this->assertEquals($pdoPostTag->getPostTagTagId(), //$this->VALID_POSTTAGPOASTID);
	//}
	/**
	 * test updating a PostTat that does not exist
	 *
	 * @expectedException PDOException
	 **/
	//public function testUpdateInvalidPostTag() {
		// create a PostTag, try to update it without actually updating it and watch it fail
		//$postTag = new PostTag(null, $this->postTagTagId->getPostTagTagId());
		//$postTag->update($this->getPDO());
	// }
	/**
	 * test creating a PostTag and then deleting it
	 **/
	public function testDeleteValidPostTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new PostTag and insert to into mySQL
		$postTag = new PostTag(null, $this->postTagTagId->getPostTagTagId()$this->tag->getTagId());
		$postTag->insert($this->getPDO());

		// delete the PostTag from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$postTag->delete($this->getPDO());

		// grab the data from mySQL and enforce the PostTag does not exist
		$pdoPostTag = PostTag::getPostTagByPostTagTagIdAndPostTagPostId($this->getPDO(), $postTag->getPostTagPostId(), $postTag->getPostTagTagId());
		$this->assertNull($pdoPostTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("postTag"));
	}
	/**
	 * test deleting a PostTag that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidPostTag() {
		// create a PostTag and try to delete it without actually inserting it
	$postTag = new PostTag(GigHubTest::INVALID_KEY, GigHubTest::INVALID_KEY);
		$postTag->delete($this->getPDO());
	}

	/**
	 * test grabbing a PostTag by postTag content
	 **/
	public function testGetValidPostTagByPostTagTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new PostTag and insert to into mySQL
		$postTag = new PostTag(null, $this->postTagTag->getPostTagTagId(), $this->VALID_POSTTAGCONTENT);
		$postTag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = PostTag::getPostTagByPostTagTagId($this->getPDO(), $postTag->getPostTagTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Gighub\\PostTag", $results);

		// grab the result from the array and validate it
		$pdoPostTag = $results[0];
		$this->assertEquals($pdoPostTag->getPostTagTagId(), $this->postTag->getPostTagtagId());
		$this->assertEquals($pdoPostTag->getPostTagTagId(), $this->VALID_POSTTAGTAG);
	}
	/**
	 * test grabbing a PostTag by content that does not exist
	 **/
	public function testGetInvalidPostTagByPostTagTagId() {
		// grab a postTag by searching for content that does not exist
	$postTag = PostTag::getPostTagsByPostTagTagId($this->getPDO(), GigHubTest::INVALID_KEY);
		$this->assertCount(0, $postTag);
	}
	/**
	 * test grabbing all PostTags
	 **/
	public function testGetAllValidPostTags() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new PostTag and insert to into mySQL
		$postTag = new PostTag(null, $this->postTagPostId->getPostTagPostId());
		$postTag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = PostTag::getAllPostTags($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Gighub\\PostTag", $results);

		// grab the result from the array and validate it
		$pdoPostTag = $results[0];
		$this->assertEquals($pdoPostTag->getPostTagPostId(), $this->postTagPostId->getPostTagPostId());
		$this->assertEquals($pdoPostTag->getPostTagTag(), $this->VALID_POSTTAGTAGID);

	}


	/********************************************************
	 * HELLO HI
	 **
	 ***
	 ****.
	 *****
	 ******.
	 *******
	 ********
	 *********
	 **********
	 ***********
	 ************
	 *************
	 **************
	 ***************
	 ****************
	 *****************
	 ******************
	 *******************
	 ********************
	 *********************
	 **********************
	 ***********************
	 ************************
	 *************************
	 **************************
	 ***************************
	 ****************************
	 *****************************
	 ******************************
	 *******************************
	 ********************************
	 *********************************
	 **********************************
	 ***********************************
	 ************************************
	 *************************************
	 **************************************
	 ***************************************
	 ****************************************
	 *****************************************
	 ******************************************
	 *******************************************
	 ********************************************
	 *********************************************
	 **********************************************
	 ***********************************************
	 ************************************************
	 *************************************************
	 **************************************************
	 ***************************************************
	 ****************************************************
	 *****************************************************
	 ******************************************************
	 *******************************************************
	 ********************************************************
	 *********************************************************
	 **********************************************************
	 ***********************************************************
	 ************************************************************
	 *************************************************************
	 **************************************************************
	 ***************************************************************
	 ****************************************************************
	 *****************************************************************
	 ******************************************************************
	 *******************************************************************
	 ********************************************************************
	 *********************************************************************
	 **********************************************************************
	 ***********************************************************************
	 ************************************************************************
	 *************************************************************************
	 **************************************************************************
	 ***************************************************************************
	 ****************************************************************************
	 *****************************************************************************
	 *******************************************************************************
	 ********************************************************************************
	 *********************************************************************************/