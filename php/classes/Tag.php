<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");
/**
 * Small example of creating tags in GigHub
 *
 * This will show how we create tags to be stored on GigHub
 *
 * @author Dante Conley <danteconley@icloud.com>
 * @version 1.0
 **/

class Tag implements \JsonSerializable {
	/**
	 * id for this Tag; this is the primary key
	 * @var int $tagId
	 **/
	private $tagId;
	/**
	 *textual content of this tag
	 * @var string $tagContent
	 **/
	private $tagContent;

	/**
	 * constructor for this Tag
	 *
	 * @param int|null $newTagId id of this Tag or null if a new Tag
	 * @param string $newTagContent string containing actual tag data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (eg strings too long, negative integers)
	 * @throws \TypeError if data types violate hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newTagId = null, string $newTagContent){
		try {
			$this->setTagId($newTagId);
			$this->setTagContent($newTagContent);
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
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for tag id
	 *
	 * @return int|null value of tag id
	 **/
	public function getTagId() {
		return ($this->tagId);
	}

	/**
	 * mutator method for tag id
	 *
	 * @param int|null $newTagId new value of tag id
	 * @throws \RangeException if $newTagId is not positive
	 * @throws \TypeError if $newTagId is not an Integer
	 **/
	public function setTagId(int $newTagId = null) {
		// base case: if the tag id is null, this is a new tag without a mySQL assigned id (yet)
		if($newTagId === null) {
			$this->tagId = null;
			return;
		}

		//verify the tag id is positive
		if($newTagId <=0) {
			throw(new \RangeException("tag id is not positive"));
		}

		// convert this and store the tag id
		$this->tagId = $newTagId;
	}

	/**
	 * accessor method for tag content
	 *
	 * @return string value of tag content
	 **/
	public function getTagContent() {
		return($this->tagContent);
	}

	/**
	 * mutator method for tag content
	 *
	 * @param string $newTagContent new value of tag content
	 * @throws \InvalidArgumentException if $newTagContent is insecure
	 * @throws \RangeException if $newTagContent is > 64 characters
	 * @throws \TypeError if $newTagContent is not a string
	 **/
	public function setTagContent(string $newTagContent) {
		// verify the content is secure
		$newTagContent = trim($newTagContent);
		$newTagContent = filter_var($newTagContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTagContent) === true) {
			throw(new \InvalidArgumentException("tag content is insecure or empty"));
		}

		// verify the tag content will fit in the database
		if(strlen($newTagContent) > 64) {
			throw(new \RangeException("tag content too large"));
		}

		// store the tag content
		$this->tagContent = $newTagContent;
	}

	/**
	 * inserts this tag into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		// enforce the tagId is null (i.e., don't insert a tag that already exists)
		if($this->tagId !== null) {
			throw(new \PDOException("not a new tag"));
		}

		// create query template
		$query = "INSERT INTO tag(tagContent) VALUES(:tagContent)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["tagContent" => $this->tagContent];
		$statement->execute($parameters);

		// update the null tagId with what mySQL just gave us
		$this->tagContent = intval($pdo->lastInsertId());
	}

	/**
	 * gets the tag by tagId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $tagId tag id to search for
	 * @return tag|null tag found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTagByTagId(\PDO $pdo, int $tagId) {
		// sanitize the tagId before searching
		if($tagId <= 0) {
			throw(new \PDOException("tag id is not positive"));
		}

		// create query template
		$query = "SELECT tagId, tagContent FROM tag WHERE tagId = :tagId";
		$statement = $pdo->prepare($query);

		// bind the tag id to the place holder in the template
		$parameters = ["tagId" => $tagId];
		$statement->execute($parameters);

		// grab the tag from mySQL
		try {
			$tag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tag = new Tag($row["tagId"], $row["tagContent"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($tag);
	}

	/**
	 * gets the  tag by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $tagContent tag content to search for
	 * @return \SplFixedArray SplFixedArray of Tags found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTagByTagContent(\PDO $pdo, string $tagContent) {
		// sanitize the description before searching
		$tagContent = trim($tagContent);
		$tagContent = filter_var($tagContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($tagContent) === true) {
			throw(new \PDOException("tag content is invalid"));
		}

		// create query template
		$query = "SELECT tagId, tagContent FROM tag WHERE tagContent LIKE :tagContent";
		$statement = $pdo->prepare($query);

		// bind the tag content to the place holder in the template
		$tagContent = "%$tagContent%";
		$parameters = ["tagContent" => $tagContent];
		$statement->execute($parameters);

		// build an array of tags
		$tags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tag = new Tag($row["tagId"], $row["tagContent"]);
				$tags[$tags->key()] = $tag;
				$tags->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tags);
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