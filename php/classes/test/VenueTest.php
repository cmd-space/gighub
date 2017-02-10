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
	 * @var string $VALID_VENUENAME
	 **/
	protected $VALID_VENUESTREET1 = "Where they at, yo?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUENAME
	 **/
	protected $VALID_VENUESTREET2 = "Where the at? More specifically, yo";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUENAME
	 **/
	protected $VALID_VENUECITY = "Where ya from?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUENAME
	 **/
	protected $VALID_VENUESTATE = "New Mexiwhere?";
	/**
	 * content of the updated Venue
	 * @var string $VALID_VENUENAME
	 **/
	protected $VALID_VENUEZIP = "Its a zip code. Nothing witty to see here.";
}

