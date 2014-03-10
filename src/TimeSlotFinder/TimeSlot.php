<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 10.03.14
 * Time: 23:24
 */

namespace TimeSlotFinder;


class TimeSlot {

	/**
	 * @var \DateTime DateTime object which represents min point of time-slot
	 */
	private $datetimeFrom;

	/**
	 * @var \DateTime DateTime object which represents max point of time-slot
	 */
	private $datetimeTo;

	/**
	 * Disable creating instance via constructor
	 */
	private function __construct(\DateTime $dateTimeFrom, \DateTime $dateTimeTo)
	{
		$this->datetimeFrom = $dateTimeFrom;
		$this->datetimeTo = $dateTimeTo;
	}

	/**
	 * Creating instance form unix timestamps
	 * @param integer $timestampFrom
	 * @param integer $timestampTo
	 * @return TimeSlot
	 */
	public static function createFromTimestamps($timestampFrom, $timestampTo)
	{
		$self = new self(
			new \DateTime(date('c', $timestampFrom)),
			new \DateTime(date('c', $timestampTo))
		);
		return $self;
	}

	/**
	 * Getter for $datetimeFrom property
	 * @return \DateTime
	 */
	public function getDatetimeFrom()
	{
		return $this->datetimeFrom;
	}

	/**
	 * Getter for $datetimeTo property
	 * @return \DateTime
	 */
	public function getDatetimeTo()
	{
		return $this->datetimeTo;
	}

	public function __toString()
	{
		return sprintf('%s - %s',
			$this->datetimeFrom->format(\DateTime::ISO8601),
			$this->datetimeTo->format(\DateTime::ISO8601)
		);
	}
} 