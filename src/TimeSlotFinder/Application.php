<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 17:51
 */

namespace TimeSlotFinder;


use TimeSlotFinder\DataLoader\Loader;

abstract class Application {

	/**
	 * Fabric method for finder instance
	 * @return Finder
	 */
	public static function createFinder()
	{
		return Finder::getInstance();
	}

	/**
	 * Fabric method for loader method
	 * @return Loader
	 */
	public static function createLoader()
	{
		return new Loader();
	}

	/**
	 * Run searching
	 *
	 * @param Finder $finder
	 */
	public static function run(Finder $finder)
	{
		$finder->find();
		$finder->getResult()->display();
	}
}