<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 1:43
 */

namespace TimeSlotFinder\DataLoader;

use TimeSlotFinder\Attendee;
use TimeSlotFinder\Meeting;
use TimeSlotFinder\Finder;
use TimeSlotFinder\TimeSlot;

class Loader {

	/**
	 * Load input data from file in json format
	 * @param string $filePath Path to json document
	 *
	 * @throws \InvalidArgumentException
	 * @throws \RuntimeException
	 *
	 * @return Result
	 */
	public function loadInputData($filePath)
	{
		if (!is_file($filePath)) {
			throw new \InvalidArgumentException("File $filePath not a file");
		}
		if (!is_readable($filePath)) {
			throw new \RuntimeException("File $filePath should be a readable");
		}
		$input = json_decode(file_get_contents($filePath), true);
		if ($input === null) {
			throw new \RuntimeException('Input data is not valid');
		}
		$result = new Result();
		// fetch data
		//
		// fetch possible time-slots that should be found
		if (isset($input['possibleTimeSlots'])) {
			$result->possibleTimeSlots = $input['possibleTimeSlots'];
		}

		// create meeting
		$this->loadMeeting($input['meeting'], $result);

		// load attendees
		if (!isset($input['attendees'])) {
			throw new \RuntimeException('You should specify attendees');
		}
		$this->loadAttendees($input['attendees'], $result);

		return $result;
	}

	private function loadMeeting(array $meetingData, Result $result)
	{
		$meeting = new Meeting();
		foreach (array('title', 'duration', 'date') as $param) {
			if (!isset($meetingData[$param])) {
				throw new \RuntimeException('You should specify meeting ' . $param);
			}
			$meeting->{'set' . ucfirst($param)}($meetingData[$param]);
		}
		$result->meeting = $meeting;
	}

	private function loadAttendees(array $attendees, Result $result)
	{
		foreach ($attendees as $attendee) {
			$tz = isset($attendee['timezone']) ? new \DateTimeZone($attendee['timezone']) : new \DateTimeZone(Finder::DEFAULT_TIME_ZONE);
			$workingHoursFrom = new \DateTime($attendee['workingHoursFrom'], $tz);
			$workingHoursTo = new \DateTime($attendee['workingHoursTo'], $tz);

			$attendeeObject = new Attendee($workingHoursFrom, $workingHoursTo);
			if (isset($attendee['booked'])) {
				foreach ($attendee['booked'] as $booked) {
					$dt1 = new \DateTime($booked['from'], $tz);
					$dt2 = new \DateTime($booked['to'], $tz);
					$attendeeObject->addBookedTimeSlot(new TimeSlot($dt1, $dt2));
				}
			}
			$result->attendees[] = $attendeeObject;
		}
	}
} 