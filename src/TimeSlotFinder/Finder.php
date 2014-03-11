<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 10.03.14
 * Time: 22:21
 */

namespace TimeSlotFinder;

use TimeSlotFinder\DataLoader\Data;
use TimeSlotFinder\Result\Embedded as FindResult;

/**
 * Class Finder.
 * This class is Singleton
 *
 * @package TimeSlotFinder
 */
class Finder {

	/**
	 * Variable for storing instance
	 * @var Finder
	 */
	private static $instance;

	/**
	 * Loaded data
	 *
	 * @var Data
	 */
	private $data;

	/**
	 * The result of searching
	 *
	 * @var \TimeSlotFinder\Result\IResult
	 */
	private $result;

	/**
	 * Disable create instance via new word
	 */
	private function __construct()
	{

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
	 * Return interval in that empty time-slots will be finding
	 *
	 * @return \DateInterval
	 */
	private function getInterval()
	{
		$intervalSpec = sprintf('PT%dM', $this->data->getMeeting()->getDuration());
		return new \DateInterval($intervalSpec);
	}

	/**
	 * @param \DateInterval $interval
	 * @return \DatePeriod
	 */
	private function getPeriod(\DateInterval $interval)
	{
		return new \DatePeriod($this->calculateStartDateForPeriod(), $interval, $this->calculateEndDateForPeriod());
	}

	/**
	 * @return \DateTimeZone
	 */
	private static function getBaseTomeZone()
	{
		static $tz;
		if ($tz === null) {
			$tz = new \DateTimeZone('UTC');
		}
		return $tz;
	}

	/**
	 * Return the minimal date from that period will be begin
	 * @return \DateTime
	 */
	private function calculateStartDateForPeriod()
	{
		$attendees = $this->data->getAttendees();
		$attendeesCount = count($attendees);
		if ($attendeesCount == 1) {
			$dt = $attendees[0]->getWorkingHours()->getDatetimeFrom(static::getBaseTomeZone());
			return $dt;
		}
		$returnDateTime = $attendees[0]->getWorkingHours()->getDatetimeFrom(static::getBaseTomeZone());
		for ($i = 1; $i < $attendeesCount; $i++) {
			$attendee = $attendees[$i];
			$dt = $attendee->getWorkingHours()->getDatetimeFrom(static::getBaseTomeZone());
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
	private function calculateEndDateForPeriod()
	{
		$attendees = $this->data->getAttendees();
		$attendeesCount = count($attendees);
		if ($attendeesCount == 1) {
			$dt = $attendees[0]->getWorkingHours()->getDatetimeTo(static::getBaseTomeZone());
			return $dt->modify('+1 hour');
		}
		$returnDateTime = $attendees[0]->getWorkingHours()->getDatetimeTo(static::getBaseTomeZone());
		for ($i = 1; $i < $attendeesCount; $i++) {
			$attendee = $attendees[$i];
			$dt = $attendee->getWorkingHours()->getDatetimeTo(static::getBaseTomeZone());
			$diff = $dt->diff($returnDateTime);
			if ($diff->invert) {
				$returnDateTime = $dt;
			}
		}
		return $returnDateTime->modify('+1 hour');
	}

	/**
	 * Create result instance
	 *
	 * @param TimeSlot[] $timeSlots
	 * @return FindResult
	 */
	private function createResult(array $timeSlots)
	{
		$this->result = new FindResult($timeSlots, $this->data->getMeeting()->getTimezone());
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
	 * Set loaded data that was be loaded via ISource
	 *
	 * @param Data $data
	 */
	public function setData(Data $data)
	{
		$this->data = $data;
	}

	/**
	 *
	 * @return Result\IResult
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * Find empty time-slots
	 *
	 * @throws \RuntimeException
	 */
	public function find()
	{
		if (empty($this->data)) {
			throw new \RuntimeException('Empty data');
		}

		$interval = $this->getInterval();
		$period = $this->getPeriod($interval);

		// finding
		$foundTimeSlots = array();
		$i = 0;
		foreach ($period as $datetime) {
			$canAttend = array();
			foreach ($this->data->getAttendees() as $attendee) {
				if ($attendee->canAttend($datetime)) {
					$canAttend[] = $attendee;
				}
			}
			if (count($canAttend) == count($this->data->getAttendees())) {
				// we find datetime
				$foundTimeSlots[] = TimeSlot::createFromDatetime($datetime, $interval);
				$i++;
				if ($i >= $this->data->getPossibleTimeSlots()) {
					break;
				}
			}
		}
		$this->createResult($foundTimeSlots);
	}
} 