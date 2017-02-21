<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * Post class
 *
 * this class is the basis for post creating and function for GigHub social networking site
 *
 * @author Joseph Ramirez <jramirez98@cnm.edu>
 * @version 1.0.0
 */
class Post implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this post; this is the primary key
	 * @var int $postId
	 **/
	private $postId;
	/**
	 * id of Profile that sent this Post;
	 * this is a foreign key
	 * @var int $postProfileId
	 **/
	private $postProfileId;
	/**
	 *id of the Profile that uses Venue
	 * @var int $postVenueId
	 **/
	private $postVenueId;
	/**
	 * actual textual content of this Post
	 * @var string $postContent
	 **/
	private $postContent;
	/**
	 * date and time this Post was sent, in PHP DateTime object
	 * @var \DateTime $postCreatedDate
	 **/
	private $postCreatedDate;
	/**
	 *date and time created for the event, in PHP DateTime object
	 * @var \DateTime $postEventDate
	 **/
	private $postEventDate;
	/**
	 *image posted from Cloudinary datadase
	 * @var string $postImageCloudinaryId
	 **/
	private $postImageCloudinaryId;
	/**
	 *title of the post being created
	 * @var string $postTitle
	 **/
	private $postTitle;

	/**
	 *construct for this post
	 *
	 * @param int|null $newPostId id of this post or null it a new post
	 * @param int $newPostProfileId id of the profile that sent this post
	 * @param int $newPostVenueId id of the venue that sent this post
	 * @param string $newPostContent string containing actual post data
	 * @param string $newPostImageCloudinaryId string containing image post data
	 * @param string $newPostTitle string containing the title of the post
	 * @param \DateTime|string|null $newPostCreatedDate date and time Post was sent or null if set to current date and time
	 * @param \DateTime|string|null $newPostEventDate date and time event is set or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings to long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occur
	 **/
	public function __construct(int $newPostId = null, int $newPostProfileId, int $newPostVenueId, string $newPostContent, $newPostCreatedDate = null, $newPostEventDate = null, string $newPostImageCloudinaryId, string $newPostTitle) {
		try {
			$this->setPostId($newPostId);
			$this->setPostProfileId($newPostProfileId);
			$this->setPostVenueId($newPostVenueId);
			$this->setPostContent($newPostContent);
			$this->setPostCreatedDate($newPostCreatedDate);
			$this->setPostEventDate($newPostEventDate);
			$this->setPostImageCloudinaryId($newPostImageCloudinaryId);
			$this->setPostTitle($newPostTitle);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for post id
	 *
	 *
	 * @return int|null value of post id
	 **/
	public function getPostId() {
		return ($this->postId);
	}

	/**
	 * mutator method for post id
	 *
	 * @param int|null $newPostId new value of post id
	 * @throws |RangeException if $newPostId is not positive
	 * @throws |TypeError if $newPostId is not an integer
	 **/
	public function setPostId(int $newPostId = null) {
		// base case: if the post id is null, this is a new post without a mySQL assigned (yet)
		if($newPostId === null) {
			$this->postId = null;
			return;
		}

		//verify the post id is positive
		if($newPostId <= 0) {
			throw(new \RangeException("check yo self foo"));
		}

		//convert and store the post id
		$this->postId = $newPostId;
	}

	/**
	 * accessor method for post profile id
	 *
	 * @return int value of post profile id
	 **/
	public function getPostProfileId() {
		return ($this->postProfileId);
	}

	/**
	 * mutator method for post profile id
	 *
	 * @param int $newPostProfileId new value of tweet profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setPostProfileId(int $newPostProfileId) {

		//verify the profile id is positive
		if($newPostProfileId <= 0) {
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
		return ($this->postVenueId);
	}

	/**
	 * mutator method for post venue Id
	 *
	 * @param int $newPostVenueId new value of post venue id
	 * @throws \RangeException if $newVenueId is not positive
	 * @throws \TypeError if $newVenueId is not an integer
	 **/
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
	 **/
	public function getPostContent() {
		return ($this->postContent);
	}

	/**
	 * mutator method for post content
	 *
	 * @param string $newPostContent new value of post content
	 * @throws \InvalidArgumentException if  $newPostContent is not a string or insecure
	 * @throws \RangeException if $newPostContent is > 255 characters
	 * @throws \TypeError if $newPostContent is not a string
	 **/
	public function setPostContent(string $newPostContent) {
		//verify the post content is secure
		$newPostContent = trim($newPostContent);
		$newPostContent = filter_var($newPostContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostContent) === true) {
			throw(new \InvalidArgumentException("what are trying to say?"));
		}
		//verify the post content will fit in the database
		if(strlen($newPostContent) > 255) {
			throw(new \RangeException("your talkn to much!"));
		}
		//store the post content
		$this->postContent = $newPostContent;
	}

	/**
	 * accessor method for post created date
	 *
	 * @return \DateTime value of post created date
	 **/
	public function getPostCreatedDate() {
		return ($this->postCreatedDate);
	}

	/**
	 * mutator method for post created date
	 *
	 * @param \DateTime|string|null $newPostCreatedDate post date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newPostCreatedDate is not a valid object or string
	 * @throws \RangeException if $newPostCreatedDate is a date that does exist
	 **/
	public function setPostCreatedDate($newPostCreatedDate = null) {
		//base case: if the date is null, use the current date and time
		if($newPostCreatedDate === null) {
			$this->postCreatedDate = new \DateTime();
			return;
		}
		//store the post created date
		try {
			$newPostCreatedDate = self::validateDateTime($newPostCreatedDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->postCreatedDate = $newPostCreatedDate;
	}

	/**
	 * accessor method for post event date
	 *
	 * @return \DateTime value of post event date
	 **/
	public function getPostEventDate() {
		return ($this->postEventDate);
	}

	/**
	 * mutator method for post event date
	 *
	 * @param \DateTime|string|null $newPostEventDate post event date is not a valid object or string
	 * @throws \InvalidArgumentException if $newPostEventDate is not a valid object or string
	 * @throws \RangeException if $newPostEvent is a date that does not exist
	 **/
	public function setPostEventDate($newPostEventDate = null) {
		//base case: if the date is null, use the current date and time
		if($newPostEventDate === null) {
			$this->postEventDate = new \DateTime();
			return;
		}
		// store the post event date
		try {
			$newPostEventDate = self::validateDateTime($newPostEventDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->postEventDate = $newPostEventDate;
	}

	/**
	 *accessor method for image Cloudinary id
	 *
	 * @return string value of image cloudinary image
	 **/
	public function getPostImageCloudinaryId() {
		return ($this->postImageCloudinaryId);
	}

	/**
	 * mutator method for post image cloudinary id
	 *
	 * @param string $newPostImageCloudinaryId new value of Cloudinary id content
	 * @throws \InvalidArgumentException if $newPostImageCloudinaryId is not a string or insecure
	 * @throws \RangeException if $newPostImageCloudinaryId is > 32 characters
	 * @throws \TypeError if $newPostImageCloudinaryId is not a string
	 **/
	public function setPostImageCloudinaryId(string $newPostImageCloudinaryId) {
		// verify the post image cloudinary id is secure
		$newPostImageCloudinaryId = trim($newPostImageCloudinaryId);
		$newPostImageCloudinaryId = filter_var($newPostImageCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostImageCloudinaryId) === true) {
			throw(new \InvalidArgumentException("image id is empty or insecure"));
		}
		//verify the post image cloudinary id will fit in the database
		if(strlen($newPostImageCloudinaryId) > 32) {
			throw(new \RangeException("this is not one-size fits all, the content is to big"));
		}
		//store the post image cloudinary id
		$this->postImageCloudinaryId = $newPostImageCloudinaryId;
	}

	/**
	 * accessor method for post title
	 *
	 * @return string value of post title
	 */
	public function getPostTitle() {
		return ($this->postTitle);
	}

	/**
	 * mutator method for post title
	 *
	 * @param string $newPostTitle new value of post title content
	 * @throws \InvalidArgumentException if $newPostTitle is not a string or insecure
	 * @throws \RangeException if $newPostTitle is not > 64 characters
	 * @throws \TypeError if $newPostTitle is not a string
	 */
	public function setPostTitle(string $newPostTitle) {
		//verify the post title is secure
		$newPostTitle = trim($newPostTitle);
		$newPostTitle = filter_var($newPostTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostTitle) === true) {
			throw(new \InvalidArgumentException("fill this out and make sure its safe"));
		}
		//verify the post title will fit in the database
		if(strlen($newPostTitle) > 64) {
			throw(new \RangeException("shorten your name"));
		}
		//store the post title
		$this->postTitle = $newPostTitle;
	}

	/**
	 * inserts this post into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		//enforce the postId is null (i.e., don't insert a post that already exists)
		if($this->postId !== null) {
			throw(new \PDOException("This is a fake"));
		}

		//create query template
		$query = "INSERT INTO post(postProfileId, postVenueId, postContent, postCreatedDate, postEventDate, postImageCloudinaryId, postTitle) VALUES( :postProfileId, :postVenueId, :postContent, :postCreatedDate, :postEventDate, :postImageCloudinaryId, :postTitle)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->postCreatedDate->format("Y-m-d H:i:s");
		$formattedDate2 = $this->postEventDate->format("Y-m-d H:i:s");
		$parameters = ["postProfileId" => $this->postProfileId, "postVenueId" => $this->postVenueId, "postContent" => $this->postContent, "postCreatedDate" => $formattedDate, "postEventDate" => $formattedDate2, "postImageCloudinaryId" => $this->postImageCloudinaryId, "postTitle" => $this->postTitle];
		$statement->execute($parameters);

		//update the null postId with what mySQL just gave us
		$this->postId = intval($pdo->LastInsertId());
	}

	/**
	 * deletes this post from mySQL
	 *
	 * @param \PDO $pdo PDO connection objective
	 * @throws \PDOException wen mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		//enforce the postId is not null (i.e., don't delete a post that hasn't been inserted)
		if($this->postId ===null) {
			throw(new \PDOException("you cant delete whats not there"));
		}

		//create query template
		$query = "DELETE FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["postId" => $this->postId];
		$statement->execute($parameters);
	}

	/**
	 *  updates this post in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection
	 **/
	public function update(\PDO $pdo) {
		//enforce the postId is not null (i.e., don't update a post that hasn't been inserted)
		if($this->postId === null) {
			throw(new \PDOException("What comes first? the post or the update?"));
		}
		// create query template
		$query = "UPDATE post SET postProfileId = :postProfileId, postVenueId= :postVenueId, postContent = :postContent, postCreatedDate = :postCreatedDate, postEventDate = :postEventDate, postImageCloudinaryId = :postImageCloudinaryId, postTitle = :postTitle WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->postCreatedDate->format("Y-m-d H:i:s");
		$formattedDate2 = $this->postEventDate->format("Y-m-d H:i:s");

		$parameters = ["postProfileId"=> $this-> postProfileId, "postVenueId"=> $this-> postVenueId, "postContent"=> $this-> postContent, "postCreatedDate"=> $formattedDate, "postEventDate"=> $formattedDate2, "postImageCloudinaryId"=> $this-> postImageCloudinaryId, "postTitle"=> $this-> postTitle, "postId" => $this->postId];
		$statement->execute($parameters);
	}

	/**
	 *gets the Post by contents
	 *
	 * @param \PDO $pdo PDO connection Object
	 * @param string $postContent to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \ PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public static function getPostByPostContent(\PDO $pdo, string $postContent) {
		// sanitize the description before searching
		$postContent = trim($postContent);
		$postContent = filter_var($postContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($postContent) === true) {
			throw(new \PDOException("post content is invalid"));
		}

		// create query template
		$query = "SELECT postId, postProfileId, postVenueId, postContent, postCreatedDate, postEventDate, postImageCloudinaryId, postTitle FROM post WHERE postContent LIKE :postContent";
		$statement = $pdo->prepare($query);

		// bind the Post content to the place holder in the template
		$postContent = "%$postContent%";
		$parameters = ["postContent" => $postContent];
		$statement->execute($parameters);

		// build an array of Posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postVenueId"], $row["postContent"], $row["postCreatedDate"], $row["postEventDate"], $row["postImageCloudinaryId"], $row["postTitle"]);
				$posts [$posts->key()] = $post;
				$posts->next();
			}  catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}

	/**
	 * gets the Post by PostId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $postId post id to search for
	 * @return Post|null Post found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostId(\PDO $pdo, int $postId) {
		//sanitize the postId before searching
		if($postId<= 0) {
			throw(new \PDOException("post id is not positive "));
		}

		// create query template
		$query = "SELECT postId, postProfileId, postVenueId, postContent, postCreatedDate, postEventDate, postImageCloudinaryId, postTitle FROM post WHERE postId LIKE :postId";
		$statement = $pdo->prepare($query);

		// bind the post id to the place holder in the template
		$parameters = ["postId"=> $postId];
		$statement->execute($parameters);

		// grab the post from mySQl
		try {
			$post = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postVenueId"], $row["postContent"], $row["postCreatedDate"], $row["postEventDate"], $row["postImageCloudinaryId"], $row["postTitle"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($post);
	}

	/**
	 * gets the Post by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $postProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Post found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostProfileId(\PDO $pdo, int $postProfileId) {
		//sanitize the profile id before searching
		if($postProfileId <= 0) {
			throw(new \RangeException("post profile id must be positive"));
		}

		// create query template
		$query = "SELECT postId, postProfileId, postVenueId, postContent, postCreatedDate, postEventDate, postImageCloudinaryId, postTitle FROM post WHERE postProfileId = :postProfileId";
		$statement = $pdo->prepare($query);

		// bind the post profile id to the place holder in the template
		$parameters = ["postProfileId" => $postProfileId];
		$statement->execute($parameters);

		// build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) != false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postVenueId"], $row["postContent"], $row["postCreatedDate"], $row["postEventDate"], $row["postImageCloudinaryId"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}

	/**
	 * gets all Posts
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of posts found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllPosts (\PDO $pdo) {
		// create query template
		$query = "SELECT postId, postProfileId, postVenueId, postContent, postCreatedDate, postEventDate, postImageCloudinaryId, postTitle FROM post";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !==false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postVenueId"], $row["postContent"], $row["postCreatedDate"], $row["postEventDate"], $row["postImageCloudinaryId"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				// if the row couldnt be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
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