TimeSlotFinder
==============

Finding empty slot in calendar


Problem:
Arranging a meeting can be very hard task when you have to invite many people. Some of them already have their time-slots booked, others work in a different timezone. That's why we want to automate that process.


Task:
Write a code (in the language of your choice) which finds available time-slots for a meeting that everyone can attend.


Input parameters:
* list of attendees (every attendee can have different working hours and different time-slots already booked)
* meeting length
* (Integer) Number of possible time-slots that should be found by program time-frame


Output:
* list of available time-slots
* information that it's not possible arrange meeting with everyone in the selected time-frame
* BONUS: if it's not possible to find time for all attendees, find a time-slot when maximum number of participants is able to attend and list who is available and who isn't on that time.

How to use:
==
* Download project as archive or clone the repository
* Go to ``./data`` and specify your input data in ``input.json`` file
* Go to ``./src/``
* run ``php -f index.php`` in your terminal
