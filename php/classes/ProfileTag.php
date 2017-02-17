<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * @author Brandon Steider <bsteider@cnm.edu>
 * @version 3.0.0
 **/
class ProfileTag implements \JsonSerializable {

	/**
	 * Tag id for this profileTag; this is a foreign key
	 * @var int $profileTagId
	 **/
	private $profileTagTagId;

	/**
	 * id of the profile for this PostTag
	 * @var int $profileTagPost
	 **/
	private $profileTagProfileId;

	/**
	 * actual keys of this profileTag
	 *
	 * @param int $newProfileTagProfileId id of the Profile that is referenced
	 * @param int $newProfileTagTagId id of the Tag that is referenced
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (i.e. negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newProfileTagProfileId, int $newProfileTagTagId) {
		try {
			$this->setProfileTagTagId($newProfileTagTagId);
			$this->setProfileTagProfileId($newProfileTagProfileId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the calller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new\Exception($exception->getMessage(), 0, $exception));
		}
	}

	/* FIXME: accessor for profileTagTagId here*/ /*is this good?*/
	/**
	 * accessors for class profileTag
	 */
	/**
	 * accessor method for profileTagTagId
	 * @return int value of PostTag profile Id, foreign key
	 **/
	public function getProfileTagTagId() {
		return ($this->profileTagTagId);
	}

	/**
	 * mutator method for profile tag tag id
	 *
	 * @param int|null $newProfileTagTagId new value of profile tag id
	 * @throws \RangeException if $newProfileTagTagId is not positive
	 * @throws \TypeError if $newProfileTagTagId is not an integer
	 **/
	public function setProfileTagTagId(int $newProfileTagTagId) {
		// verify the profile tag tag id is positive
		if($newProfileTagTagId <= 0) {
			throw(new \RangeException("profile tag tag id is not positive"));
		}
		// convert and store the profile tag tag id
		$this->profileTagTagId = $newProfileTagTagId;
	}

	/**
	 * accessor method for Profile tag Profile id
	 *
	 * @return int value of Profile tag Profile id
	 **/
	public function getProfileTagProfileId() {
		return ($this->profileTagProfileId);
	}

	/**
	 * mutator method for Profile tag Profile id
	 *
	 * @param int $newProfileTagProfileId new value of profile tag profile id
	 * @throws \RangeException if $newProfileTagProfileId is not positive
	 * @throws \TypeError if $newProfileTagProfileId is not an integer
	 **/
	public function setProfileTagProfileId(int $newProfileTagProfileId) {
		// verify the profile tag profile id is positive
		if($newProfileTagProfileId <= 0) {
			throw(new \RangeException("profile tag profile id is not positive"));
		}
		// convert and store the profile tag profile id
		$this->profileTagProfileId = $newProfileTagProfileId;
	}
	/**
	 * this is
	 * the
	 * PDO
	 * placeholder
	 * so i know where to look
	 * when i screw the pooch
	 * good luck Ghost Rider.
	 **/

	/**
	 * inserts this profile tag into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// ensure the object exists before inserting
		if($this->profileTagTagId === null || $this->profileTagProfileId === null) {
			throw(new \PDOException("not a valid profileTag"));

		}
		// create query template
		$query = "INSERT INTO profileTag(profileTagProfileId, profileTagTagId) VALUES(:profileTagProfileId, :profileTagTagId)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileTagProfileId" => $this->profileTagProfileId, "profileTagTagId" => $this->profileTagTagId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this profile tag from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// ensure the object exists before deleting
		if($this->profileTagTagId === null || $this->profileTagProfileId === null) {
			throw(new \PDOException("not a valid profileTag"));
		}

		// create query template
		$query = "DELETE FROM `profileTag` WHERE profileTagTagId = :profileTagTagId AND ProfileITagProfileId = :profileTagProfileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileTagTagId" => $this->profileTagTagId, "profileTagProfileId" => $this->profileTagTagId];
		$statement->execute($parameters);
	}

	/**
	 * gets the profile tag by tag id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileTagTagId tag id to search for
	 * @param int $profileTagPostId tat id to search for
	 * @return $profileITag|null Tag found or null if not found
	 **/
	/* FIXME: this method needs to be renamed getProfileITagByProfileITagTagIdAndProfileITagProfileId(), */
	/* is this gucci?*/

	public static function getProfileTagByProfileTagTagIdAndProfileTagProfileId(\PDO $pdo, int $profileTagTagId, int $profileTagProfileId) {
		// sanitize the profile tag id and profile tag id before searching
		if($profileTagTagId <= 0) {
			throw(new \PDOException("profile tag tag id is not positive"));
		}
		if($profileTagProfileId <= 0) {
			throw(new \PDOException("profile tag profile id is not positive"));
		}
		// create query template
		$query = "SELECT profileTagProfileId, profileTagTagId FROM profileTag WHERE profileTagTagId = :profileTagTagId AND profileTagProfileId = :profileTagProfileId";

		$statement = $pdo->prepare($query);
		//bind the param
		$parameters = ["profileTagTagId" => $profileTagTagId, "profileTagProfileId" => $profileTagProfileId ];

		$statement->execute($parameters);
		// grab the tag from mySQL
		try {
			$profileTag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profileTag = new ProfileTag($row["profileTagTagId"], $row["profileTagProfileId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			var_dump($exception->getTrace());
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profileTag);
	}

	/* FIXME: we need 2 more methods:
	 * - getProfileTagsByProfileTagTagId() - should return an array of all profileTags by tagId
	 * - LOOK AT: getBeerTagByTagId()
	 *
	 * - getProfileTagsByProfileTagProfileId() - should return an array of all profileTags by profileId
	 * - LOOK AT: getBeerTagByBeerId()
	 * */

	public static function getProfileTagsByProfileTagTagId(\PDO $pdo, int $profileTagTagId) {
		// sanitize the tag id
		if($profileTagTagId < 0) {
			throw(new \PDOException ("Tag Id is not positive"));
		}
		//create query template
		$query = "SELECT profileTagProfileId, profileTagTagId FROM profileTag WHERE profileTagTagId = :profileTagTagId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholders in the template
		$parameters = ["profileTagTagId" => $profileTagTagId];
		$statement->execute($parameters);
		//build an array of profile tags
		$profileTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileTag = new ProfileTag($row["profileTagProfileId"], $row["profileTagTagId"]);
				$profileTags[$profileTags->key()] = $profileTag;
				$profileTags->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileTags);
	}

	public static function getProfileTagsByProfileTagProfileId(\PDO $pdo, int $profileTagProfileId) {
		//sanitize the profile id
		if($profileTagProfileId < 0) {
			throw (new \PDOException("profile id is not positive"));
		}
		//create query template
		$query = "SELECT profileTagProfileId, profileTagTagId FROM profileTag WHERE profileTagProfileId = :profileTagProfileId";
		$statement = $pdo->prepare($query);
		//bind the profile id to the place holder in the template
		$parameters = ["profileTagProfileId" => $profileTagProfileId];
		$statement->execute($parameters);
		//build an array of profileTags
		$profileTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileTag = new ProfileTag($row["profileTagProfileId"], $row["profileTagTagId"]);
				$profileTags[$profileTags->key()] = $profileTag;
				$profileTags->next();
			} catch(\Exception $exception) {
				//if the row cant be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileTags);
	}

	/* are these groovy?*/

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */

	//jsonSerialize
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
	// TODO: Implement jsonSerialize() method.
}

