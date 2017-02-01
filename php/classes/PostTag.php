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
	}
}
}

