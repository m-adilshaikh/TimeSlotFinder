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
	 * @var TimeSlot Represents attendee working hours
	 */
	private $workingHours;

	/**
	 * Constructor
	 * @param TimeSlot $workingHours
	 */
	public function __construct(TimeSlot $workingHours)
	{
		$this->workingHours = $workingHours;
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
	 * @param \DateTime $dateTime Datetime in UTC time zone
	 * @return bool TRUE - if yes, FALSE - if no
	 */
	public function canAttend(\DateTime $dateTime)
	{
		$tz = new \DateTimeZone('UTC');

		// convert to UTC working hours
		$workingHoursFrom = $this->workingHours->getDatetimeFrom($tz);
		$workingHoursTo = $this->workingHours->getDatetimeTo($tz);

		if ($dateTime->getTimestamp() >= $workingHoursFrom->getTimestamp()
			&& $dateTime->getTimestamp() <= $workingHoursTo->getTimestamp()
		) {
			// check whether the datetime is booked
			if (!$this->isDatetimeIsBooked($dateTime)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Getter for $workingHours property
	 * @return TimeSlot
	 */
	public function getWorkingHours()
	{
		return $this->workingHours;
	}

}