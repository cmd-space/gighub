<?php
namespace Edu\Cnm\bsteider\ProfileTag;

require_once("autoload.php");

/**
 * ask later what comments to put here regarding gighub
 * @author Brandon Steider <bsteider@cnm.edu>
 **/
Class ProfileTag implements \JsonSerializable {
	/**
	 * id for this ProfileTag; this is the foreign key
	 * @var int $ProfileTag
	 **/
	private $ProfileTagTagId;
	/**
	 * this is a foreign key
	 * @var int $ProfileTagProfileId
	 */
	private $ProfileTagProfileId;
	/**
	 *constructor for this ProfileTag
	 *
	 * @param int|not null $ProfileTagProfileId
	 * @param int $ProfileTagTagId
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newProfileTagId = null, int $newProfileTagProfileId);
	try {
$this->setProfileTagId($newProfileTagid);
$this->setProfileTagTagId($newProfileTagTagId);
} catch(\InvalidArgumentException $invalidArgument){
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
 * @return int|not null value of profile tag tag id
 **/
public function getProfileTagTagId() {
	return($this->profileTagTagId);
}

/**
 * mutator method for profile tag tag id
 *
 * @param int|not null $newProfileTagTagId new value of profile tag id
 * @throws \RangeException if $newProfileTagTagId is not positive
 * @throws \TypeEroe if $newProfileTagTagId is not an integer
 **/
public funtion setProfileTagTagId(int $newProfileTagTagId = not null) {
	// base case: if the profile tag id is not null, this a new tweet without a mySQL assigned id (yet)
	if($newProfileTagTagId === not null) {
		$this->profileTagTagId = not null;
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
	return($this->profileTagProfileId);
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
	/**
	 * accessor method for ProfileTagProfileId
	 *
	 * @return string value of tweet content
	 **/
	public function getProfileTagProfileId() {
		return($this->ProfileTagProfileId);
	}

}
