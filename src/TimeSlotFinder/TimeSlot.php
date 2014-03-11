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
			$this->datetimeFrom->format(\DateTime::RFC2822),
			$this->datetimeTo->format(\DateTime::RFC2822)
		);
	}
} 