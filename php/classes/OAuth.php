<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");
/**
 * Profile OAuth class
 *
 * OAuth class which allows users to sign up on GigHub.
 *
 * @author Mason Crane <cmd-space.com>
 * @version 1.0.0
 **/
class OAuth implements \JsonSerializable {
	/**
	 * id for this OAuth; this is the primary key
	 * @var int $oAuthId
	 **/
	private $oAuthId;
	/**
	 * id for profile OAuth; this is a foreign key
	 * @var string $oAuthServiceName
	 **/
	private $oAuthServiceName;

	/**
	 * constructor for this OAuth
	 *
	 * @param int|null $newOAuthId id of this OAuth or null if a new OAuth
	 * @param string $newOAuthServiceName string containing actual Service Name data for this OAuth
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newOAuthId = null, string $newOAuthServiceName) {
		try {
			$this->setOAuthId($newOAuthId);
			$this->setOAuthServiceName($newOAuthServiceName);
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
	 * accessor method for oAuth id
	 *
	 * @return int|null value of oAuth id
	 **/
	public function getOAuthId() {
		return($this->oAuthId);
	}

	/**
	 * mutator method for oAuth id
	 *
	 * @param int|null $newOAuthId new value of oAuth id
	 * @throws \RangeException if $newOAuthId is not positive
	 * @throws \TypeError if $newOAuthId is not an integer
	 **/
	public function setOAuthId(int $newOAuthId = null) {
		// base case: if the oAuth id is null, this is a new oAuth without a mySQL assigned id (yet)
		if($newOAuthId === null) {
			$this->oAuthId = null;
			return;
		}

		// verify that the oAuth id is positive
		if($newOAuthId <= 0) {
			throw(new \RangeException("oAuth id is not positive... porque?"));
		}

		// convert and store the oAuth id
		$this->oAuthId = $newOAuthId;
	}

	/**
	 * accessor method for oAuth service name
	 *
	 * @return string value of oAuth service name
	 **/
	public function getOAuthServiceName() {
		return($this->oAuthServiceName);
	}

	/**
	 * mutator method for oAuth service name
	 *
	 * @param string $newOAuthServiceName new value of oAuth service name
	 * @throws \InvalidArgumentException if $newOAuthServiceName is insecure
	 * @throws \RangeException if $newOAuthServiceName is > 32 characters
	 * @throws \TypeError if $newOAuthServiceName is not a string
	 **/
	public function setOAuthServiceName(string $newOAuthServiceName) {
		// verify that the oAuth service name content is secure
		$newOAuthServiceName = trim($newOAuthServiceName);
		$newOAuthServiceName = filter_var($newOAuthServiceName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOAuthServiceName) === true) {
			throw(new \InvalidArgumentException("oAuth service name is empty or insecure..."));
		}

		// verify that oAuth service name content will fit in the database
		if(strlen($newOAuthServiceName) > 32) {
			throw(new \RangeException("oAuth service name is probably too long"));
		}

		// store the oAuth service name content
		$this->oAuthServiceName = $newOAuthServiceName;
	}

	/**
	 * inserts this OAuth into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce the oAuthId is null (i.e., don't insert an oAuth that already exists)
		if($this->oAuthId !== null) {
			throw(new \PDOException("OAuth already exists, silly!"));
		}

		// create query template
		$query = "INSERT INTO oAuth(oAuthServiceName) VALUES(:oAuthServiceName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["oAuthServiceName" => $this->oAuthServiceName];
		$statement->execute($parameters);

		// update the null oAuthId with what mySQL just gave us
		$this->oAuthId = intval($pdo->lastInsertId());
	}

	/**
	 * get ALL the oAuths
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of oAuths found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getAllOAuths(\PDO $pdo) {
		// create query template
		$query = "SELECT oAuthId, oAuthServiceName FROM oAuth";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of oAuths
		$oAuths = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$oAuth = new OAuth($row["oAuthId"], $row["oAuthServiceName"]);
				$oAuths[$oAuths->key()] = $oAuth;
				$oAuths->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($oAuths);
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