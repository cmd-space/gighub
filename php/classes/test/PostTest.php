<?php
namespace Edu\Cnm\Jramirez98\GigHub\Test;

use Edu\Cnm\jramirez98\GigHub\{Profile, Post };

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Post class
 *
 * This is a complete PHPUnit test of the Post class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Post
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 **/
class PostTest extends GigHubTest {
	/**
	 *id for the venue that created the post,
	 * @var int $VALID_POSTVENUEID
	 **/
	protected $VALID_POSTVENUEID = null;
	/**
	 * content of the PostContent
	 * @var string $VALID_POSTCONTENT
	 **/
	protected $VALID_POSTCONTENT = "PHPUnit test is positive... for success";
	/**
	 * content of the updated postContent
	 * @var string $VALID_POSTCONTENT2
	 **/
	protected $VALID_POSTCONTENT2 = "BELIEVE IT OR NOT... it passed the second gate of Hell ";
	/**
	 * timestamp of the Tweet; this starts as null and is assigned later
	 * @var DateTime $VALID_POSTCREATEDDATE
	 **/
	protected $VALID_POSTCREATEDDATE = null;
	/**
	 * timestamp of the Tweet; this starts as null and is assigned later
	 * @var DateTime $VALID_POSTEVENTDATE
	 **/
	protected $VALID_POSTEVENTDATE = null;
	/**
	 *id of the imagecloudinary the user owns
	 * @var int $VALID _POSTIMAGECLOUDINARY
	 **/
	protected $VALID_POSTIMAGECLOUDINARYID = null;
	/**
	 *the title of the post created
	 **/
	protected $VALID_POSTTITLE = null;
	/**
	 * profile that created the Post; this is for foreign key relations
	 * @var Post profile id
	 */
	protected $profile;

// TODO: create set up method that creates a profile
	/**
	 * create dependent objects before running each test
	 **/
	public final function setup() {
		//run the default before setup() method first
		parent::setup();

		// create and insert a Profile to own the test Post
		$this->profile = new Profile(null, "@phpunit", "test@phpunit.de", "HAHAHAHAHAHAHAHAHA!");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_POSTCREATEDDATE = new \DateTime();
		$this->VALID_POSTEVENTDATE = new \DateTime();
	}
	/**
	 *test inserting a post, editing it, and then updating it
	 */
	public function testUpdateValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->retRowCount("post");

		// create a new Post and insert to into mySQL
		$post = new Post(null, $this->profile->getpPostProfileId(), $this->VALID_POSTVENUEID, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTCONTENT, $this->POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		//edit the Post and update it in mySQL
		$post->setPostContent($this->profile->VALID_POSTCONTENT2);
		$post->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostby($this->getPDO(), $post->get());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getPostProfileId());
		$this->assertEquals($pdoPost->getPostVenueId(), $this->VALID_POSTVENUEID);
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		$this->assertEquals($pdoPost->getPostCreatedDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostEventDate(), $this->VALID_POSTEVENTDATE);
		$this->assertEquals($pdoPost->getPostImageCloudinaryId(), $this->VALID_POSTIMAGECLOUDINARYID);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_POSTTITLE);
	}

	/**
	 * test updating a post that does not exist
	 *
	 * @exceptedException PDoException
	 */
	public function testUpdateInvalidPost() {
		// create a post, try to update it without actually updating it and watch it fail
		$post = new Post(null, $this->profile->getpPostProfileId(), $this->VALID_POSTVENUEID, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTCONTENT, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->update($this->getPDO());
	}

	/**
	 * test creating a post and then deleting it
	 */
	public function testDeleteValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new post and insert into mySQL
		$post = new Post(null, $this->profile->getProfileId, $this->getConnection()->getRowCount("post"));
		$post->insert($this->getPDO());

		// delete the Post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());

		// grab the data from mySQL and enforce the Post does not exist
		$pdoPost = Post::getPostProfilebyPostProfileId($this->getPDO(), $post->getPostProfileId());
		$this->assertNUll($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}

	/**
	 *test deleting a post that does not exist
	 */
	public function testDeleteInvalidPost() {
		// create a post and try to delete it without actually inserting it
		$post = new Post(null, $this->getPostProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE);
		$post->delete($this->getPDO());
	}

	/**
	 *test grabbing a post by post content
	 */
	public function testGetValidPostByPostContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new post and insert to into mySQL
		$post = new Post(null, $this->profile->getpPostProfileId(), $this->VALID_POSTVENUEID, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTCONTENT, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostbyPostContent($this->getPDO(), $this->getPDO(), $post->getPostContent());
		$this->assertEquals($numRows + 1, $this->getPDO(), $post->getPostContent());
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jramirez98\\GigHub\\Post", $results);

		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getPostProfileId());
		$this->assertEquals($pdoPost->getPostVenueId(), $this->VALID_POSTVENUEID);
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		$this->assertEquals($pdoPost->getPostCreatedDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostEventDate(), $this->VALID_POSTEVENTDATE);
		$this->assertEquals($pdoPost->getPostImageCloudinaryId(), $this->VALID_POSTIMAGECLOUDINARYID);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_POSTTITLE);
	}

	/**
	 *test grabbing a Post by content that does not exist
	 */
	public function testGetInvalidPostByPostContent() {
		// grab a post by searching for content that does not exist
		$post = Post::getPostByPostContent($this->getPDO(), "Stop chasing Bigfoot!");
		$this->assertCount(0, $post);
	}

	/**
	 * test grabbing all posts
	 */
	public function testGetAllValidPosts() {
		// grab a post by searching for content that does not exist
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new post and insert to into mySQl
		$post = new Post(null, $this->profile->getProfile(), $this->VALID_POSTVENUEID, $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectaions
		$results = Post::getAllPosts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstencesOf("Edu\\Cnm\\Jramirez98\\GigHub\\Post", $results);

		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getProfileId(), $this->profile->getProfile());
		$this->assertEquals($pdoPost->getPostVenueId(), $this->VALID_POSTVENUEID);
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		$this->assertEquals($pdoPost->getPostCreatedDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostEventDate(), $this->VALID_POSTEVENTDATE);
		$this->assertEquals($pdoPost->getPostImageCloudinaryId(), $this->VALID_POSTIMAGECLOUDINARYID);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_POSTTITLE);
	}

}