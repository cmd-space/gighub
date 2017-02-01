<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * ask later what comments to put here regarding gighub
 * @author Brandon Steider <bsteider@cnm.edu>
 **/
class ProfileTag implements \JsonSerializable {
	/**
	 * id for this ProfileTag; this is the foreign key
	 * @var int $ProfileTag
	 **/
	private $profileTagTagId;
	/**
	 * this is a foreign key
	 * @var int $ProfileTagProfileId
	 */
	private $profileTagProfileId;

	/**
	 *constructor for this ProfileTag
	 *
	 * @param int|null $newProfileTagProfileId
	 * @param int $newProfileTagTagId
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newProfileTagTagId = null, int $newProfileTagProfileId) {
		try {
			$this->setProfileTagTagId($newProfileTagTagId);
			$this->setProfileTagTagId($newProfileTagTagId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
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
	 * accessor method for profile tag tag id
	 *
	 * @return int|null value of profile tag tag id
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
		// base case: if the profile tag id is not null, this a new tweet without a mySQL assigned id (yet)
		if($newProfileTagTagId === null) {
			$this->profileTagTagId = null;
			return;

		}

		// verify the tweet id is positive
		if($newProfileTagTagId <= 0) {
			throw(new \RangeException("ProfileTagTagId is not positive"));
		}
		// convert and store the profile tag tag id
		$this->profileTagTagId = $newProfileTagTagId;
	}

	/**
	 * accessor method for the profile tag profile id
	 *
	 * @return int value of profile tag profile id
	 **/
	public function getProfileTagProfileId() {
		return ($this->profileTagProfileId);
	}

	/**
	 * mutator method for profile tag id
	 *
	 * @param int $newProfileTagProfileId new value of profile tag id
	 * @throws \RangeException if $newProfileTagProfileId is not positive
	 * @throws \TypeError if $newProfileTagProfileId is not an integer
	 **/
	public function setProfileTagProfileId(Int $newProfileTagProfileId) {
		// verify the profile id is positive
		if($newProfileTagProfileId <= 0) {

			//convert and store the profile tag id
			$this->ProfileTagProfileId = $newProfileTagProfileId;
		}
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
