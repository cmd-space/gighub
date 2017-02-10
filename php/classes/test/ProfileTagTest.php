<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\bsteider\GigHub\{Profile, Tag};

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHPUnit test for the ProfileTag class
 *
 * This is a complete PHPUnit test of the ProfileTag class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProfileTag
 * @author Brandon Steider <bsteider@cnm.edu>
 **/

class ProfileTagTest extends GigHubTest {
	/**
	 * content of the ProfileTag
	 * @var string $VALID_PROFILETAGTAGID
	 **/
	protected $VALID_PROFILETAGTAG = "PHPUnit test passing";
	/**
	 * content of the updated ProfileTagTagId
	 * @var string $VALID_PROFILETAGTAGID
	 **/
	protected $VALID_PROFILETAGPROFILEID = "PHPUnit test still passing";
	/**
	 *WORDS
	 **/

	protected $profile = null;