<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\GigHub\{Profile, oAuth, ProfileType};

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile test class
 *
 * This is a complete PHPUnit test of the profile type class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile Type
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 **/
class ProfileTypeTest extends GigHubTest {
	/**
	 * content of the ProfileType
	 * @var string $VALID_PROFILETYPENAME
	 */
	protected $VALID_PROFILETYPENAME = "Deftones";
	/**
	 * content of the ProfileType
	 * @var string $VALID_PROFILETYPENAME2
	 */
	protected $VALID_PROFILETYPENAME2 = "The Smiths";
	/**
	 * profile that created the Profile Type; this is for foreign key relations
	 * @var profile profile
	 */
	protected $profile = null;
	/**
	 * declare profile type
	 */
	protected $profileType = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setup() method first
		parent::setUp();

		// create and insert an OAuth to own the test profile
		$this->profileType = new ProfileType(null, "Deftones");
		$this->profileType->insert($this->getPDO());

		// create and insert a profile to own the test Profile Type
		$this->profile = new Profile(null, $this->oAuth->getAOuthId(), $this->profileTypeId->getProfileTypeId(),"profile bio", "585773948", "Albuquerque", "04hou94n494", "Deftones", "Deftones", "theSmiths");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Profile type and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfileType() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileType");

		// create a new profile type and insert into mySQL
		$profileType = new ProfileType(null, $this->profile->getProfileId(), $this->profileType->getProfileTypeId(), $this->VALID_PROFILETYPENAME, $this->VALID_PROFILETYPENAME2);

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileType = ProfileType::getProfileTypeByProfileTypeId($this->getPDO(), $profileType-getProfileTypeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getProfileTypeId());
		$this->assertEquals($pdoProfileType->getProfileTypeId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfileType->getProfileTypeName(), $this->VALID_PROFILETYPENAME);
	}

	/**
	 * test  inserting a profile type that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfileType() {
		// create a profile type with a non null profile type id and watch it fail
		$profileType = new ProfileType(GigHubTest::INVALID_KEY, $this->profile-getProfileId(), $this->VAILD_PROFILETYPENAME);
		$profileType->insert($this->getPDO());
	}

	/**
	 * test inserting a ProfileType, editing it, and than update it
	 */
	public function testUpdateValidProfileType() {
		// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCOunt("profileType");

	//create a new profile type and insert to into mySQL
		$profileType = new ProfileType(null, $this->profile->getProfileId(), $this->VALID_PROFILETYPENAME);
		$profileType->insert($this->getPDO());

		//edit the profile type and update it in mySQL
		$profileType->setProfileName($this->VALID_PROFILETYPENAME2);
		$profileType->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileType = ProfileType::getProfileTypebyProfileTypeId($this->getPDO(), $profileType->getProfileTypeId);
		$this->assertEquals($numRows = 1, $this->getConnection()->getRowCount("profiletype"));
		$this->assertEquals($pdoProfileType->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfileType->getProfileTypeName(), $this->VALID_PROFILETYPENAME2);
	}

	/** test updating a profile type that does not exist
	 *
	 *@expectedException PDOException
	 **/
	public function testDeleteValidProfileType() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profileType");

		// create a new Profile Type and insert to into mySQL

		}
}
