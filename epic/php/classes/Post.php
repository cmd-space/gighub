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
		return $this->postId;
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

}