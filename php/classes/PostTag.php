<?php
namespace Edu\Cnm\GigHub;

require_once("autoload.php");

/**
 * @author Brandon Steider <bsteider@cnm.edu>
 * @version 3.0.0
 **/
class PostTag implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this PostTag; this is a foreign key
	 * @var int $postTagId
	 **/
	private $postTagId;
	/**
	 * id for this Post Tag; this is a foreign key
	 * @var int $PostTagId
	 **/
	private $PostTagTagId
	/**
	 * actual textual content of this PostTag
	 * @var \DateTime $PostTagDate
	 **/
	private $postTagPostId;
	/**
	 * actual textual content of this PostTag
	 * @var \DateTime $postTagPostId
	 **/
	private $PostTagDate;

public function __construct(int $newPostTagId = null, int $newPostTagTagId, string $newPostTagPostId) {
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
 * mutator method for post tag tag id
 *
 * @param int|null $newPostTagTagId new value of post tag id
 * @throws \RangeException if $newPostTagTagId is not positive
 * @throws \TypeError if $newPostTagTagId is not an integer
 **/
public function setPostTagTagId(int $newPostTagId = null) {
	// base case: if the post tag tag id is null, this a new post tag without a mySQL assigned id (yet)
	if($newPostTagTagId === null) {
		$this->postTagTagId = null;
		return;
	}
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
	if($newPostTagPostId <=0) {
		throw(new \RangeException("post tag post id is not positive"));
	}
	// convert and store the post tag post id
	$this->postTagPostId = $newPostTagPostId;
}
}

