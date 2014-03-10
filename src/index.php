<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 0:22
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

$inputFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR  . 'data' . DIRECTORY_SEPARATOR . 'input.json';

$finder = \TimeSlotFinder\Finder::getInstance();

try {
	$dataLoader = new \TimeSlotFinder\DataLoader\Loader();
	$finder->find($dataLoader->loadInputData($inputFile));

} catch (\Exception $e) {
	echo "ERROR: " . $e->getMessage() . "\nFILE:" . $e->getFile() . "\nLINE:" . $e->getLine() . "\n=================\n";
}
