<?php
namespace Edu\Cnm\Dconley6\Venue;

require_once("autoload.php");

/**
 * Information of the venue (name & physical location)
 *
 * An example of how the data on the venues is stored in the database
 *
 * @author Dante Conley <danteconley@icloud.com>
 * @version 1.0
 **/

class Venue implements \JsonSerializable {
	/**
	 * id for this Venue; this is the primary key
	 * @var int $venueId
	 **/
	private $venueId;
	/**
	 * the username which the venue is attached to; this is a foreign key
	 * @var int $venueProfileId
	 **/
	private $venueProfileId;
	/**
	 * the name of the venue
	 * @var string $venueName
	 **/
	private $venueName;
	/**
	 * the first street address of the venue
	 * @var string $venueStreet1
	 **/
	private $venueStreet1;
	/**
	 * the second street address of the venue (if any)
	 * @var string $venueStreet2
	 **/
	private $venueStreet2;
	/**
	 * the city in which the venue is located
	 * @var string $venueCity
	 **/
	private $venueCity;
	/**
	 * state in which the venue is located
	 * @var string $venueState
	 **/
	private $venueState;
	/**
	 * zip code in which venue is located
	 * @var string $venueZip
	 **/
	private $venueZip;

	/**
	 * constructor for this Venue
	 *
	 * @param int|null $newVenueId id of this venue or null if a new venue
	 * @param int $newVenueProfileId id of the profile who owns this venue
	 * @param string $newVenueName string containing the venue name
	 * @param string $newVenueStreet1 string containing the first line of the street address
	 * @param string $newVenueStreet2 string containing the second line of a street address (if any)
	 * @param string $newVenueCity string containing the city in which the venue is located
	 * @param string $newVenueState string containing the state in which the venue is located
	 * @param string $newVenueZip string containing the zip code in which the venue is located
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (eg strings too long, negative integers)
	 * @throws \TypeError if data types violate hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newVenueId = null, int $newVenueProfileId, string $newVenueName, string $newVenueStreet1, string $newVenueStreet2, string $newVenueCity, string $newVenueState, string $newVenueZip) {
		try{
			$this->setVenueId($newVenueId);
			$this->setVenueProfileId($newVenueId);
			$this->setVenueName($newVenueName);
			$this->setVenueStreet($newVenueStreet1);
			$this->setVenueStreet2($newVenueStreet2);
			$this->setVenueCity($newVenueCity);
			$this->setVenueState($newVenueState);
			$this->setVenueZip($newVenueZip);
		} catch(\InvalidArgumentException\ $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
}
