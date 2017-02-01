<?php
namespace Edu\Cnm\Mcrane2\OAuth;

require_once("autoload.php");
/**
 * Profile OAuth class
 *
 * oAuth class which allows users to sign up on GigHub.
 *
 * @author Mason Crane <cmd-space.com>
 * @version 1.0.0
 **/
class oAuth implements \JsonSerializable {
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
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}