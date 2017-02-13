<?php
namespace Edu\Cnm\GigHub\Profile\Test;

use Edu\Cnm\GigHub\{
	OAuth, Profile, ProfileType
};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the VenueTest class
 *
 * This is a complete PHPUnit test of the VenueTest class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see VenueTest
 * @author Dante Conley <dconley6@cnm.edu>
 **/
class VenueTest extends GigHubTest {
	/**
	 * content of the Venue
	 * @var int $VALID_VENUEPROFILEID
	 **/
	protected $VALID_VENUEPROFILEID = null;
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUENAME
	 **/
	protected $VALID_VENUENAME = "NewVenue, Who dis?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUESTREET1
	 **/
	protected $VALID_VENUESTREET1 = "Where they at, yo?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUESTREET2
	 **/
	protected $VALID_VENUESTREET2 = "Where the at? More specifically, yo";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUECITY
	 **/
	protected $VALID_VENUECITY = "Where ya from?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUESTATE
	 **/
	protected $VALID_VENUESTATE = "New Mexiwhere?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUEZIP
	 **/
	protected $VALID_VENUEZIP = "Its a zip code. Nothing witty to see here.";
	/**
	 * profile created to use with unit test.
	 * @var string $testProfile
	 **/
	protected $testProfile;
	/**
	 * OAuth created for unit test
	 * @var string $testOAuth
	 **/
	protected $testOAuth;
	/**
	 * Profile Type created for unit test
	 * @var string $testOAuth
	 **/
	protected $testProfileType;




	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// add missing oAuth variables
		$this->testOAuth = new OAuth(null, "testOAunthServiceName");
		$this->testOAuth->insert($this->getPDO());

		// add missing profileType variables
		$this->testProfileType = new ProfileType(null, "testProfileTypeName");
		$this->testProfileType->insert($this->getPDO());

		// add missing profile variables
		$this->testProfile = new Profile(null, $this->testOAuth->getOAuthId(), 1234, "testProfileBio", "testProfileImageCloudinaryId", "testProfileLocation", "testProfileOAuthToken", "testProfileSoundCloudUser", "testProfileUserName");
		$this->testProfile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Venue and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVenue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}

	/**
	 * test inserting a Venue that already exists
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidVenue() {
		// create a Venue with a non null Venue id and watch it fail
		$venue = new Venue(DataDesignTest::INVALID_KEY, $this->testProfile->getProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());
	}

	/**
	 * test inserting a Venue, editing it, and then updating it
	 **/
	public function testUpdateValidVenue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// edit the Venue and update it in mySQL
		$venue->setVenueName($this->VALID_VENUENAME);
		$venue->setVenueStreet1($this->VALID_VENUESTREET1);
		$venue->setVenueStreet2($this->VALID_VENUESTREET2);
		$venue->setVenueCity($this->VALID_VENUECITY);
		$venue->setVenueName($this->VALID_VENUESTATE);
		$venue->setVenueName($this->VALID_VENUEZIP);
		$venue->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}

	/**
	 * test updating a Venue that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidVenue() {
		// create a Venue, try to update it without actually updating it and watch it fail
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->update($this->getPDO());
	}

	/**
	 * test creating a Venue and then deleting it
	 **/

	public function testDeleteValidVenue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// delete the Venue from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$venue->delete($this->getPDO());

		// grab the data from mySQL and enforce the Venue does not exist
		$pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
		$this->assertNull($pdoVenue);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("venue"));
	}

	/**
	 * test deleting a Venue that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidVenue() {
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->delete($this->getPDO());
	}

	/**
	 * test grabbing a Venue by Venue Name
	 **/
	public function testGetValidVenueByVenueName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Venue::getVenueByVenueName($this->getPDO(), $venue->getVenueName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\GigHub\\Venue", $results);

		// grab the result from the array and validate it
		$pdoVenue = $results[0];
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}

	/**
	 * test grabbing a Venue by Name that does not exist
	 **/
	public function testGetInvalidVenueByVenueName() {
		// grab a venue by searching for name that does not exist
		$venue = Venue::getVenueByVenueName($this->getPDO(), "imaginary venue name, dummy");
		$this->assertCount(0, $venue);
	}

	/**
	 * test grabbing a Venue by Venue Street 1
	 **/
	public function testGetValidVenueByVenueStreet1() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Venue::getVenueByVenueStreet1($this->getPDO(), $venue->getVenueStreet1());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\GigHub\\Venue", $results);

		// grab the result from the array and validate it
		$pdoVenue = $results[0];
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}

	/**
	 * test grabbing a Venue by Venue Street that does not exist
	 **/
	public function testGetInvalidVenueByVenueStreet1() {
		// grab avenue by searching for content that does not exist
		$venue = Venue::getVenueByVenueStreet1($this->getPDO(), "imaginary venue street, dummy");
		$this->assertCount(0, $venue);
	}

	/**
	 * test grabbing a Venue by venue city
	 **/
	public function testGetValidVenueByVenueCity() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Venue::getVenueByVenueCity($this->getPDO(), $venue->getVenueCity());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\GigHub\\Venue", $results);

		// grab the result from the array and validate it
		$pdoVenue = $results[0];
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}

	/**
	 * test grabbing a Venue by city that does not exist
	 **/
	public function testGetInvalidVenueByVenueCity() {
		// grab a venur by searching for a city that does not exist
		$venue = Venue::getVenueByVenueCity($this->getPDO(), "imaginary venue city, dummy");
		$this->assertCount(0, $venue);
	}

	/**
	 * test grabbing a Venue by Venue Zip
	 **/
	public function testGetValidVenueByVenueZip() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Venue::getVenueByVenueZip($this->getPDO(), $venue->getVenueZip());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\GigHub\\Venue", $results);

		// grab the result from the array and validate it
		$pdoVenue = $results[0];
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}

	/**
	 * test grabbing a Venue by Zip that does not exist
	 **/
	public function testGetInvalidVenueByVenueZip() {
		// grab a venue by searching for zip that does not exist
		$venue = Venue::getVenueByVenueZip($this->getPDO(), "imaginary venue zip, dummy");
		$this->assertCount(0, $venue);
	}

	/**
	 * test grabbing all Venues
	 **/
	public function testGetAllValidVenues() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->testProfile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Venue::getAllVenues($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Dconley6\\GigHub\\Venue", $results);

		// grab the result from the array and validate it
		$pdoVenue = $results[0];
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->testProfile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}
}