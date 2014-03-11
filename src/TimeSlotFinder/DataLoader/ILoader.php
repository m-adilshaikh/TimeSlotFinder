<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 17:29
 */

namespace TimeSlotFinder\DataLoader;


use TimeSlotFinder\DataLoader\Source\ISource;

interface ILoader {

	/**
	 * The default time zone
	 */
	const DEFAULT_TIME_ZONE = 'UTC';

	/**
	 * The default number of possible time-slots that should be found.
	 */
	const DEFAULT_NUMBER_OF_POSSIBLE_TIME_SLOTS = 5;

	/**
	 * The maximal number of possible time-slots that should be found
	 */
	const MAX_NUMBER_OF_POSSIBLE_TIME_SLOTS = 100;

	/**
	 * Load data from source
	 *
	 * @param ISource $source
	 */
	public function loadInputData(ISource $source);
} 