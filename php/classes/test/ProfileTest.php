<?php
namespace Edu\Cnm\GigHub\Profile\Test;

use Edu\Cnm\GigHub\{OAuth, Profile, ProfileType};
use Edu\Cnm\Gighub\Test\GigHubTest;

// grab the project test parameters
require_once("GigHubTest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because ALL mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Mason Crane <cmd-space.com>
 */
class ProfileTest extends GigHubTest {
	/**
	 * content of the Profile bio
	 * @var string $VALID_PROFILEBIO
	 */
	protected $VALID_PROFILEBIO = "PHPUnit test passing. This is my bio. Dab.";
	/**
	 * content of the updated Profile bio
	 * @var string $VALID_PROFILEBIO2
	 */
	protected $VALID_PROFILEBIO2 = "PHPUnit test still passing. More bio.";
	/**
	 * Profile image Cloudinary id string
	 * @var string $VALID_CLOUDINARYID
	 */
	protected $VALID_CLOUDINARYID = "PHPUnit cloudinary passing";
	/**
	 * Profile location string
	 * @var string $VALID_PROFILELOCATION
	 */
	protected $VALID_PROFILELOCATION = "PHPUnit passing Albuquerque";
	/**
	 * Profile OAuth Token string
	 * @var string $VALID_OAUTHTOKEN
	 */
	protected $VALID_OAUTHTOKEN = "PHPUnit passing, so token. Wow.";
	/**
	 * Profile SoundCloud User string
	 * @var string $VALID_SOUNDCLOUDUSER
	 */
	protected $VALID_SOUNDCLOUDUSER = "PHPUnit passing. Many Songs. Wow.";
	/**
	 * Profile User Name string
	 * @var string $VALID_USERNAME
	 */
	protected $VALID_USERNAME = "PHPUnit passing. User name. Yay.";
}