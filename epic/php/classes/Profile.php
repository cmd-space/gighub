<?php
namespace Edu\Cnm\Mcrane2\Profile;

require_once("autoload.php");
/**
 * Profile class
 *
 * Profile class as basis for most social networking features on GigHub, like a Facebook profile page. This can be extended to emulate more features of GigHub.
 *
 * @author Mason Crane <cmd-space.com>
 * @version 1.0.0
 **/
class Profile implements \JsonSerializable {
	/**
	 * id for this profile; this is the primary key
	 * @var int $profileId
	 **/
	private $profileId;
	/**
	 * id for profile OAuth; this is a foreign key
	 * @var int $profileOAuthId
	 **/
	private $profileOAuthId;
	/**
	 * id for profile type; this is a foreign key
	 * @var int $profileTypeId
	 **/
	private $profileTypeId;
	/**
	 * textual content of this profile bio
	 * @var $profileBio
	 **/
	private $profileBio;
	/**
	 * id for cloudinary image for this profile
	 * @var $profileImageCloudinaryId
	 **/
	private $profileImageCloudinaryId;
	/**
	 * location content for this profile
	 * @var $profileLocation
	 **/
	private $profileLocation;
	/**
	 * token content for OAuth for this profile
	 * @var $profileOAuthToken
	 **/
	private $profileOAuthToken;
	/**
	 * SoundCloud username content for this profile
	 * @var $profileSoundCloudUser
	 **/
	private $profileSoundCloudUser;
	/**
	 * username content for this profile
	 * @var $profileUserName
	 **/
	private $profileUserName;

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 **/


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