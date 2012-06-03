<?php

require_once 'TestConstants.php';

class EnvironmentTest extends TestCase
{

	/**
	 * Test memory size limit is high enough
	 */
	public function testMemoryLimit() {
		// get limit
		$memoryLimit = ini_get('memory_limit');
		
		if($memoryLimit == '-1') {
			return; // no memory limit
		}

		$this->assertNotNull($memoryLimit, "memory_limit is not set");

		// convert limit to #bytes
		$memoryLimit = trim($memoryLimit);
		$lastLetter = strtolower($memoryLimit[strlen($memoryLimit)-1]);
		switch($lastLetter) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$memoryLimit *= 1024;
			case 'm':
				$memoryLimit *= 1024;
			case 'k':
				$memoryLimit *= 1024;
		}

		$this->assertGreaterThanOrEqual(67108864, $memoryLimit, 'PHP memory limit is less than 64 megabytes');
	}

	/**
	 * Test register globals is off
	 */
	public function testRegisterGlobals() {
		// get limit
		$registerGlobals = (bool) ini_get('register_globals');

		$this->assertNotNull($registerGlobals, 'register_globals is not set');
		$this->assertFalse($registerGlobals, 'register_globals is enabled, change system settings to fix');
	}

}