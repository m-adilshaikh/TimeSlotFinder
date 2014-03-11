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
	 * Constructor
	 * @param \DateTime $dateTimeFrom
	 * @param \DateTime $dateTimeTo
	 */
	public function __construct(\DateTime $dateTimeFrom, \DateTime $dateTimeTo)
	{
		$this->datetimeFrom = $dateTimeFrom;
		$this->datetimeTo = $dateTimeTo;
	}

	/**
	 * Create instance from datetime and interval
	 * @param \DateTime $dateTime
	 * @param \DateInterval $interval
	 * @return TimeSlot
	 */
	public static function createFromDatetime(\DateTime $dateTime, \DateInterval $interval)
	{
		$dateTimeTo = clone $dateTime;
		$dateTimeTo->add($interval);
		$self = new self($dateTime, $dateTimeTo);
		return $self;
	}

	/**
	 * Getter for $datetimeFrom property
	 * @param \DateTimeZone $timeZone
	 * @return \DateTime
	 */
	public function getDatetimeFrom(\DateTimeZone $timeZone = null)
	{
		if ($timeZone !== null) {
			$dateTimeFrom = clone $this->datetimeFrom;
			return $dateTimeFrom->setTimezone($timeZone);
		}
		return $this->datetimeFrom;
	}

	/**
	 * Getter for $datetimeTo property
	 * @param \DateTimeZone $timeZone
	 * @return \DateTime
	 */
	public function getDatetimeTo(\DateTimeZone $timeZone = null)
	{
		if ($timeZone !== null) {
			$datetimeTo = clone $this->datetimeTo;
			return $datetimeTo->setTimezone($timeZone);
		}
		return $this->datetimeTo;
	}

	/**
	 * Check whether the time-slot contains the specified $dateTime
	 * @param \DateTime $dateTime
	 * @return bool
	 */
	public function contains(\DateTime $dateTime)
	{
		return $dateTime->getTimestamp() >= $this->datetimeFrom->getTimestamp() &&
		$dateTime->getTimestamp() <= $this->datetimeTo->getTimestamp();
	}

	public function __toString()
	{
		return sprintf('%s - %s',
			$this->datetimeFrom->format(\DateTime::ISO8601),
			$this->datetimeTo->format(\DateTime::ISO8601)
		);
	}
} 