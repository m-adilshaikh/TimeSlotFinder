<?php
/**
 * Created by PhpStorm.
 * User: namreg
 * Date: 11.03.14
 * Time: 16:27
 */

namespace TimeSlotFinder\DataLoader\Source;


class JsonFile implements ISource {

	/**
	 * @var string File path to json document
	 */
	private $filePath;

	/**
	 * @var array Store data that will be loaded from source
	 */
	private $loadedData;

	/**
	 * Load input data from file in json format
	 * @param string $filePath Path to json document
	 *
	 * @throws \InvalidArgumentException
	 * @throws \RuntimeException
	 *
	 */
	public function __construct($filePath)
	{
		if (!is_file($filePath)) {
			throw new \InvalidArgumentException("File $filePath not a file");
		}
		if (!is_readable($filePath)) {
			throw new \RuntimeException("File $filePath should be a readable");
		}
		$this->filePath = $filePath;
	}

	/**
	 * @return array Return data as assoc array
	 * @throws \RuntimeException
	 */
	public function getData()
	{
		if ($this->loadedData !== null) {
			return $this->loadedData;
		}
		$input = json_decode(file_get_contents($this->filePath), true);
		if ($input === null) {
			throw new \RuntimeException('Input data is not valid');
		}
		$this->loadedData = $input;
		return $this->loadedData;
	}

}