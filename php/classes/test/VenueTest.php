<?php
namespace Edu\Cnm\Dconley6\GigHub\Test;

use Edu\Cnm\Dconley6\GigHub\{
	Profile
};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "../classes/autoload.php");

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
	 * create dependent objects before running each test
	 **/

	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test Venue
		$this->profile = new Profile(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Venue and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVenue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->profile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALIDVENUECITY, $this->VALIDVENUESTATE, $this->VALIDVENUEZIP);
		$venue->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->profile->getVenueProfileId());
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
		$venue = new Venue(DataDesignTest::INVALID_KEY, $this->profile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
		$venue->insert($this->getPDO());
	}

	/**
	 * test inserting a Venue, editing it, and then updating it
	 **/
	public function testUpdateValidVenue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("venue");

		// create a new Venue and insert to into mySQL
		$venue = new Venue(null, $this->profile->getVenueProfileId(), $this->VALID_VENUENAME, $this->VALID_VENUESTREET1, $this->VALID_VENUESTREET2, $this->VALID_VENUECITY, $this->VALID_VENUESTATE, $this->VALID_VENUEZIP);
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
		$this->assertEquals($pdoVenue->getVenueProfileId(), $this->profile->getVenueProfileId());
		$this->assertEquals($pdoVenue->getVenueName(), $this->VALID_VENUENAME);
		$this->assertEquals($pdoVenue->getVenueStreet1(), $this->VALID_VENUESTREET1);
		$this->assertEquals($pdoVenue->getVenueStreet2(), $this->VALID_VENUESTREET2);
		$this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_VENUECITY);
		$this->assertEquals($pdoVenue->getVenueState(), $this->VALID_VENUESTATE);
		$this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_VENUEZIP);
	}


