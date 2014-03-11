<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 10.03.14
 * Time: 22:21
 */

namespace TimeSlotFinder;

use TimeSlotFinder\DataLoader\Result as LoadedData;

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

	private function setResult(LoadedData $result)
	{
		$this->numberOfPossibleTimeSlots =
			$result->possibleTimeSlots > self::MAX_NUMBER_OF_POSSIBLE_TIME_SLOTS
				? self::MAX_NUMBER_OF_POSSIBLE_TIME_SLOTS
				: $result->possibleTimeSlots;
		$this->meeting = $result->meeting;
		$this->attendees = $result->attendees;
	}

	/**
	 * Return the minimal date from that period will be begin
	 * @return \DateTime
	 */
	private function getStartDateForPeriod()
	{
		if (count($this->attendees) == 1) {
			$attendee = $this->attendees[0];
			$dt = $attendee->getWorkingHoursFrom();
			$dt->setTimezone(new \DateTimeZone('UTC'));
			return $dt;
		}
		$returnDateTime = $this->attendees[0]->getWorkingHoursFrom()->setTimezone(new \DateTimeZone('UTC'));
		$attendeesCount = count($this->attendees);
		for ($i = 1; $i < $attendeesCount; $i++) {
			$attendee = $this->attendees[$i];
			$dt = $attendee->getWorkingHoursFrom()->setTimezone(new \DateTimeZone('UTC'));
			$diff = $dt->diff($returnDateTime);
			if (!$diff->invert) {
				$returnDateTime = $dt;
			}
		}
		return $returnDateTime;
	}

	/**
	 * Return the maximal date from that period will be begin
	 * @return \DateTime
	 */
	private function getEndDateForPeriod()
	{
		if (count($this->attendees) == 1) {
			$attendee = $this->attendees[0];
			$dt = $attendee->getWorkingHoursTo();
			$dt->setTimezone(new \DateTimeZone(\DateTimeZone::UTC));
			return $dt;
		}
		$returnDateTime = $this->attendees[0]->getWorkingHoursTo()->setTimezone(new \DateTimeZone('UTC'));
		$attendeesCount = count($this->attendees);
		for ($i = 1; $i < $attendeesCount; $i++) {
			$attendee = $this->attendees[$i];
			$dt = $attendee->getWorkingHoursTo()->setTimezone(new \DateTimeZone('UTC'));
			$diff = $dt->diff($returnDateTime);
			if ($diff->invert) {
				$returnDateTime = $dt;
			}
		}
		return $returnDateTime;
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

	public function find(LoadedData $result)
	{
		$this->setResult($result);

		// create interval for finding
		$intervalSpec = sprintf('PT%dM', $this->meeting->getDuration());
		$interval = new \DateInterval($intervalSpec);
		$period = new \DatePeriod($this->getStartDateForPeriod(), $interval, $this->getEndDateForPeriod()->modify('+1 hour'));

		$foundTimeSlots = array();
		$i = 0;
		foreach ($period as $dt) {
			$canAttend = array();
			foreach ($this->attendees as $attendee) {
				if ($attendee->canAttend($this->meeting, $dt)) {
					$canAttend[] = $attendee;
				}
			}
			if (count($canAttend) == count($this->attendees)) {
				// we find datetime
				$foundTimeSlots[] = TimeSlot::createFromDatetime($dt, $interval);
				$i++;
				if ($i >= $this->numberOfPossibleTimeSlots) {
					break;
				}
			}
		}
		if ($foundTimeSlots === array()) {
			echo "Not found";
		}
		foreach ($foundTimeSlots as $slot) {
			echo $slot . "\n";
		}
	}
} 