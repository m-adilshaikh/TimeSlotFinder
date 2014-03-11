<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 10.03.14
 * Time: 23:14
 */

namespace TimeSlotFinder;


class Attendee {

	/**
	 * @var string The attendee name
	 */
	private $name;

	/**
	 * @var TimeSlot[] Array of time-slots which attendee has already booked
	 */
	private $bookedTimeSlots = array();

	/**
	 * @var \DateTime
	 */
	private $workingHoursFrom;

	/**
	 * @var |DateTime
	 */
	private $workingHoursTo;

	/**
	 * Constructor
	 * @param \DateTime $workingHoursFrom
	 * @param \DateTime $workingHoursTo
	 */
	public function __construct(\DateTime $workingHoursFrom, \DateTime $workingHoursTo)
	{
		$this->workingHoursFrom = $workingHoursFrom;
		$this->workingHoursTo = $workingHoursTo;
	}

	/**
	 * Check whether the specified datetime has been already booked
	 * @param \DateTime $dateTime
	 * @return bool
	 */
	private function isDatetimeIsBooked(\DateTime $dateTime)
	{
		foreach ($this->bookedTimeSlots as $timeSlot) {
			if ($timeSlot->contains($dateTime)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Setter for $name property
	 * @param $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Getter for $name property
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param TimeSlot $timeSlot
	 */
	public function addBookedTimeSlot(TimeSlot $timeSlot)
	{
		$this->bookedTimeSlots[] = $timeSlot;
	}

	/**
	 * Check whether the attendee can attend to the meeting
	 * @param Meeting $meeting
	 * @param \DateTime $dateTime Datetime in UTC time zone
	 * @return bool TRUE - if yes, FALSE - if no
	 */
	public function canAttend(Meeting $meeting, \DateTime $dateTime)
	{
		$tz = new \DateTimeZone('UTC');

		// convert to UTC working hours
		$workingHoursFrom = $this->workingHoursFrom->setTimezone($tz);
		$workingHoursTo = $this->workingHoursTo->setTimezone($tz);

		if ($dateTime->getTimestamp() >= $workingHoursFrom->getTimestamp()
			&& $dateTime->getTimestamp() <= $workingHoursTo->getTimestamp()) {
			// check whether the datetime is booked
			if (!$this->isDatetimeIsBooked($dateTime)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Getter for $workingHoursFrom property
	 * @return \DateTime
	 */
	public function getWorkingHoursFrom()
	{
		return $this->workingHoursFrom;
	}

	/**
	 * Getter for $workingHoursTo property
	 * @return \DateTime
	 */
	public function getWorkingHoursTo()
	{
		return $this->workingHoursTo;
	}
}