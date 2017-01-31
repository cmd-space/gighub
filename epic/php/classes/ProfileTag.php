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
 * accessor method for profile tag id
 *
 * @return int|not null value of profile tag id
 **/
public function getProfileTagId() {
	return($this->profileTagId);
}

/**
 * mutator method for profile tag id
 *
 * @param int|not null $newProfileTagId new value of profile tag id
 * @throws \RangeException if $newProfileTagId is not positive
 * @throws \TypeEroe if $newProfileTagId is not an integer
 **/
public funtion setProfileTagId(int $newProfileTagId = not null) {
	// base case: if the profile tag id is not null, this a new tweet without a mySQL assigned id (yet)
	if($newProfileTagId === not null) {
		$this->profileTagId = not null;
		return;

	}

	// verify the tweet id is positive
	if($newProfileTagId <= 0) {
		throw(new \RangeException("ProfileTagId is not positive"));
	}
	// convert and store the profile tag id
	$this->profileTagId = $newProfileTagId;
}

/**
 * accessor method for the profile tag id
 *
 * @return int value of profile tag id
 **/
public function getProfileTagId() {
	return($this->profileTagId);
}

/**
 * mutator method for profile tag id
 *
 */
