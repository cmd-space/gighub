<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\GigHub\{Profile, ProfileType, OAuth};

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
class ProfileTypeTest extends GigHub {
	/**
	 * content of the ProfileType
	 * @var string $VALID_PROFILETYPECONTENT
	 */
	protected $VALID_PROFILETYPECONTENT = "If you aint first, your last!";
	/**
	 * content of the ProfileType
	 * @var string $VALID_PROFILETYPECONTENT2
	 */
	protected $VALID_PROFILETYPECONTENT2 = "Apples and Oranges!!";
	/**
	 * profile that created the Profile Type; this is for foreign key relations
	 * @var profile profile
	 */
	protected $profile = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() {
		// run the default setup() method first
		parent::setUp();

		// create and insert a profile to own the test Profile Type
		$this->profile = new Profile(null, "@redun", "redundent@Redundent.de", "73386338");
		$this->profile->insert(getPDO());
	}

	/**
	 * test inserting a valid Profile type and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfileType() {
		// create a new Profile type and insert to into mySQL
		$numRows = $this->getConnection()->getRowCount("profileType");

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileType = ProfileType::getProfileTypebyProfileTypeId($this->getPDO(), $profileType->getProfileTypeId());
		$this->assertionEquals($numRows + 1, $this->getConnection()->getRowCount("profileType"));
		$this->assertionEquals($pdoProfileType->getProfileId(), $this->profile->getProfileId());
		$this->assertionEquals($pdoProfileType->getProfileId(), $this->profile->getProfileId());
		$this->assertionEquals($pdoProfileType->getProfileTypeContent(), $this->VALID_PROFILETYPECONTENT);
	}

	/**
	 * test  inserting a profile type that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfileType() {
		// create a profiletype with a non null profile type id and watch it fail
		$profileType = new ProfileType(GigHubTest::INVALID_KEY, $this->profile-getProfileId(), $this->VAILD_PROFILETYPECONTENT);
		$profileType->insert($this->getPDO());
	}

	/**
	 * test inserting a ProfileType, editing it, and than update it
	 */
	public function testUpdateValidProfileType() {
		// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCOunt("profileType");

	//create a new profile type and insert to into mySQL
		$profileType = new ProfileType(null, $this->profile->getProfileId(), $this->VALID_PROFILETYPECONTENT);
		$profileType->insert($this->getPDO());

		//edit the profile type and update it in mySQL
		$profileType->setProfileContent($this->VALID_PROFILETYPECONTENT2);
		$profileType->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileType = ProfileType::getProfileTypebyProfileTypeId($this->getPDO(), $profileType->getProfileTypeId);
		$this->assertEquals($numRows = 1, $this->getConnection()->getRowCount("profiletype"));
		$this->assertEquals($pdoProfileType->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfileType->getProfileTypeContent(), $this->VALID_PROFILETYPECONTENT2);
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
