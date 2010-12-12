<?php
/**
 * Utilities functions for strings 
 */
class StringUtils {
	
	/**
	 * Create a random string 
	 * @param int string length
	 */
	public static function createRandomString($length) { 
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$password = '';
		
		for($i = 0; $i <= $length; $i++) {
			$index = rand() % 33;
			$tmp = substr($chars, $index, 1);
			$password = $password . $tmp;
		}
		
		return $password;
	} 
}
?>