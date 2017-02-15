<?php
namespace Edu\Cnm\GigHub\Profile\Test;

use Edu\Cnm\GigHub\{OAuth, Profile, ProfileType};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because ALL mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Mason Crane <cmd-space.com>
 */
class ProfileTest extends GigHubTest {
	/**
	 * content of the Profile bio
	 * @var string $VALID_PROFILEBIO
	 */
	protected $VALID_PROFILEBIO = "PHPUnit test passing. This is my bio. Dab.";
	/**
	 * content of the updated Profile bio
	 * @var string $VALID_PROFILEBIO2
	 */
	protected $VALID_PROFILEBIO2 = "PHPUnit test still passing. More bio.";
	/**
	 * Profile image Cloudinary id string
	 * @var string $VALID_CLOUDINARYID
	 */
	protected $VALID_CLOUDINARYID = "PHPUnit cloudinary passing";
	/**
	 * Profile location string
	 * @var string $VALID_PROFILELOCATION
	 */
	protected $VALID_PROFILELOCATION = "PHPUnit passing Albuquerque";
	/**
	 * Profile OAuth Token string
	 * @var string $VALID_OAUTHTOKEN
	 */
	protected $VALID_OAUTHTOKEN = "PHPUnit passing, so token. Wow.";
	/**
	 * Profile SoundCloud User string
	 * @var string $VALID_SOUNDCLOUDUSER
	 */
	protected $VALID_SOUNDCLOUDUSER = "PHPUnit passing. Many Songs";
	/**
	 * Profile User Name string
	 * @var string $VALID_USERNAME
	 */
	protected $VALID_USERNAME = "PHPUnit passing. User name. Yay.";
	/**
	 * declare profile
	 */
	protected $profile = null;
	/**
	 * declare oAuth
	 */
	protected $oAuth = null;
	/**
	 * declare profileType
	 */
	protected $profileType = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert an OAuth to own the test Profile
		$this->oAuth = new OAuth(null, "Facebook");
		$this->oAuth->insert($this->getPDO());

		// create and insert a ProfileType to own the test Profile
		$this->profileType = new ProfileType(null, "Musician");
		$this->profileType->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profileType->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfile() {
		// create a Profile with a non null profile id and watch it fail /cry
		$profile = new Profile(GigHubTest::INVALID_KEY, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// edit the Profile and update it in mySQL
		$profile->setProfileBio($this->VALID_PROFILEBIO2);
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profileType->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO2);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

	/**
	 * test updating a Profile that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProfile() {
		// create a Profile, try to update it without actually updating it and watch it fail. Bad backend dev trying to update without parameters
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->update($this->getPDO());
	}

	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a Profile that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProfile() {
		// create a Profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->delete($this->getPDO());
	}

	/**
	 * test inserting a profile with a negative primary key
	 *
	 * @expectedException RangeException
	 */
	public function testInsertInvalidProfileId() {
		// create a Profile with a negative primary key and insert that ish
		$profile = new Profile(-1, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting invalid OAuthId
	 *
	 * @expectedException RangeException
	 */
	public function testInsertInvalidProfileOAuthId() {
		$profile = new Profile(null, -1, $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting invalid profile type id
	 *
	 * @expectedException RangeException
	 */
	public function testInsertInvalidProfileTypeId() {
		$profile = new Profile(null, $this->oAuth->getOAuthId(), -1, $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting invalid/empty profile bio
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testInsertEmptyProfileBio() {
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), "", $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting super duper long profile bio
	 *
	 * @expectedException RangeException
	 */
	public function testInsertLongProfileBio() {
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), "Spicy jalapeno bacon ipsum dolor amet shankle ham turducken drumstick, spare ribs bresaola sirloin shoulder ribeye shank rump meatloaf meatball. Chuck venison biltong andouille porchetta. Ground round pork loin strip steak tail jerky bresaola pork brisket landjaeger prosciutto shoulder filet mignon leberkas fatback. Frankfurter brisket meatball picanha short loin ham pork chop. Chicken pork belly capicola short ribs kielbasa porchetta.
Flank short ribs bresaola biltong short loin cow ribeye t-bone capicola pastrami corned beef pork belly strip steak chicken turducken. Kevin swine meatball leberkas, bacon pork loin tongue landjaeger strip steak corned beef tail prosciutto turducken biltong shankle. Kevin jerky bresaola, jowl prosciutto boudin frankfurter landjaeger. Frankfurter fatback turducken short loin. Turducken drumstick shank, rump prosciutto bresaola venison. Shankle swine t-bone meatball tri-tip short loin shoulder meatloaf pork chop kevin beef ribs sirloin tongue. Shank ham hock jowl corned beef pork loin meatloaf.
Pork belly chuck pork beef shoulder filet mignon tenderloin doner spare ribs beef ribs hamburger ball tip porchetta tongue. Pig hamburger sirloin, doner salami flank t-bone tongue shank drumstick kielbasa venison. Sirloin bresaola tenderloin fatback. Jerky porchetta corned beef burgdoggen pig, filet mignon pastrami prosciutto pancetta.
Burgdoggen drumstick brisket, porchetta kielbasa leberkas swine pig. Ball tip pig ribeye t-bone pancetta fatback, porchetta capicola. Ham picanha doner pastrami. Shoulder alcatra strip steak brisket ham short loin filet mignon ground round. Short ribs hamburger meatball venison, corned beef porchetta biltong sausage turkey fatback picanha pork chop tail.", $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test grabbing a Profile by profile user name
	 **/
	public function testGetValidProfileByProfileUserName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileUserName($this->getPDO(), $profile->getProfileUserName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\GigHub\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profileType->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

	/**
	 * test grabbing a Profile by a user name that does not exist
	 **/
	public function testGetInvalidProfileByProfileUserName() {
		// grab a Profile by searching for a user name that does not exist
		$profile = Profile::getProfileByProfileUserName($this->getPDO(), "These aren't the droids you're looking for");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile(s) by Location Content
	 */
	public function testGetValidProfileByLocationContent() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount('profile');

		// create a new Profile and insert it into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

//		var_dump($profile->getProfileLocation());
		// grab the data from mySQL and enforce that fields match expectations
		$results = Profile::getProfileByLocationContent($this->getPDO(), $profile->getProfileLocation());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\GigHub\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profileType->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

	/**
	 * test grabbing a Profile by Location Content that does not exist
	 */
	public function testGetInvalidProfileByLocationContent() {
		// grab a profile by searching for location content that does not exist
		$profile = Profile::getProfileByLocationContent($this->getPDO(), "Elbonia");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile by SoundCloud user
	 */
	public function testGetValidProfileBySoundCloudUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce that fields match expectations
		$results = Profile::getProfileBySoundCloudUser($this->getPDO(), $profile->getProfileSoundCloudUser());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\GigHub\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
//		$pdoProfile = Profile::getProfileBySoundCloudUser($this->getPDO(), $profile->getProfileSoundCloudUser());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profileType->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

	/**
	 * test grabbing a Profile by SoundCloud user that does not exist
	 */
	public function testGetInvalidProfileBySoundCloudUser() {
		// grab a profile by searching for SoundCloud user that does not exist
		$profile = Profile::getProfileBySoundCloudUser($this->getPDO(), "Engelbert Humperdink");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile by profile type id
	 */
	public function testGetValidProfileByProfileTypeId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount('profile');

		// create a new Profile and insert it into mySQL
		$profile = new Profile(null, $this->oAuth->getOAuthId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce that fields match expectations
		$results = Profile::getProfileByProfileTypeId($this->getPDO(), $profile->getProfileTypeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\GigHub\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->oAuth->getOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profileType->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

	/**
	 * test grabbing a Profile by profile type id that does not exist
	 */
	public function testGetInvalidProfileByProfileTypeId() {
		// grab a profile by searching for SoundCloud user that does not exist
		$profile = Profile::getProfileByProfileTypeId($this->getPDO(), 60000000);
		$this->assertCount(0, $profile);
	}
}