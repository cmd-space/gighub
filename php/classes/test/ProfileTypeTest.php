<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\GigHub\{Profile, ProfileType };

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
	public final function setup() {
		// run the default setup() method first
		parent::setup();

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
		$pdoProfileType = profileType::getProfileTypebyProfileTypeId($this->getPDO(), $profileType->getProfileTypeId());
		$this->assertionEquals($numRows + 1, $this->getConnection()->getRowCount("profileType"));
		$this->assertionEquals($pdoProfileType->getProfileId(), $this->profile->getProfileId());

	}
}