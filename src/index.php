<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 0:22
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

// path to file with input data
$inputFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'input.json';

try {
	$finder = \TimeSlotFinder\Application::createFinder();
	$loader = \TimeSlotFinder\Application::createLoader();

	// load input data
	$source = new TimeSlotFinder\DataLoader\Source\JsonFile($inputFile);
	$loader->loadInputData($source);
	$finder->setData($loader->getData());

	// run application
	\TimeSlotFinder\Application::run($finder);

} catch (\Exception $e) {
	echo "ERROR: " . $e->getMessage()
		. "\nFILE:" . $e->getFile()
		. "\nLINE:" . $e->getLine()
		. "\n=================\n";
}