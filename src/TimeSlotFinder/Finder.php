<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 10.03.14
 * Time: 22:21
 */

namespace TimeSlotFinder;

use \TimeSlotFinder\DataLoader\Result as LoadedData;

/**
 * Class Finder.
 * This class is Singleton
 * @package TimeSlotFinder
 */
class Finder {

	/**
	 * The default number of possible time-slots that should be found.
	 */
	const DEFAULT_NUMBER_OF_POSSIBLE_TIME_SLOTS = 5;

	/**
	 * The maximal number of possible time-slots that should be found
	 */
	const MAX_NUMBER_OF_POSSIBLE_TIME_SLOTS = 100;

	/**
	 * The default time zone
	 */
	const DEFAULT_TIME_ZONE = 'UTC';

	/**
	 * Variable for storing instance
	 * @var Finder
	 */
	private static $instance;

	/**
	 * @var integer Number of possible time-slots that should be found
	 */
	private $numberOfPossibleTimeSlots;

	/**
	 * @var Attendee[] Array of attendees for which we will find time-slots
	 */
	private $attendees;

	/**
	 * @var Meeting Represent the meeting for that attendees would be found
	 */
	private $meeting;

	/**
	 * Disable create instance via new word
	 */
	private function __construct()
	{
		date_default_timezone_set(self::DEFAULT_TIME_ZONE);
		$this->numberOfPossibleTimeSlots = self::DEFAULT_NUMBER_OF_POSSIBLE_TIME_SLOTS;
	}

	/**
	 * Disable cloning
	 */
	private function __clone()
	{

	}

	/**
	 * Disable serialization
	 */
	private function __sleep()
	{

	}

	/**
	 * Disable deserialization
	 */
	private function __wakeup()
	{

	}

	/**
	 * Return instance of self
	 * @return Finder
	 */
	public static function getInstance()
	{
		if (static::$instance === null) {
			static::$instance = new self();
		}
		return static::$instance;
	}

	/**
	 * @param Attendee $attendee Add attendee to array for finding
	 */
	public function addAttendee(Attendee $attendee)
	{
		$this->attendees[] = $attendee;
	}


	public function find(LoadedData $result)
	{
		$this->numberOfPossibleTimeSlots = $result->possibleTimeSlots;
		$this->meeting = $result->meeting;
		$this->attendees = $result->attendees;

		
	}
} 