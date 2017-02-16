<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\GigHub\{ProfileType};

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
	 * test inserting a valid Profile type and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfileType() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profileType");

		// create a new profile type and insert into mySQL
		$profileType = new ProfileType(null, $this->VALID_PROFILETYPENAME);

// TODO: add the insert method

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileType = ProfileType::getProfileTypeByProfileTypeId($this->getPDO(), $profileType-getProfileTypeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getProfileTypeId());
		$this->assertEquals($pdoProfileType->getProfileTypeName(), $this->VALID_PROFILETYPENAME);
	}

	/**
	 * test  inserting a profile type that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfileType() {
		// create a profile type with a non null profile type id and watch it fail
		$profileType = new ProfileType(GigHubTest::INVALID_KEY, $this->VALID_PROFILETYPENAME);
		$profileType->insert($this->getPDO());
	}

	/**
	 * test inserting a ProfileType, editing it, and than update it
	 */
	public function testUpdateValidProfileType() {
		// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("profileType");

	//create a new profile type and insert to into mySQL
		$profileType = new ProfileType(null, $this->VALID_PROFILETYPENAME);
		$profileType->insert($this->getPDO());

		//edit the profile type and update it in mySQL
		$profileType->setProfileTypeName($this->VALID_PROFILETYPENAME2);
		$profileType->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfileType = ProfileType::getProfileTypebyProfileTypeId($this->getPDO(), $profileType->getProfileTypeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profileType"));
		$this->assertEquals($pdoProfileType->getProfileTypeId(), $this->profileType->getProfileTypeId());
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
//TODO: finish test delete invalid, test all fooByBars, then you're gucci c: