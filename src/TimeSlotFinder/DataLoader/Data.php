<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 1:43
 */

namespace TimeSlotFinder\DataLoader;


class Data {

	/**
	 * @var integer
	 */
	private $possibleTimeSlots;

	/**
	 * @var \TimeSlotFinder\Meeting
	 */
	private $meeting;

	/**
	 * @var \TimeSlotFinder\Attendee[]
	 */
	private $attendees;

	/**
	 * @param \TimeSlotFinder\Attendee[] $attendees
	 */
	public function setAttendees($attendees)
	{
		$this->attendees = $attendees;
	}

	/**
	 * @return \TimeSlotFinder\Attendee[]
	 */
	public function getAttendees()
	{
		return $this->attendees;
	}

	/**
	 * @param \TimeSlotFinder\Meeting $meeting
	 */
	public function setMeeting($meeting)
	{
		$this->meeting = $meeting;
	}

	/**
	 * @return \TimeSlotFinder\Meeting
	 */
	public function getMeeting()
	{
		return $this->meeting;
	}

	/**
	 * @param int $possibleTimeSlots
	 */
	public function setPossibleTimeSlots($possibleTimeSlots)
	{
		$this->possibleTimeSlots = $possibleTimeSlots;
	}

	/**
	 * @return int
	 */
	public function getPossibleTimeSlots()
	{
		return $this->possibleTimeSlots;
	}
} 