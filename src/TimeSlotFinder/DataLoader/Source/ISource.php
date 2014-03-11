<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 16:14
 */

namespace TimeSlotFinder\DataLoader\Source;


interface ISource {

	/**
	 * @return array Return data as assoc array
	 */
	public function getData();
} 