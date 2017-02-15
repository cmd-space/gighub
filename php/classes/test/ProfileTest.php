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
		$profile = new Profile(-1, $this->oAuth->getOAuthId(), -1, $this->VALID_PROFILEBIO, $this->VALID_CLOUDINARYID, $this->VALID_PROFILELOCATION, $this->VALID_OAUTHTOKEN, $this->VALID_SOUNDCLOUDUSER, $this->VALID_USERNAME);
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