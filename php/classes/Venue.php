<?php
namespace Edu\Cnm\GigHub;

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
	 * the city in which the venue is located
	 * @var string $venueCity
	 **/
	private $venueCity;
	/**
	 * the name of the venue
	 * @var string $venueName
	 **/
	private $venueName;
	/**
	 * state in which the venue is located
	 * @var string $venueState
	 **/
	private $venueState;
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
	 * zip code in which venue is located
	 * @var string $venueZip
	 **/
	private $venueZip;

	/**
	 * constructor for this Venue
	 *
	 * @param int|null $newVenueId id of this venue or null if a new venue
	 * @param int $newVenueProfileId id of the profile who owns this venue
	 * @param string $newVenueCity string containing the city in which the venue is located
	 * @param string $newVenueName string containing the venue name
	 * @param string $newVenueState string containing the state in which the venue is located
	 * @param string $newVenueStreet1 string containing the first line of the street address
	 * @param string|null $newVenueStreet2 string containing the second line of a street address (if any)
	 * @param string $newVenueZip string containing the zip code in which the venue is located
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (eg strings too long, negative integers)
	 * @throws \TypeError if data types violate hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newVenueId = null, int $newVenueProfileId, string $newVenueCity, string $newVenueName, string $newVenueState, string $newVenueStreet1, $newVenueStreet2, string $newVenueZip) {
		try {
			$this->setVenueId($newVenueId);
			$this->setVenueProfileId($newVenueProfileId);
			$this->setVenueCity($newVenueCity);
			$this->setVenueName($newVenueName);
			$this->setVenueState($newVenueState);
			$this->setVenueStreet1($newVenueStreet1);
			$this->setVenueStreet2($newVenueStreet2);
			$this->setVenueZip($newVenueZip);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for venue id
	 *
	 * @return int|null value of venue id
	 **/
	public function getVenueId() {
		return ($this->venueId);
	}

	/** mutator method for venue id
	 *
	 * @param int|null $newVenueId new value of venue id
	 * @throws \RangeException if $newVenueId is not positive
	 * @throws \TypeError if $newVenueId is not an integer
	 **/
	public function setVenueId(int $newVenueId = null) {
		// base case: if the venue id is null, this is a new venue without a mySQL assigned (yet)
		if($newVenueId === null) {
			$this->venueId = null;
			return;
		}

		// verify venue id is positive
		if($newVenueId <= 0) {
			throw(new \RangeException("venue id is not positive"));
		}

		// convert and store the venue id
		$this->venueId = $newVenueId;
	}

	/**
	 * accessor method for venue profile id
	 *
	 * @return int value of the venue profile id
	 **/
	public function getVenueProfileId() {
		return ($this->venueProfileId);
	}

	/**
	 * mutator method for venue profile id
	 *
	 * @param int|null $newVenueProfileId
	 * @throws \RangeException if $newVenueProfileId is not positive
	 * @throws \TypeError if $newVenueId is not an integer
	 **/
	public function setVenueProfileId(int $newVenueProfileId = null) {
		// verify the new profile id is positive
		if($newVenueProfileId <= 0) {
			throw(new \RangeException("venue profile id is not positive"));
		}
		if($newVenueProfileId === null) {
			throw(new \InvalidArgumentException("venue profile id is not null"));
		}

		// convert and store the profile id
		$this->venueProfileId = $newVenueProfileId;
	}

	/**
	 * accessor method for venue name
	 *
	 * @return string value of the venue name
	 **/
	public function getVenueName() {
		return ($this->venueName);
	}

	/**
	 * mutator method for venue name
	 *
	 * @param string $newVenueName new value of venue name
	 * @throws \InvalidArgumentException if $newVenueName is insecure
	 * @throws \RangeException if venueName is > 64 characters
	 * @throws \TypeError if $newVenueName is not a string
	 **/
	public function setVenueName(string $newVenueName) {
		// verify the !!!! is secure
		$newVenueName = trim($newVenueName);
		$newVenueName = filter_var($newVenueName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueName) === true) {
			throw(new \InvalidArgumentException("venue name is empty or insecure"));
		}

		// verify the !!!!! content will fit into the database
		if(strlen($newVenueName) > 64) {
			throw(new \RangeException("venue name content too large"));
		}

		// store the !!!! content
		$this->venueName = $newVenueName;
	}

	/**
	 * accessor method for venue street 1
	 *
	 * @return string value of the venue street 1
	 **/
	public function getVenueStreet1() {
		return ($this->venueStreet1);
	}

	/**
	 * mutator method for venue street 1
	 *
	 * @param string $newVenueStreet1 new value of venueStreet1
	 * @throws \InvalidArgumentException if $newVenueStreet1 is insecure
	 * @throws \RangeException if venueStreet1 is > 64 characters
	 * @throws \TypeError if $newVenueStreet1 is not a string
	 **/
	public function setVenueStreet1(string $newVenueStreet1) {
		// verify the venue street 2 is secure
		$newVenueStreet1 = trim($newVenueStreet1);
		$newVenueStreet1 = filter_var($newVenueStreet1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueStreet1) === true) {
			throw(new \InvalidArgumentException("venue street 1 is empty or insecure"));
		}

		// verify the venue street 1 content will fit into the database
		if(strlen($newVenueStreet1) > 64) {
			throw(new \RangeException("venue street 1 content too large"));
		}

		// store the !!!! content
		$this->venueStreet1 = $newVenueStreet1;
	}

	/**
	 * accessor method for venue street 2 (if any)
	 *
	 * @return string value of the venue street 2 (if any)
	 **/
	public function getVenueStreet2() {
		return ($this->venueStreet2);
	}

	/**
	 * mutator method for venue street 2
	 *
	 * @param string $newVenueStreet2 new value of venue street 2
	 * @throws \InvalidArgumentException if $newVenueStreet2 is insecure
	 * @throws \RangeException if venueStreet2 is > 64 characters
	 * @throws \TypeError if $newVenueStreet2 is not a string
	 **/
	public function setVenueStreet2(string $newVenueStreet2) {
		// verify the venue street 2 is secure
		$newVenueStreet2 = trim($newVenueStreet2);
		$newVenueStreet2 = filter_var($newVenueStreet2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if((empty($newVenueStreet2) === null)){
			$newVenueStreet2 = null;
		}
		// verify the venue street 2 content will fit into the database
		if(strlen($newVenueStreet2) > 64) {
			throw(new \RangeException("venue street 2 content too large"));
		}

		// store the venueStreet2 content
		$this->venueStreet2 = $newVenueStreet2;
	}

	/**
	 * accessor method for venue city
	 *
	 * @return string value of the venue city
	 **/
	public function getVenueCity() {
		return ($this->venueCity);
	}

	/**
	 * mutator method for venue city
	 *
	 * @param string $newVenueCity new value of venue city
	 * @throws \InvalidArgumentException if $newVenueCity is insecure
	 * @throws \RangeException if venueCity is > 100 characters
	 * @throws \TypeError if $newVenueCity is not a string
	 **/
	public function setVenueCity(string $newVenueCity) {
		// verify the venue city is secure
		$newVenueCity = trim($newVenueCity);
		$newVenueCity = filter_var($newVenueCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueCity) === true) {
			throw(new \InvalidArgumentException("venue city is empty or insecure"));
		}

		// verify the venue city content will fit into the database
		if(strlen($newVenueCity) > 100) {
			throw(new \RangeException("venue city content too large"));
		}

		// store the venue city content
		$this->venueCity = $newVenueCity;
	}

	/**
	 * accessor method for venue state
	 *
	 * @return string value of the venue state
	 **/
	public function getVenueState() {
		return ($this->venueState);
	}

	/**
	 * mutator method for venue state
	 *
	 * @param string $newVenueState new value of venue state
	 * @throws \InvalidArgumentException if $newVenueState is insecure
	 * @throws \RangeException if venueState is > 2 characters
	 * @throws \TypeError if $newVenueState is not a string
	 **/
	public function setVenueState(string $newVenueState) {
		// verify the venue state is secure
		$newVenueState = trim($newVenueState);
		$newVenueState = filter_var($newVenueState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueState) === true) {
			throw(new \InvalidArgumentException("venue state is empty or insecure"));
		}

		// verify the venue state content will fit into the database
		if(strlen($newVenueState) !== 2) {
			throw(new \RangeException("venue state content too large"));
		}

		// store the venue state content
		$this->venueState = $newVenueState;
	}

	/**
	 * accessor method for venue zip
	 *
	 * @return string value of the venue zip
	 **/
	public function getVenueZip() {
		return ($this->venueZip);
	}

	/**
	 * mutator method for venue zip
	 *
	 * @param string $newVenueZip new value of venue zip
	 * @throws \InvalidArgumentException if $newVenueZip is insecure
	 * @throws \RangeException if venueZip is > 10 characters
	 * @throws \TypeError if $new!!!!!! is not a string
	 **/
	public function setVenueZip(string $newVenueZip) {
		// verify the venue zip is secure
		$newVenueZip = trim($newVenueZip);
		$newVenueZip = filter_var($newVenueZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newVenueZip) === true) {
			throw(new \InvalidArgumentException("venue zip is empty or insecure"));
		}

		// verify the venue zip content will fit into the database
		if(strlen($newVenueZip) > 10) {
			throw(new \RangeException("venue zip content too large"));
		}

		// store the venue zip content
		$this->venueZip = $newVenueZip;
	}

	/**
	 * inserts this venue into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the venueId is null (i.e., don't insert a venue that already exists)
		if($this->venueId !== null) {
			throw(new \PDOException("not a new venue"));
		}

		// create query template
		$query = "INSERT INTO venue(venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip) VALUES(:venueProfileId, :venueCity, :venueName, :venueState, :venueStreet1, :venueStreet2, :venueZip)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["venueProfileId" => $this->venueProfileId, "venueCity" => $this->venueCity, "venueName" => $this->venueName, "venueState" => $this->venueState, "venueStreet1" => $this->venueStreet1, "venueStreet2" => $this->venueStreet2, "venueZip" => $this->venueZip];
		$statement->execute($parameters);

		// update the null venueId with what mySQL just gave us
		$this->venueId = intval($pdo->lastInsertId());
	}

	/**
	 * updates this venue in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) {
		// enforce the venueId is not null (i.e., don't update a venue that hasn't been inserted)
		if($this->venueId === null) {
			throw(new \PDOException("unable to update a venue that does not exist"));
		}

		// create query template
		$query = "UPDATE venue SET venueProfileId = :venueProfileId, venueCity = :venueCity, venueName = :venueName, venueState = :venueState, venueStreet1 = :venueStreet1, venueStreet2 = :venueStreet2, venueZip = :venueZip WHERE venueId = :venueId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template\
		$parameters = ["venueProfileId" => $this->venueProfileId,  "venueCity" => $this->venueCity, "venueName" => $this->venueName, "venueState" => $this->venueState, "venueStreet1" => $this->venueStreet1, "venueStreet2" => $this->venueStreet2, "venueZip" => $this->venueZip, "venueId" => $this->venueId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this venue from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// enforce the venueId is not null (i.e., don't delete a venue that hasn't been inserted)
		if($this->venueId === null) {
			throw(new \PDOException("unable to delete a venue that does not exist"));
		}

		// create query template
		$query = "DELETE FROM venue WHERE venueId = :venueId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["venueId" => $this->venueId];
		$statement->execute($parameters);
	}

	/**
	 * gets the venue by venueId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $venueId venue id to search for
	 * @return Venue|null Venue found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVenueByVenueId(\PDO $pdo, int $venueId) {
		// sanitize the venueId before searching
		if($venueId <= 0) {
			throw(new \PDOException("venue id is not positive"));
		}

		// create query template
		$query = "SELECT venueId, venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip FROM venue WHERE venueId = :venueId";
		$statement = $pdo->prepare($query);

		// bind the venue id to the place holder in the template
		$parameters = ["venueId" => $venueId];
		$statement->execute($parameters);

		// grab the venue from mySQL
		try {
			$venue = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$venue = new Venue($row["venueId"], $row["venueProfileId"], $row["venueCity"], $row["venueName"], $row["venueState"], $row["venueStreet1"], $row["venueStreet2"], $row["venueZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($venue);
	}

	/**
	 * gets the venue by venueProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $venueProfileId venue profile id to search for
	 * @return Venue|null Venue found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVenueByVenueProfileId(\PDO $pdo, int $venueProfileId) {
		// sanitize the venueId before searching
		if($venueProfileId <= 0) {
			throw(new \PDOException("venue profile id is not positive"));
		}

		// create query template
		$query = "SELECT venueId, venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip FROM venue WHERE venueProfileId = :venueProfileId";
		$statement = $pdo->prepare($query);

		// bind the venue id to the place holder in the template
		$parameters = ["venueProfileId" => $venueProfileId];
		$statement->execute($parameters);

		// grab the venue from mySQL
		try {
			$venue = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$venue = new Venue($row["venueId"], $row["venueProfileId"], $row["venueCity"], $row["venueName"], $row["venueState"], $row["venueStreet1"], $row["venueStreet2"], $row["venueZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($venue);
	}

	/**
	 * gets the venue by venue name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $venueName venue name to search for
	 * @return \SplFixedArray SplFixedArray of venues found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVenueByVenueName(\PDO $pdo, string $venueName) {
		// sanitize the description before searching
		$venueName = trim($venueName);
		$venueName = filter_var($venueName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($venueName) === true) {
			throw(new \PDOException("venue name is invalid"));
		}

		// create query template
		$query = "SELECT venueId, venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip FROM venue WHERE venueName LIKE :venueName";
		$statement = $pdo->prepare($query);

		// bind the venue content to the place holder in the template
		$venueName = "%$venueName%";
		$parameters = ["venueName" => $venueName];
		$statement->execute($parameters);

		// build an array of venues
		$venues = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$venue = new Venue($row["venueId"], $row["venueProfileId"], $row["venueCity"], $row["venueName"], $row["venueState"], $row["venueStreet1"], $row["venueStreet2"], $row["venueZip"]);
				$venues[$venues->key()] = $venue;
				$venues->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($venues);
	}

	/**
	 * gets the venue by venue street 1
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $venueStreet1 venue name to search for
	 * @return \SplFixedArray SplFixedArray of venues found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVenueByVenueStreet1(\PDO $pdo, string $venueStreet1) {
		// sanitize the description before searching
		$venueStreet1 = trim($venueStreet1);
		$venueStreet1 = filter_var($venueStreet1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($venueStreet1) === true) {
			throw(new \PDOException("venue street is invalid"));
		}

		// create query template
		$query = "SELECT venueId, venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip FROM venue WHERE venueStreet1 LIKE :venueStreet1";
		$statement = $pdo->prepare($query);

		// bind the venue content to the place holder in the template
		$venueStreet1 = "%$venueStreet1%";
		$parameters = ["venueStreet1" => $venueStreet1];
		$statement->execute($parameters);

		// build an array of venues
		$venues = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$venue = new Venue($row["venueId"], $row["venueProfileId"], $row["venueCity"], $row["venueName"], $row["venueState"], $row["venueStreet1"], $row["venueStreet2"], $row["venueZip"]);
				$venues[$venues->key()] = $venue;
				$venues->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($venues);
	}

	/**
	 * gets the venue by venue city
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $venueCity venue city to search for
	 * @return \SplFixedArray SplFixedArray of venues found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVenueByVenueCity(\PDO $pdo, string $venueCity) {
		// sanitize the description before searching
		$venueCity = trim($venueCity);
		$venueCity = filter_var($venueCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($venueCity) === true) {
			throw(new \PDOException("venue name is invalid"));
		}

		// create query template
		$query = "SELECT venueId, venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip FROM venue WHERE venueCity LIKE :venueCity";
		$statement = $pdo->prepare($query);

		// bind the venue content to the place holder in the template
		$venueCity = "%$venueCity%";
		$parameters = ["venueCity" => $venueCity];
		$statement->execute($parameters);

		// build an array of venues
		$venues = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$venue = new Venue($row["venueId"], $row["venueProfileId"], $row["venueCity"], $row["venueName"], $row["venueState"], $row["venueStreet1"], $row["venueStreet2"], $row["venueZip"]);
				$venues[$venues->key()] = $venue;
				$venues->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($venues);
	}

	/**
	 * gets the venue by venue zip
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $venueZip venue zip to search for
	 * @return \SplFixedArray SplFixedArray of venues found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVenueByVenueZip(\PDO $pdo, string $venueZip) {
		// sanitize the description before searching
		$venueZip = trim($venueZip);
		$venueZip = filter_var($venueZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($venueZip) === true) {
			throw(new \PDOException("venue name is invalid"));
		}

		// create query template
		$query = "SELECT venueId, venueProfileId, venueCity, venueName, venueState, venueStreet1, venueStreet2, venueZip FROM venue WHERE venueZip LIKE :venueZip";
		$statement = $pdo->prepare($query);

		// bind the venue content to the place holder in the template
		$venueZip = "%$venueZip%";
		$parameters = ["venueZip" => $venueZip];
		$statement->execute($parameters);

		// build an array of venues
		$venues = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$venue = new Venue($row["venueId"], $row["venueProfileId"], $row["venueCity"], $row["venueName"], $row["venueState"], $row["venueStreet1"], $row["venueStreet2"], $row["venueZip"]);
				$venues[$venues->key()] = $venue;
				$venues->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($venues);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}

}
