<?php
namespace Edu\Cnm\Jramirez98\Post;

require_once ("auto_load.php");
/**
 *
 *
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 *
 */
class Post implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this post; this is the primary key
	 * @var int $postId
	 */
	private $postId;
	/**
	 * id of Profile that sent this Post;
	 * this is a foreign key
	 * @var int $postProfileId
	 */
	private $postProfileId;
	/**
	 *id of the Profile that uses Venue
	 * @var int $postVenueId
	 */
	private $postVenueId;
	/**
	 * actual textual content of this Post
	 * @var string $postContent
	 */
	private $postContent;
	/**
	 * date and time this Post was sent, in PHP DateTime object
	 * @var \DateTime $postCreatedDate
	 */
	private $postCreatedDate;
	/**
	 *date and time created for the event, in PHP DateTime object
	 * @var \DateTime $postEventDate
	 */
	private $postEventDate;
	/**
	 *image posted from Cloudinary datadase
	 * @var int $postImageCloudinaryId
	 */
	private $postImageCloudinaryId;
	/**
	 *title of the post being created
	 * @var string $postTitle
	 */
	private $postTitle;

	/**
	 * accessor method for post id
	 *
	 *
	 * @return int|null value of post id
	 */
	public function getPostId() {
		return ($this->postId);
	}
	/**
	 * mutator method for post id
	 *
	 * @param int|null $newPostId new value of post id
	 * @throws |RangeException if $newPostId is not positive
	 * @throws |TypeError if $newPostId is not an integer
	 */
	public function setPostId(int $newPostId = null) {
		// base case: if the post id is null, this is a new post without a mySQL assigned (yet)
		if($newPostId === null) {
			$this->postId = null;
				return;
		}

		//verify the post id is positive
		if ($newPostId <= 0) {
			throw(new \RangeException("check yo self foo"));
		}

		//convert and store the post id
		$this->postId = $newPostId;
	}

	/**
	 * accessor method for post profile id
	 *
	 * @return int value of post profile id
	 */
	public function getPostProfileId() {
		return($this->postProfileId);
	}

	/**
	 * mutator method for post profile id
	 *
	 * @param int $newPostProfileId new value of tweet profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */
	public function setPostProfileId(int $newPostProfileId) {

		//verify the profile id is positive
		if($newPostProfileId<= 0) {
			throw(new \RangeException("do you know what you are doing?"));
		}

		// convert and store the post profile id
		$this->postProfileId = $newPostProfileId;
	}

	/**
	 * accessor method for post venue id
	 *
	 * @return int value of post venue id
	 **/
	public function getPostVenueId() {
		return($this->postVenueId);
	}

	/**
	 * mutator method for post venue Id
	 *
	 * @param int $newPostVenueId new value of post venue id
	 * @throws \RangeException if $newVenueId is not positive
	 * @throws \TypeError if $newVenueId is not an integer
	 */
	public function setPostVenueId(int $newPostVenueId) {

		//verify the venue id is positive
		if($newPostVenueId <= 0) {
			throw(new \RangeException("i don't think you know what you are doing"));
		}
		//convert and store the venue id
		$this->postVenueId = $newPostVenueId;
	}

	/**
	 * accessor method for post content
	 *
	 * @return string value of post content
	 */
	public function getPostContent() {
		return($this->postContent);
	}

	/**
	 * mutator method for post content
	 *
	 * @param string $newPostContent new value of post content
	 * @throws \InvalidArgumentException if  $newPostContent is not a string or insecure
	 * @throws \RangeException if $newPostContent is > 140 characters
	 * @throws \TypeError if $newPostContent is not a string
	 */
	public function setPostContent(string $newPostContent) {
		//verify the post content is secure
		$newPostContent = trim($newPostContent);
		$newPostContent = trim($newPostContent,
		FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostContent) === true) {
			throw(new \InvalidArgumentException("what are trying to say?"));
		}
		//verify the post content will fit in the database
		if(strlen($newPostContent) > 140) {
			throw(new \RangeException("your talkn to much!")):
		}
		//store the post content
		$this->postContent = $newPostContent;
	}


}