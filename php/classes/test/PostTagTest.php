<?php
namespace Edu\Cnm\Bsteider\Gighub\Test;

use Edu\Cnm\Bsteider\Gighub\{Post, Tag};
use Edu\Cnm\GigHub\PostTag;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHPUit test for the PostTag class
 *
 * This is a complete PHPUnit test of the PostTag class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see PostTag
 * @author Brandon Steider <bsteider@cnm.edu>
 **/
class PostTagTest extends GigHubTest {
	/**
	 * content of the PostTag
	 * @var string $VALID_POSTTAGID
	 **/
	protected $VALID_POSTTAGID = "PHPUnit test passing";
	/**
	 * content of the updated PostTag
	 * @string $VALID_POSTTAGID
	 */
}