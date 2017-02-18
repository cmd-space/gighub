<?php
namespace Edu\Cnm\GigHub;
/**
 * Trait to validate a mySQL date
 *
 * This trait will inject a private method to validate a mySQL style date. It will convert a string representation to a DateTime object or throw an exception.
 *
 * @author Mason Crane <cmd-space.com>
 **/
trait ValidateDate {
	private static function validateDate($newDate) {
		// base case: if the date is a DateTime object, there's nothing to do
		if(is_object($newDate) === true && get_class($newDate) === "DateTime") {
			return($newDate);
		}
		// treat the date as a mySQL date string: Y:m:d
		$newDate = trim($newDate);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $newDate, $matches)) !== 1) {
			throw(new \InvalidArgumentException("date is not a valid date"));
		}

		// verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false) {
			throw(new \RangeException("date is not a Gregorian date"));
		}

		// if we got here, the date is correct
		$newDate = \DateTime::createFromFormat("Y-m-d H:i:s", $newDate . " 00:00:00");
		return($newDate);
	}

	/**
	 * custom filter for mySQL style dates
	 *
	 * Converts a string to a DateTime object or false if invalid. This is designed to be used within a mutator method
	 *
	 * @param string $newTime date to validate
	 * @return string validated time as a string H:i:s
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 **/
	private static function validateTime($newTime) {
		// treat the date as a mySQL date string: H:i:s
		$newTime = trim($newTime);
		if((preg_match("/^(\d{2}):(\d{2}):(\d{2})$/", $newTime, $matches)) !== 1) {
			throw(new \InvalidArgumentException("time is not a valid time"));
		}

		// verify the date is really a valid calendar date
		$hour = intval($matches[1]);
		$minute = intval($matches[2]);
		$second = intval($matches[3]);

		// verify the time is really a valid wall clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0 || $second >= 60) {
			throw(new \RangeException("date is not a valid wall clock time"));
		}

		// if we got here, the date is clean
		return($newTime);
	}

	/**
	 * custom filter for mySQL style dates
	 *
	 * Converts a string to a DateTime object or false if invalid. This is designed to be used within a mutator method
	 *
	 * @param mixed $newDateTime date to validate
	 * @return \DateTime DateTime object containing the validated date
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws \RangeException if the date is not a Gregorian date
	 * @throws \TypeError when type hints fail
	 * @throws \Exception if some other error occurs
	 **/
	private static function validateDateTime($newDateTime) {
		// base case: if the date is a DateTime object, there's nothing to do
		if(is_object($newDateTime) === true && get_class($newDateTime) === "DateTime") {
			return($newDateTime);
		}
		try {
			list($date, $time) = explode(" ", $newDateTime);
			$date = self::validateDate($date);
			$time = self::validateTime($time);
			list($hour, $minute, $second) = explode(":", $time);
			$intervalSpec = "PT" . $hour . "H" . $minute . "M" . $second . "S";
			$interval = new \DateInterval($intervalSpec);
			$date->add($interval);
			return($date);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
}