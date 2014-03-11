<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 1:43
 */

namespace TimeSlotFinder\DataLoader;

use TimeSlotFinder\Attendee;
use TimeSlotFinder\DataLoader\Source\Fields;
use TimeSlotFinder\DataLoader\Source\ISource;
use TimeSlotFinder\Meeting;
use TimeSlotFinder\TimeSlot;

class Loader implements ILoader {

	/**
	 * @var Data Store loaded data
	 */
	private $data;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->data = new Data();
	}

	/**
	 * Load data from source
	 *
	 * @param ISource $source
	 */
	public function loadInputData(ISource $source)
	{
		$this->loadPossibleTimeSlots($source);
		$this->loadMeeting($source);
		$this->loadAttendees($source);
	}

	/**
	 * Getter for $data property
	 * @return Data
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Load possible time-slots that should be found
	 *
	 * @throws \RuntimeException
	 * @param ISource $source
	 */
	private function loadPossibleTimeSlots(ISource $source)
	{
		$input = $source->getData();
		if (isset($input[Fields::POSSIBLE_TIME_SLOTS])) {
			$number = (int)$input[Fields::POSSIBLE_TIME_SLOTS];
			if ($number < 1) {
				throw new \RuntimeException('Possible times-lots must be greater than 0');
			}
			if ($number > self::MAX_NUMBER_OF_POSSIBLE_TIME_SLOTS) {
				$number = self::MAX_NUMBER_OF_POSSIBLE_TIME_SLOTS;
			}
			$this->data->setPossibleTimeSlots($number);
		} else {
			$this->data->setPossibleTimeSlots(self::DEFAULT_NUMBER_OF_POSSIBLE_TIME_SLOTS);
		}
	}

	/**
	 * Return default time zone
	 * @return \DateTimeZone
	 */
	private static function getDefaultTimezone()
	{
		static $tz;
		if ($tz === null) {
			$tz = new \DateTimeZone(self::DEFAULT_TIME_ZONE);
		}
		return $tz;
	}

	/**
	 * Load meeting's information
	 *
	 * @param ISource $source
	 * @throws \RuntimeException
	 */
	private function loadMeeting(ISource $source)
	{
		$input = $source->getData();
		if (!isset($input[Fields::MEETING])) {
			throw new \RuntimeException('Invalid input data structure. Specify \'' . Fields::MEETING . '\' section');
		}
		$input = $input[Fields::MEETING];
		$meeting = new Meeting();
		foreach (array(Fields::MEETING_TITLE, Fields::MEETING_DURATION, Fields::MEETING_DATE, Fields::MEETING_TIMEZONE) as $param) {
			if (!isset($input[$param])) {
				throw new \RuntimeException('You should specify meeting ' . $param);
			}
			if ($param == Fields::MEETING_TIMEZONE) {
				$meeting->setTimezone(new \DateTimeZone($input[$param]));
			} else {
				$meeting->{'set' . ucfirst($param)}($input[$param]);
			}
		}
		$this->data->setMeeting($meeting);
	}

	/**
	 * Load attendee information
	 * @param ISource $source
	 * @throws \RuntimeException
	 */
	private function loadAttendees(ISource $source)
	{
		$input = $source->getData();
		if (!isset($input[Fields::ATTENDEES])) {
			throw new \RuntimeException('Invalid input data structure. Specify \'' . Fields::ATTENDEES . '\' section');
		}
		$attendees = array();
		foreach ($input[Fields::ATTENDEES] as $attendee) {
			$tz = isset($attendee[Fields::ATTENDEE_TIMEZONE])
				? new \DateTimeZone($attendee[Fields::ATTENDEE_TIMEZONE])
				: static::getDefaultTimezone();

			$workingHoursFrom = new \DateTime($attendee[Fields::ATTENDEE_WORKING_HOURS_FROM], $tz);
			$workingHoursTo = new \DateTime($attendee[Fields::ATTENDEE_WORKING_HOURS_TO], $tz);
			$workingTimeSlot = new TimeSlot($workingHoursFrom, $workingHoursTo);
			$attendeeObject = new Attendee($workingTimeSlot);

			if (isset($attendee[Fields::ATTENDEE_BOOKED])) {
				foreach ($attendee[Fields::ATTENDEE_BOOKED] as $booked) {
					$dt1 = new \DateTime($booked[Fields::ATTENDEE_BOOKED_FROM], $tz);
					$dt2 = new \DateTime($booked[Fields::ATTENDEE_BOOKED_TO], $tz);
					$bookedTimeSlot = new TimeSlot($dt1, $dt2);
					$attendeeObject->addBookedTimeSlot($bookedTimeSlot);
				}
			}
			$attendees[] = $attendeeObject;
		}
		$this->data->setAttendees($attendees);
	}
} 