<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * @author Brandon Steider <bsteider@cnm.edu>
 * @version 3.0.0
 **/
class PostTag implements \JsonSerializable {

	/**
	 * Tag id for this postTag; this is a foreign key
	 * @var int $postTagId
	 **/
	private $postTagTagId;

	/**
	 * id of the post for this PostTag
	 * @var int $PostTagPost
	 **/
	private $postTagPostId;

	/**
	 * Constructor for class PostTag
	 * @param int $newPostTagPostId new value of post tag post Id
	 * @param int $newPostTagTagId new value of the tag id assigned to this postTag
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are not positive
	 * @throws \TypeError if the data entered is the incorrect type
	 * @throws \Exception if any other type of errors occur
	 **/

	public function __construct(int $newPostTagTagId, int $newPostTagPostId) {
		try {
			$this->setPostTagTagId($newPostTagTagId);
			$this->setPostTagPostId($newPostTagPostId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the calller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new\Exception($exception->getMessage(), 0, $exception));
		}
	}

	/* FIXME: accessor for postTagTagId here*/ /*is this good?*/
	/**
	 * accessors for class postTag
	 */
	/**
	 * accessor method for postTagTagId
	 * @return int value of PostTag post Id, foreign key
	 **/
	public function getPostTagTagId() {
		return ($this->postTagPostId);
		}

	/**
	 * mutator method for post tag tag id
	 *
	 * @param int|null $newPostTagTagId new value of post tag id
	 * @throws \RangeException if $newPostTagTagId is not positive
	 * @throws \TypeError if $newPostTagTagId is not an integer
	 **/
	public function setPostTagTagId(int $newPostTagTagId = null) {
		// verify the post tag tag id is positive
		if($newPostTagTagId <= 0) {
			throw(new \RangeException("post tag tag id is not positive"));
		}
		// convert and store the post tag tag id
		$this->postTagTagId = $newPostTagTagId;
	}

	/**
	 * accessor method for post tag post id
	 *
	 * @return int value of post tag post id
	 **/
	public function getPostTagPostId() {
		return ($this->postTagPostId);
	}

	/**
	 * mutator method for post tag post id
	 *
	 * @param int $newPostTagPostId new value of post tag post id
	 * @throws \RangeException if $newPostTagPostId is not positive
	 * @throws \TypeError if $newPostTagPostId is not an integer
	 **/
	public function setPostTagPostId(int $newPostTagPostId) {
		// verify the post tag post id is positive
		if($newPostTagPostId <= 0) {
			throw(new \RangeException("post tag post id is not positive"));
		}
		// convert and store the post tag post id
		$this->postTagPostId = $newPostTagPostId;
	}
	/**
	 * this is
	 * the
	 * PDO
	 * placeholder
	 * so i know where to look
	 * when i screw the pooch
	 * good luck.
	 **/

	/**
	 * inserts this post tag into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// ensure the object exists before inserting
		if($this->postTagTagId === null || $this->postTagPostId === null) {
			throw(new \PDOException("not a valid postTag"));

		}
		// create query template
		$query = "INSERT INTO `tag`(postTagTagId, postTagPostId) VALUES(:postTagTagId, :postTagPostId)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["postTagTagId" => $this->postTagPostId, "postTagPostId" => $this->postTagPostId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this post tag from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// ensure the object exists before deleting
		if($this->postTagTagId === null || $this->postTagPostId === null) {
			throw(new \PDOException("not a valid postTag"));
		}

		// create query template
		$query = "DELETE FROM `postTag` WHERE postTagTagId = :postTagTagId AND PostTagPostId = :postTagPostId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place hodlers in the template
		$parameters = ["postTagTagId" => $this->postTagTagId, "postTagPostId" => $this->postTagTagId];
		$statement->execute($parameters);
	}

	/**
	 * gets the post tag by tag id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $postTagTagId tag id to search for
	 * @param int $postTagPostId tat id to search for
	 * @return Tag|null Tag found or null if not found
	 **/
	/* FIXME: this method needs to be renamed getPostTagByPostTagTagIdAndPostTagPostId(), */
	/* is this gucci?*/

	public static function getPostTagByPostTagTagIdAndPostTagPostId(\PDO $pdo, int $postTagTagId, int $postTagPostId) {
		// sanitize the post tag id and post tag id before searching
		if($postTagTagId <= 0) {
			throw(new \PDOException("post tag tag id is not positive"));
		}
		if($postTagPostId <= 0) {
			throw(new \PDOException("post tag post id is not positive"));
		}
		// create query template
		$query = "SELECT postTagTagId, postTagPostid FROM 'tag' WHERE postTagTagId = :postTagTagId AND postTagPostId = :postTagPostId";
		$statement = $pdo->prepare($query);

		$parameters = ["postTagTagId" => $postTagTagId];
		$statement->execute($parameters);
		// grab the tag from mySQL
		try {
			$postTagTagId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tag = new tag($row["postTagTagId"], $row["postTagPostId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			var_dump($exception->getTrace());
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($postTagTagId);
	}

	/* FIXME: we need 2 more methods:
	 * - getPostTagsByPostTagTagId() - should return an array of all postTags by tagId
	 * - LOOK AT: getBeerTagByTagId()
	 *
	 * - getPostTagsByPostTagPostId() - should return an array of all postTags by postId
	 * - LOOK AT: getBeerTagByBeerId()
	 * */

	public static function getPostTagsByPostTagTagIdId(\PDO $pdo, int $postTagTagId) {
		// sanitize the tag id
		if($postTagTagId < 0) {
			throw(new \PDOException ("Tag Id is not positive"));
		}
		//create query template
		$query = "SELECT postTagpostId, postTagTagId FROM postTag WHERE postTagTagId = :postTagTagId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholders in the template
		$parameters = ["postTagTagId" => $postTagTagId];
		$statement->execute($parameters);
		//build an array of post tags
		$postTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$postTag = new PostTag($row["postTagPostId"], $row["postTagTagId"]);
				$postTags[$postTags->key()] = $postTag;
				$postTags->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($postTags);
	}

	public static function getPostTagByPostId(\PDO $pdo, int $postTagPostId) {
		//sanitize the post id
		if($postTagPostId < 0) {
			throw (new \PDOException("post id is not positive"));
		}
		//create query template
		$query = "SELECT postTagPostId, postTagTagId FROM postTag WHERE postTagPostId = :postTagPostId";
		$statement = $pdo->prepare($query);
		//bind the post id to the place holder in the template
		$parameters = ["postTagPostId" => $postTagPostId];
		$statement->execute($parameters);
		//build an array of postTags
		$postTags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$postTag = new PostTag($row["postTagPostId"], $row["postTagTagId"]);
				$postTags[$postTags->key()] = $postTag;
				$postTags->next();
			} catch(\Exception $exception) {
				//if the row cant be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($postTags);
	}

	/* are these groovy?*/

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */

	//jsonSerialize
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
		// TODO: Implement jsonSerialize() method.

}

