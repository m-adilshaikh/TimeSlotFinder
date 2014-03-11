<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 10.03.14
 * Time: 21:52
 */

namespace TimeSlotFinder;


class Meeting {

	/**
	 * The minimal duration of meeting in minutes
	 */
	const MIN_DURATION = 30;

	/**
	 * The maximal duration of meeting in minutes
	 */
	const MAX_DURATION = 240;

	/**
	 * @var integer Meeting duration in minutes
	 */
	private $duration;

	/**
	 * @var string The meeting's title
	 */
	private $title;

	/**
	 * @var string The date in format Y-m-d when the meeting will be held
	 */
	private $date;

	/**
	 * @var |DateTimeZone The time zone of meeting event
	 */
	private $timezone;

	/**
	 * Setter for $duration property
	 * @param integer $duration
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setDuration($duration)
	{
		$duration = (int)$duration;
		if ($duration < self::MIN_DURATION || $duration > self::MAX_DURATION) {
			throw new \InvalidArgumentException(sprintf('Duration of meeting must be %d-%d minutes', self::MIN_DURATION, self::MAX_DURATION));
		}
		$this->duration = $duration;
	}

	/**
	 * Getter for $duration property
	 * @return int
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * Setter for $title property
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * Getter for $title property
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Setter for $date property
	 * @param string $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * Getter for $date property
	 * @return string
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Setter for $timezone property
	 * @param \DateTimeZone $timeZone
	 */
	public function setTimezone(\DateTimeZone $timeZone)
	{
		$this->timezone = $timeZone;
	}

	/**
	 * Getter for $timezone property
	 * @return \DateTimeZone
	 */
	public function getTimezone()
	{
		return $this->timezone;
	}

} 