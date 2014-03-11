<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 18:54
 */

namespace TimeSlotFinder\Result;


use TimeSlotFinder\TimeSlot;

class Embedded implements IResult {

	/**
	 * @var TimeSlot[]
	 */
	private $timeSlots;

	/**
	 * @var \DateTimeZone
	 */
	private $timezone;


	/**
	 * @return bool
	 */
	public function isEmpty()
	{
		return $this->timeSlots === array();
	}

	/**
	 * Display results
	 * @return void
	 */
	public function display()
	{
		if ($this->isEmpty()) {
			echo "It's not possible arrange meeting with everyone in the selected date\n";
			die;
		}
		echo "\nEmpty time-slots:\n";
		foreach ($this->timeSlots as $k => $slot) {
			$line = sprintf("%d. %s - %s\n",
				$k + 1,
				$slot->getDatetimeFrom($this->timezone)->format(self::DISPLAY_FORMAT),
				$slot->getDatetimeTo($this->timezone)->format(self::DISPLAY_FORMAT)
			);
			echo $line;
		}

	}

	/**
	 * @param TimeSlot[] $timeSlots Array of found time-slots
	 * @param \DateTimeZone $timeZone In that result should be display
	 */
	public function __construct(array $timeSlots, \DateTimeZone $timeZone)
	{
		$this->timeSlots = $timeSlots;
		$this->timezone = $timeZone;
	}
} 