<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * @author Brandon Steider <bsteider@cnm.edu>
 * @version 3.0.0
 **/
class PostTag implements \JsonSerializable {

	/**
	 * id for this postTag; this is a foreign key
	 * @var int $postTagId
	 **/
	private $postTagId;
	/**
	 * id for this Post Tag; this is a foreign key
	 * @var int $postTagId
	 **/
	private $postTagTagId;
	/**
	 * actual textual content of this PostTag
	 * @var \DateTime $PostTagDate
	 **/
	private $postTagPostId;
	/**
	 * actual textual content of this postTag
	 * @var int $postTagPostId
	 **/

public function __construct(int $newPostTagId = null, int $newPostTagTagId, int $newPostTagPostId) {
	try {
		$this->setPostTagId($newPostTagId);
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
/**
 * accessor method for post tag id
 *
 * @return int|null value of post tag id
 **/
public function getPostTagId() {
	return($this->postTagId);
}

	/**
	 * mutator method for post tag id
	 *
	 * @param int|null $newPostTagId new value of profile id
	 * @throws \RangeException if $newPostTagId is not positive
	 * @throws \TypeError if $newPostTagId is not an integer
	 **/
	public function setPostTagId(int $newPostTagId = null) {
		// base case: if the profile id is null, this is a new profile without a mySQL assigned id (yet)
		if($newPostTagId === null) {
			$this->postTagId = null;
			return;
		}

		// verify that the post tag id is positive
		if($newPostTagId <= 0) {
			throw(new \RangeException("post tag id is not positive... enough"));
		}

		// convert and store the post tag id
		$this->postTagId = $newPostTagId;
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
}/**
 * accessor method for post tag post id
 *
 * @return int value of post tag post id
 **/
public function getPostTagPostId() {
	return($this->postTagPostId);
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
		$query = "DELETE FROM `postTag` WHERE postTagTagId = :postTagPostId AND PostTagTagId = :postTagPostId";
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
	public static function getTagByPostTagIdAndPostTagPostId(\PDO $pdo, int $postTagTagId, int $postTagPostId) {
		// sanitize the post tag id and post tag id before searching
		if($postTagTagId <= 0) {
			throw(new \PDOException("post tag tag id is not positive"));
		}
		if($postTagPostId <= 0) {
			throw(new \PDOException("post tag post id is not positive"));
		}
		// create query template
		$query = "SELECT postTagTagId, postTagPostid FROM 'tag' WHERE postTagTagId = :postTagPostId AND profileTagTagid = :postTagPostId";
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
		return($postTagTagId);
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}
}

