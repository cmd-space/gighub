<?php
namespace Edu\Cnm\GigHub\Post\Test;

//use Edu\Cnm\GigHub\OAuth;
//use Edu\Cnm\GigHub\Profile\Test\ProfileTest;

use Edu\Cnm\GigHub\{OAuth, ProfileType, Profile, Venue, Post};
use Edu\Cnm\Gighub\Test\GigHubTest;

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
	 * content of the PostContent
	 * @var string $VALID_POSTCONTENT
	 **/
	protected $VALID_POSTCONTENT = "PHPUnit test is positive... for success";
	/**
	 * content of the updated postContent
	 * @var string $VALID_POSTCONTENT2
	 **/
	protected $VALID_POSTCONTENT2 = "BELIEVE IT OR NOT... it passed the second gate of Hell";
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
	 * @var string $VALID _POSTIMAGECLOUDINARY
	 **/
	protected $VALID_POSTIMAGECLOUDINARYID = "Image successful";
	/**
	 *the title of the post created
	 **/
	protected $VALID_POSTTITLE = "let's Jam";
	/**
	 * profile that created the Post; this is for foreign key relations
	 * @var Post profile id
	 */
	protected $profile = null;
	/**
	 *declare oAuth
	 */
	protected $oAuth = null;
	/**
	 * declare profileType
	 */
	protected $profileType = null;
	/**
	 * declare venue
	 * */
	protected $venue = null;



// TODO: create set up method that creates a profile
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();


		// create and insert an OAuth to own the test profile
		$this->oAuth = new OAuth(null, "Facebook");
		$this->oAuth->insert($this->getPDO());


		// create and insert a ProfileType to own the test Profile
		$this->profileType = new ProfileType(null, "Musician");
		$this->profileType->insert($this->getPDO());


		// create and insert a Profile to own the test Post
		$this->profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), "Super Bad", "valid cloud ID", "valid location", "valid O'Auth token", "valid soundcloud", "valid Username");
		$this->profile->insert($this->getPDO());


		// create and insert a venue profile  to own the test Post
		$this->venue = new Venue(null, $this->profile->getProfileId(), "Albuquerque", "Error 418", "nm","1343 Rock", "3453 Rock", "87105");
		$this->venue->insert($this->getPDO());


		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_POSTCREATEDDATE = new \DateTime();
		$this->VALID_POSTEVENTDATE = new \DateTime();
	}

	/**
	 *test inserting a valid post and verify the actual mySQL data matches
	 */
	public function testInsertValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new Post and insert it into mySQL
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostbyPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $post->getPostProfileId());
		$this->assertEquals($pdoPost->getPostVenueId(), $post->getPostVenueId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		$this->assertEquals($pdoPost->getPostCreatedDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostEventDate(), $this->VALID_POSTEVENTDATE);
		$this->assertEquals($pdoPost->getPostImageCloudinaryId(), $this->VALID_POSTIMAGECLOUDINARYID);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_POSTTITLE);
	}
	/**
	 *test inserting a post, editing it, and then updating it
	 */
	public function testUpdateValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new Post and insert to into mySQL
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());


		//edit the Post and update it in mySQL
		$post->setPostContent($this->VALID_POSTCONTENT2);
		$post->update($this->getPDO());


		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $post->getPostProfileId());
		$this->assertEquals($pdoPost->getPostVenueId(), $post->getPostVenueId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		$this->assertEquals($pdoPost->getPostCreatedDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostEventDate(), $this->VALID_POSTEVENTDATE);
		$this->assertEquals($pdoPost->getPostImageCloudinaryId(), $this->VALID_POSTIMAGECLOUDINARYID);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_POSTTITLE);
	}

	/**
	 * test updating a post that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidPost() {
		// create a post, try to update it without actually updating it and watch it fail
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->update($this->getPDO());
	}

	/**
	 * test creating a post and then deleting it
	 */
	public function testDeleteValidPost() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new post and insert into mySQL
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		// delete the Post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());

		// grab the data from mySQL and enforce the Post does not exist
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}

	/**
	 *test deleting a post that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidPost() {
		// create a post and try to delete it without actually inserting it
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->delete($this->getPDO());
	}

	/**
	 *test grabbing a post by post content
	 */
	public function testGetValidPostByPostContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		// create a new post and insert to into mySQL
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostContent($this->getPDO(), $post->getPostContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\GigHub\\Post", $results);

		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $post->getPostProfileId());
		$this->assertEquals($pdoPost->getPostVenueId(), $post->getPostVenueId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
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
		$post = new Post(null, $this->profile->getProfileId(), $this->venue->getVenueId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE, $this->VALID_POSTIMAGECLOUDINARYID, $this->VALID_POSTTITLE);
		$post->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectaions
		$results = Post::getAllPosts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\GigHub\\Post", $results);

		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $post->getPostProfileId());
		$this->assertEquals($pdoPost->getPostVenueId(), $post->getPostVenueId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		$this->assertEquals($pdoPost->getPostCreatedDate(), $this->VALID_POSTCREATEDDATE);
		$this->assertEquals($pdoPost->getPostEventDate(), $this->VALID_POSTEVENTDATE);
		$this->assertEquals($pdoPost->getPostImageCloudinaryId(), $this->VALID_POSTIMAGECLOUDINARYID);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_POSTTITLE);
	}

}