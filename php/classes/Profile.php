<?php
namespace Edu\Cnm\GigHub;

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
	 * constructor for this Profile
	 *
	 * @param int|null $newProfileId id of this Profile or null if a new Profile
	 * @param int $newProfileOAuthId id of the OAuth that created this Profile
	 * @param int $newProfileTypeId id of the Type for this Profile
	 * @param string $newProfileBio string containing actual bio data for this Profile
	 * @param string $newProfileImageCloudinaryId string containing actual Cloudinary image id data for this Profile
	 * @param string $newProfileLocation string containing actual Location data for this Profile
	 * @param string $newProfileOAuthToken string containing actual OAuth Token data for this Profile
	 * @param string $newProfileSoundCloudUser string containing actual SoundCloud username for this Profile
	 * @param string $newProfileUserName string containing actual User Name for this Profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (i.e. strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Error if some other exception occurs
	 **/
	public function __construct(int $newProfileId = null, int $newProfileOAuthId, int $newProfileTypeId, string $newProfileBio, string $newProfileImageCloudinaryId, string $newProfileLocation, string $newProfileOAuthToken, string $newProfileSoundCloudUser, string $newProfileUserName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileOAuthId($newProfileOAuthId);
			$this->setProfileTypeId($newProfileTypeId);
			$this->setProfileBio($newProfileBio);
			$this->setProfileImageCloudinaryId($newProfileImageCloudinaryId);
			$this->setProfileLocation($newProfileLocation);
			$this->setProfileOAuthToken($newProfileOAuthToken);
			$this->setProfileSoundCloudUser($newProfileSoundCloudUser);
			$this->setProfileUserName($newProfileUserName);
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
			throw(new \Error($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 **/
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(int $newProfileId = null) {
		// base case: if the profile id is null, this is a new profile without a mySQL assigned id (yet)
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// verify that the profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive... enough"));
		}

		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profile OAuth id
	 *
	 * @return int value of profile OAuth id
	 **/
	public function getProfileOAuthId() {
		return($this->profileOAuthId);
	}

	/**
	 * mutator method for profile OAuth id
	 *
	 * @param int $newProfileOAuthId new value of profile OAuth id
	 * @throws \RangeException if $newProfileOAuthId is not positive
	 * @throws \TypeError if $newProfileOAuthId is not an integer
	 **/
	public function setProfileOAuthId(int $newProfileOAuthId) {
		// verify that profile OAuth id is positive
		if($newProfileOAuthId <= 0) {
			throw(new \RangeException("Error, Error, profileOAuthId is clearly not positive"));
		}

		// convert and store the profile OAuth id
		$this->profileOAuthId = $newProfileOAuthId;
	}

	/**
	 * accessor method for profile type id
	 *
	 * @return int value of profile type id
	 **/
	public function getProfileTypeId() {
		return($this->profileTypeId);
	}

	/**
	 * mutator method for profile type id
	 *
	 * @param int $newProfileTypeId new value of profile type id
	 * @throws \RangeException if $newProfileTypeId is not positive
	 * @throws \TypeError if $newProfileTypeId is not an integer
	 **/
	public function setProfileTypeId(int $newProfileTypeId) {
		// verify that the profile type id is positive
		if($newProfileTypeId <= 0) {
			throw(new \RangeException("y u no haz positive profile type id?"));
		}

		// convert and store the profile type id
		$this->profileTypeId = $newProfileTypeId;
	}

	/**
	 * accessor method for profile bio
	 *
	 * @return string value of profile bio
	 **/
	public function getProfileBio() {
		return($this->profileBio);
	}

	/**
	 * mutator method for profile bio
	 *
	 * @param string $newProfileBio new value of profile bio
	 * @throws \InvalidArgumentException if $newProfileBio is insecure
	 * @throws \RangeException if $newProfileBio is > 669 characters
	 * @throws \TypeError if $newProfileBio is not a string
	 **/
	public function setProfileBio(string $newProfileBio) {
		// verify that the profile bio content is secure
		$newProfileBio = trim($newProfileBio);
		$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileBio) === true) {
			throw(new \InvalidArgumentException("profile bio is empty or insecure, brah!"));
		}

		// verify that profile bio content will fit in the database
		if(strlen($newProfileBio) > 669) {
			throw(new \RangeException("BRAH! Now profile bio is too long. brah..."));
		}

		// store the profile bio content
		$this->profileBio = $newProfileBio;
	}

	/**
	 * accessor method for profile image Cloudinary id
	 *
	 * @return string value of profile image Cloudinary id
	 **/
	public function getProfileImageCloudinaryId() {
		return($this->profileImageCloudinaryId);
	}

	/**
	 * mutator method for profile image Cloudinary id
	 *
	 * @param string $newProfileImageCloudinaryId new value of profile image Cloudinary id
	 * @throws \InvalidArgumentException if $newProfileImageCloudinaryId is insecure
	 * @throws \RangeException if $newProfileImageCloudinaryId is > 32 characters
	 * @throws \TypeError if $newProfileImageCloudinaryId is not a string
	 **/
	public function setProfileImageCloudinaryId(string $newProfileImageCloudinaryId) {
		// verify that profile image Cloudinary id is secure
		$newProfileImageCloudinaryId = trim($newProfileImageCloudinaryId);
		$newProfileImageCloudinaryId = filter_var($newProfileImageCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileImageCloudinaryId) === true) {
			throw(new \InvalidArgumentException("profile image Cloudinary id is empty and/or insecure"));
		}

		// verify that profile image Cloudinary id will fit in the database
		if(strlen($newProfileImageCloudinaryId) > 32) {
			throw(new \RangeException("profile image Cloudinary id is too largerererer"));
		}

		// store the profile image Cloudinary id
		$this->profileImageCloudinaryId = $newProfileImageCloudinaryId;
	}

	/**
	 * accessor method for profile location content
	 *
	 * @return string value of profile location content
	 **/
	public function getProfileLocation() {
		return($this->profileLocation);
	}

	/**
	 * mutator method for profile location content
	 *
	 * @param string @newProfileLocation new value of profile location content
	 * @throws \InvalidArgumentException if $newProfileLocation is insecure
	 * @throws \RangeException if $newProfileLocation is > 128 characters
	 * @throws \TypeError if $newProfileLocation is not a string
	 **/
	public function setProfileLocation(string $newProfileLocation) {
		// verify that profile location content is secure
		$newProfileLocation = trim($newProfileLocation);
		$newProfileLocation = filter_var($newProfileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLocation) === true) {
			throw( new \InvalidArgumentException( "profile location is empty or unintentionally malicious -- hacker bastards!" ));
		}
			// verify that profile location content will fit in the database
			if(strlen($newProfileLocation) > 128) {
				throw(new \RangeException("DAMN, that a YUGE Location!"));
			}

			// store the profile location if all else passes
			$this->profileLocation = $newProfileLocation;
	}

	/**
	 * accessor method for profile OAuth token
	 *
	 * @return string value of profile OAuth token content
	 **/
	public function getProfileOAuthToken() {
		return($this->profileOAuthToken);
	}

	/**
	 * mutator method for profile OAuth token
	 *
	 * @param string $newProfileOAuthToken new value of profile OAuth token content
	 * @throws \InvalidArgumentException if $newProfileOAuthToken is insecure
	 * @throws \RangeException if $newProfileOAuthToken is > 64 characters
	 * @throws \TypeError if $newProfileOAuthToken is not a string
	 **/
	public function setProfileOAuthToken(string $newProfileOAuthToken) {
		// verify that profile OAuth token content is secure
		$newProfileOAuthToken = trim($newProfileOAuthToken);
		$newProfileOAuthToken = filter_var($newProfileOAuthToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileOAuthToken) === true) {
			throw(new \InvalidArgumentException("profile OAuth token is empty or possibly insecure, mmmmmkay"));
		}

		// verify that profile OAuth token content will fit in the database
		if(strlen($newProfileOAuthToken) > 64) {
			throw(new \RangeException("that profile OAuth token is too darn big!"));
		}

		// store the profile OAuth token content
		$this->profileOAuthToken = $newProfileOAuthToken;
	}

	/**
	 * accessor method for profile SoundCloud user
	 *
	 * @return string value of profile SoundCloud user content
	 **/
	public function getProfileSoundCloudUser() {
		return($this->profileSoundCloudUser);
	}

	/**
	 * mutator method for profile SoundCloud user
	 *
	 * @param string $newProfileSoundCloudUser new value of profile SoundCloud user content
	 * @throws \InvalidArgumentException if $newProfileSoundCloudUser is insecure
	 * @throws \RangeException if $newProfileSoundCloudUser is > 32 characters
	 * @throws \TypeError if $newProfileSoundCloudUser is not a string
	 **/
	public function setProfileSoundCloudUser(string $newProfileSoundCloudUser) {
		// verify the profile SoundCloud user content is secure
		$newProfileSoundCloudUser = trim($newProfileSoundCloudUser);
		$newProfileSoundCloudUser = filter_var($newProfileSoundCloudUser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSoundCloudUser) === true) {
			throw(new \InvalidArgumentException("profile SoundCloud user content is fargin empty or haxors"));
		}

		// verify the profile SoundCloud user content will fit in the database
		if(strlen($newProfileSoundCloudUser) > 32) {
			throw(new \RangeException("profile SoundCloud user es muy grande"));
		}

		// store the profile SoundCloud user content
		$this->profileSoundCloudUser = $newProfileSoundCloudUser;
	}

	/**
	 * accessor method for profile user name content
	 *
	 * @return string value of profile user name content
	 **/
	public function getProfileUserName() {
		return($this->profileUserName);
	}

	/**
	 * mutator method for profile user name content
	 *
	 * @param string $newProfileUserName new value of profile user name content
	 * @throws \InvalidArgumentException if $newProfileUserName is insecure
	 * @throws \RangeException if $newProfileUserName is > 64 characters
	 * @throws \TypeError if $newProfileUserName is not a string
	 **/
	public function setProfileUserName(string $newProfileUserName) {
		// verify that profile user name content is secure
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("profile user name content is totes empty or insecure"));
		}

		// verify that profile user name content will fit in the database
		if(strlen($newProfileUserName) > 64) {
			throw(new \RangeException("profile user name content is bigger than it should be"));
		}

		// store the profile user name content
		$this->profileUserName = $newProfileUserName;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		// enforce that profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("this is not a new profile, skillet!"));
		}

		// create query template
		$query = "INSERT INTO profile(profileOAuthId, profileTypeId, profileBio, profileImageCloudinaryId, profileLocation, profileOAuthToken, profileSoundCloudUser, profileUserName) VALUES(:profileOAuthId, :profileTypeId, :profileBio, :profileImageCloudinaryId, :profileLocation, :profileOAuthToken, :profileSoundCloudUser, :profileUserName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["profileOAuthId" => $this->profileOAuthId, "profileTypeId" => $this->profileTypeId, "profileBio" => $this->profileBio, "profileImageCloudinaryId" => $this->profileImageCloudinaryId, "profileLocation" => $this->profileLocation, "profileOAuthToken" => $this->profileOAuthToken, "profileSoundCloudUser" => $this->profileSoundCloudUser, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);

		// update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * delete this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		// enforce the profileId is not null (i.e., don't delete a profile that doesn't exist
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that doesn't exist, even in your wildest dreams."));
		}

		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		// enforce that profileId is not null (i.e., don't update a tweet that doesn't exist
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that doesn't exist. CASH ME OUTSIDE! HOW BOW DAT?"));
		}

		// create query template
		$query = "UPDATE profile SET profileBio = :profileBio, profileImageCloudinaryId = :profileImageCloudinaryId, profileLocation = :profileLocation, profileOAuthToken = :profileOAuthToken, profileSoundCloudUser = :profileSoundCloudUser, profileUserName = :profileUsername WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["profileBio" => $this->profileBio, "profileImageCloudinaryId" => $this->profileImageCloudinaryId, "profileLocation" => $this->profileLocation, "profileOAuthToken" => $this->profileOAuthToken, "profileSoundCloudUser" => $this->profileSoundCloudUser, "profileUserName" => $this->profileUserName, "profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Profile by profile location content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileLocation profile location content to search for
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByLocationContent(\PDO $pdo, string $profileLocation) {
		// sanitize the search string before searching
		$profileLocation = trim($profileLocation);
		$profileLocation = filter_var($profileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileLocation) === true) {
			throw(new \PDOException("profile location content is error, error, error"));
		}

		// create query template
		$query = "SELECT profileId, profileOAuthId, profileTypeId, profileBio, profileImageCloudinaryId, profileLocation, profileOAuthToken, profileSoundCloudUser, profileUserName FROM profile WHERE profileLocation LIKE :profileLocation";
		$statement = $pdo->prepare($query);

		// bind the profile location content to the placeholder in the template
		$profileLocation = "%$profileLocation%";
		$parameters = ["profileLocation" => $profileLocation];
		$statement->execute($parameters);

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileOAuthId"], $row["profileTypeId"], $row["profileBio"], $row["profileImageCloudinaryId"], $row["profileLocation"], $row["profileOAuthToken"], $row["profileSoundCloudUser"], $row["profileUserName"]);
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}

	/**
	 * gets the Profile by SoundCloud user
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileSoundCloudUser SoundCloud user content to search for
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileBySoundCloudUserContent(\PDO $pdo, string $profileSoundCloudUser) {
		// sanitize the search term before searching
		$profileSoundCloudUser = trim($profileSoundCloudUser);
		$profileSoundCloudUser = filter_var($profileSoundCloudUser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileSoundCloudUser) === true) {
			throw(new \PDOException("SoundCloud user content is not valid"));
		}

		// create query template
		$query = "SELECT profileId, profileOAuthId, profileTypeId, profileBio, profileImageCloudinaryId, profileLocation, profileOAuthToken, profileSoundCloudUser, profileUserName FROM profile WHERE profileSoundCloudUser LIKE :profileSoundCloudUser";
		$statement = $pdo->prepare($query);

		// bind the profile SoundCloud user content to the placeholder in the template
		$profileSoundCloudUser = "%$profileSoundCloudUser%";
		$parameters = ["profileSoundCloudUser" => $profileSoundCloudUser];
		$statement->execute($parameters);

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileOAuthId"], $row["profileTypeId"], $row["profileBio"], $row["profileImageCloudinaryId"], $row["profileLocation"], $row["profileOAuthToken"], $row["profileSoundCloudUser"], $row["profileUserName"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
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