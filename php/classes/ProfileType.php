<?php
namespace EDU\Cnm\GigHub;

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
	 * @throw \TypeError if $newProfileTypeName is not a string
	 **/
	public function setProfileTypeName(string $newProfileTypeName) {
		//verify the Profile Type Name is secure
		$newProfileTypeName = trim($newProfileTypeName);
		$newProfileTypeName = filter_var($newProfileTypeName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileTypeName) === true) {
			throw(new \InvalidArgumentException("Name content is empty"));
		}
		//store the profile type name
		return($this->proileTypeName);
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