<?

class ArrayUtils {

	/** 
	 * Pulls out one property of an array of objects
	 * @param array
	 * @param string name of property
	 * @return array
	 */
	public static function extractProperty($array, $propertyName) {

		$properties = array();

		foreach ($array as $key => $object) {
			$properties[] = $object->$propertyName;
		}

		return $properties;
	}

	/** 
	 * @param array
	 * @param mixed value to pop out
	 * @return array
	 **/
	public static function unsetByValue($array, $value) {
		if(($key = array_search($value, $array)) !== false) {
			unset($array[$key]);
		}
		return $array;
	}
}