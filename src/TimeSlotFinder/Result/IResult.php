<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 18:50
 */

namespace TimeSlotFinder\Result;


interface IResult {

	const DISPLAY_FORMAT = \DateTime::RFC850;

	/**
	 * @return bool
	 */
	public function isEmpty();

	/**
	 * Display results
	 * @return void
	 */
	public function display();
} 