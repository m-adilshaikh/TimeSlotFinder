<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 19:23
 */

namespace TimeSlotFinder\DataLoader\Source;

class Fields {

	const MEETING = 'meeting';
	const MEETING_TITLE = 'title';
	const MEETING_DURATION = 'duration';
	const MEETING_DATE = 'date';
	const MEETING_TIMEZONE = 'timezone';

	const POSSIBLE_TIME_SLOTS = 'possibleTimeSlots';

	const ATTENDEES = 'attendees';

	const ATTENDEE_NAME = 'name';
	const ATTENDEE_WORKING_HOURS_FROM = 'workingHoursFrom';
	const ATTENDEE_WORKING_HOURS_TO = 'workingHoursTo';
	const ATTENDEE_TIMEZONE = 'timezone';
	const ATTENDEE_BOOKED = 'booked';
	const ATTENDEE_BOOKED_FROM = 'from';
	const ATTENDEE_BOOKED_TO = 'to';

}