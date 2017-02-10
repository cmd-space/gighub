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
	protected $VALID_SOUNDCLOUDUSER = "PHPUnit passing. Many Songs. Wow.";
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
	 * declare oAuthId
	 */
	protected $oAuthId = null;
	/**
	 * declare profileTypeId
	 */
	protected $profileTypeId = null;
	/**
	 * declare oAuth
	 */
	protected $oAuth = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert an OAuth to own the test Profile
		$this->oAuth = new OAuth(null, "Facebook");
		$this->oAuth->insert($this->getPDO());
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
		$this->assertEquals($pdoProfile->getProfileOAuthId(), $this->profile->getProfileOAuthId());
		$this->assertEquals($pdoProfile->getProfileTypeId(), $this->profile->getProfileTypeId());
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILEBIO);
		$this->assertEquals($pdoProfile->getProfileImageCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileOAuthToken(), $this->VALID_OAUTHTOKEN);
		$this->assertEquals($pdoProfile->getProfileSoundCloudUser(), $this->VALID_SOUNDCLOUDUSER);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	}

}