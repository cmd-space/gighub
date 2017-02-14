<?php
namespace Edu\Cnm\Gighub\Test;

use Edu\Cnm\Gighub\{Post, Tag};

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

		// create and insert an OAuth to own the test ProfileTag
		$this->oAuth = new OAuth(null, "Mail.ru");
		$this->oAuth->insert($this->getPDO());

		// fix tag object, missing state variables
		$this->tag = new tag(null, "@phpunit", "test@phpunit.de", "121255512120");
		$this->tag->insert($this->getPDO());

		//create and insert a Post to own the test
		$this->tag = new Post(null, "@that one place");
		$this->tag->insert($this->getPDO());

		// create and insert a Tag to own the test
		$this->tag = new Tag(null, "sausage");
		$this->tag->insert($this->getPDO());
	}

	/**
	 * test inserting a valid postTag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPostTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new post tag and insert into mySQL
		$postTag = new PostTag(null, $this->tag->gettagId(), $this->VALID_POSTTAGTAG);
			
			// grab the data from mySQL and enforce the fields match our expectations
		$pdoPostTag= PostTag::getPostTagbyPostTagId($this->getPDO(), $postTag->getPostTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$this->assertEquals($pdoPostTag->gettagId(), $this->postTag->getPostTagId());
		$this->assertEquals($pdoPostTag->getPostTagTagId(), $this->VALID_POSTTAGTAGID);
	}

	/**
	 * test inserting a PostTag that already exists
	 *
	 * @expdctedException PDOException
	 **/
	public function testUpdateValidPostTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new PostTag and insert into mySQL
		$postTag = new PostTag( $this->postTag->getPostTagTagId(), $this->postTag->getPostTagPostId());
		$postTag->insert($this->getPDO());

		// edit the PostTag and update it in mySQL
		$postTag->setPostTagTagId($this->VALID_POSTTAGPOSTID);
		$postTag->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPostTag = PostTag::getPostTagByPostTagId($this->getPDO(), $postTag->getPostTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$this->assertEuals($pdoPostTag->getPostTagPostId(), $this->postTagPost->getPostTagPostId());
		$this->assertEquals($pdoPostTag->getPostTagTagId(), $this->VALID_POSTTAGPOASTID);
	}
	/**
	 * test updating a PostTat that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidPostTag() {
		// create a PostTag, try to update it without actually updating it and watch it fail
		$postTag = new PostTag( $this->postTag->getPostTagTagId(), $this->postTag->getPostTagPostId());
		$postTag->update($this->getPDO());
	}
	/**
	 * test creating a PostTag and then deleting it
	 **/
	public function testDeleteValidPostTag() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("postTag");

		// create a new PostTag and insert to into mySQL
		$postTag = new PostTag( $this->postTag->getPostTagTagId(), $this->postTag->getPostTagPostId());
		$postTag->insert($this->getPDO());

		// delete the PostTag from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postTag"));
		$postTag->delete($this->getPDO());

		// grab the data from mySQL and enforce the PostTag does not exist
		$pdoPostTag = PostTag::getPostTagByPostTagId($this->getPDO(), $postTag->getPostTagId());
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
		$postTag = new PostTag(null, $this->postTagPost->getPostTagPostId(), $this->VALID_POSTTAGCONTENT);
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
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("ostTag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Bsteider\\Gighub\\PostTag", $results);

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
		$postTag = PostTag::getPostTagByPostTagTagId($this->getPDO(), "you will find nothing");
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
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Bsteider\\Gighub\\PostTag", $results);

		// grab the result from the array and validate it
		$pdoPostTag = $results[0];
		$this->assertEquals($pdoPostTag->getPostTagPostId(), $this->postTagPostId->getPostTagPostId());
		$this->assertEquals($pdoPostTag->getPostTagTag(), $this->VALID_POSTTAGTAGID);

	}

	}

	/********************************************************
	 * HELLO HI
	 **
	 ***
	 ****
	 *****
	 ******
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