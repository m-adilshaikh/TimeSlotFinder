<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 1:43
 */

namespace TimeSlotFinder\DataLoader;


class Result {

	/**
	 * @var integer
	 */
	public $possibleTimeSlots;

	/**
	 * @var \TimeSlotFinder\Meeting
	 */
	public $meeting;

	/**
	 * @var \TimeSlotFinder\Attendee[]
	 */
	public $attendees;
} 