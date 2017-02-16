<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");
/**
 * Profile Type class
 *
 * Profile type class is the basis for the user to choose between three types of profiles the Venue, Band, or fan
 * each profile will be viewing different feed backs.
 *
 * @author Joseph J Ramirez <jramirez98@cnm.edu>
 * @version 1.0.0
 */
class ProfileType implements \JsonSerializable {
	/**
	 * id for this profile type; this is the primary key
	 * @var int $profileTypeId
	 */
	private $profileTypeId;

	/**
	 * this is the name of the profile type
	 * @var string $profileTypeName
	 **/
	private $profileTypeName;

	/**
	 * constructor for profile type class
	 *
	 * @param int|null $newProfileTypeID id of this profile type or null it a new profile type id
	 * @param string $newProfileTypeName string containing actual profile type data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e,g,. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newProfileTypeId = null, string $newProfileTypeName) {
		try {
			$this->setProfileTypeId($newProfileTypeId);
			$this->setProfileTypeName($newProfileTypeName);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile type id
	 *
	 * @return int|null value of profile type id
	 */
	public function getProfileTypeId() {
		return($this->profileTypeId);
	}

	/**
	 * mutator for profile type id
	 *
	 * @param int|null $newProfileTypeId new value of profile type id
	 * @throws \RangeException if $newProfileTypeId is not positive
	 * @throws \TypeError if $newProfileTypeId is not an integer
	 **/
	public function setProfileTypeId( int $newProfileTypeId = null) {
		//base case: if the profile type id is null, this is new profile type id without a mySQL assigned id (yet)
		if($newProfileTypeId === null) {
			$this->profileTypeId = null;
			return;
		}
		//verify the profile type id is positive
		if($newProfileTypeId <= 0) {
			throw(new \RangeException("id is not positive"));
		}
		//convert and store the profile type id
		$this->profileTypeId = $newProfileTypeId;
	}

	/**
	 * accessor method for profile type name
	 *
	 * @return string value of profile type name
	 **/
	public function getProfileTypeName() {
		return($this->profileTypeName);
	}

	/**
	 * mutator for profile type name
	 *
	 * @param string $newProfileTypeName new value of profile type name
	 * @throws \InvalidArgumentException if $newProfileTypeName is not a string or insecure
	 * @throws \RangeException if $newProfileTypeName is > 64 characters
	 * @throws \TypeError if $newProfileTypeName is not a string
	 **/
	public function setProfileTypeName(string $newProfileTypeName) {
		//verify the Profile Type Name is secure
		$newProfileTypeName = trim($newProfileTypeName);
		$newProfileTypeName = filter_var($newProfileTypeName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileTypeName) === true) {
			throw(new \InvalidArgumentException("Name content is empty"));
		}
		//verify the profile type name will fit in the database
		if(strlen($newProfileTypeName) > 64) {
			throw(new \RangeException("All that content wont fit!"));
		}
		//store the profile type name
		$this->profileTypeName = $newProfileTypeName;
	}

	/**
	 * inserts this post type into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not PDO connection object
	 **/
	public function insert (\PDO $pdo) {
		//enforce the profileTypeId is null (i.e., don't insert a profileType that already exists)
		if($this->profileTypeId !== null) {
			throw(new \PDOException("this ain't a fresh profile type!"));
		}

		//create query template
		$query = "INSERT INTO profileType(profileTypeName) VALUES (:profileTypeName)";
		$statement = $pdo->prepare($query);

		//bind the member to the placeholders in the template
		// deleted parameters  ["profileTypeId" => $this->profileTypeId, as it gives primary key by default
		$parameters = ["profileTypeName" => $this->profileTypeName];
		$statement->execute($parameters);

		//update the null profile type id  with what mySQL just gave us
		$this->profileTypeId = intval($pdo->lastInsertId());
	}

		/**
		 * updates profile type id in mySQL
		 *
		 * @param \PDO $pdo connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 */
		public function update(\PDO $pdo) {
			//enforce the profile type id is not null (i.e., don't update a profile type id that hasn't been inserted )
			if($this->profileTypeId === null) {
				throw(new \PDOException("Error! Error! Error! 404-A: Profile Type Not Found"));
			}
			//create query template
			$query = "UPDATE profileType SET  profileTypeName = :profileTypeName WHERE profileTypeId = :profileTypeId";
			$statement = $pdo->prepare($query);

			//bind the member to the placeholders in the template
		$parameters = ["profileTypeId" => $this->profileTypeId, "profileTypeName" => $this->profileTypeName];
		$statement->execute($parameters);
		}

	/**
	 *get profiletype by profiletypeid
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileTypeId profileType found or null if not found
	 * @return ProfileTypeId|null ProfileType found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variable are not the correct data type
	 **/
	public static function getProfileTypeByProfileTypeId(\PDO $pdo, int $profileTypeId) {
		// sanitize the profileTypeId before searching
	if($profileTypeId <= 0) {
		throw(new \PDOException("Profile Type id is not positive"));
}

// create query template
		$query = "SELECT profileTypeId, profileTypeName FROM profileType WHERE profileTypeId = :profileTypeId";
	$statement = $pdo = $pdo->prepare($query);

	// bind the profile type id to the place holder in the template
		$parameters =  ["profileTypeId" => $profileTypeId];
		$statement->execute($parameters);

		// grab the profile type from mySQL
		try {
				$profileType = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch(); {
					$profileType = new ProfileType($row["profileTypeId"], $row["profileTypeName"]);
			}
		}catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profileType);
	}
// TODO: create two more methods, get profile types by profile type name, and get all profile types C:

	/**
	 *get profile types by profile type name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileTypeName profile type name to search for
	 * @return \SplFixedArray SplFixedArray of profile types found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileTypesByProfileTypeName(\PDO $pdo, string $profileTypeName) {
		// sanitize the profileTypeId before searching
		$profileTypeName = trim( $profileTypeName );
		$profileTypeName = filter_var( $profileTypeName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES );
		if ( empty( $profileTypeName ) === true ) {
			throw( new \PDOException( "profile type name is all the errors/empty" ) );
		}

		// create query template
		$query = "SELECT profileTypeId, profileTypeName FROM profileType WHERE profileTypeName LIKE :profileTypeName";
		$statement = $pdo->prepare($query);

		// bind the profile location content to the placeholder in the template
		$profileTypeName = "%$profileTypeName%";
		$parameters = ["profileTypeName" => $profileTypeName];
		$statement->execute($parameters);

		// build an array of profiles
		$profileTypes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileType = new ProfileType($row["profileTypeId"], $row["profileTypeName"]);
				$profileTypes[$profileTypes->key()] = $profileType;
				$profileTypes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profileTypes);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}