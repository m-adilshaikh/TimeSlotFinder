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
	 * @var TimeSlot Array of time-slots which attendee has already booked
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
	 * @return bool TRUE - if yes, FALSE - if no
	 */
	public function canAttend(Meeting $meeting)
	{

	}
}