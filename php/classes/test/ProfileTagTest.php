<?php
namespace Edu\Cnm\GigHub\Test;

use Edu\Cnm\bsteider\GigHub\{Profile, Tag};

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHPUnit test for the Tweet class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tweet
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/