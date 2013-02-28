<?php
/**
 * ActiveRecord is the customized base active record class.
 * All model classes for this application should extend from this base class.
 **/
abstract class ActiveRecord extends CActiveRecord {

	/**
	 * @var array that contains attributes of the record at the time it was found
	 **/
	private $_oldAttributes = array();

	/** 
	 * @var array attributes that can be exposed to user
	 **/
	public $publicAttributes = array();

	/**
	 * @return array scenario string => label string
	 **/
	public function scenarioLabels() {
		throw new Exception("scenarioLabels() has not been implemented for this class");
	}

	/** 
	 * @return boolean whether the record is not new
	 **/
	public function getIsExistingRecord() {
		return !$this->isNewRecord;
	}

	/**
	 * Returns the text label for the specified scenario.
	 * @param string|null $scenario the scenario name, if null, uses current scenario
	 * @return string the scenario label
	 */
	public function getScenarioLabel($scenario = null)
	{
		if(is_null($scenario)) {
			$scenario = $this->scenario;
		}

		$labels = $this->scenarioLabels();
		if(array_key_exists($scenario, $labels)) {
			return $labels[$scenario];
		}
		return $this->generateAttributeLabel($scenario);
	}


	/**
	 * Saves the initial attributes into oldAttributes
	 * @see CActiveRecord::afterFind
	 */ 
	public function afterFind() {
		parent::afterFind();

		// Save initial attributes for later review
		$this->_oldAttributes = $this->attributes;
	}

	/** 
	 * Delete cache before calling parent function
	 * @override
	 */
	protected function afterSave() {
		$this->deleteCacheByPk($this->id);
		return parent::afterSave();
	}

	/** 
	 * Delete cache before calling parent function
	 * @override
	 */
	public function saveCounters($counters) {
		$this->deleteCacheByPk($this->id);
		return parent::saveCounters($counters);
	}

	/**
	 * @return array of labels
	 **/
	public function getAttributeLabels() {
		return $this->attributeLabels();
	}

 	/**
 	 * Get the old attribute for the current owner
 	**/
 	public function getOldAttributes() {
 		if($this->isNewRecord) {
 			throw new CException("Record is new and has no old values.");
 		}

 		return $this->_oldAttributes;
 	}

	/** 
	 * @return array in form of:
	 *	'attributeName' => 'old' => old value
	 *	                   'new' => new value
	 **/
	public function getChangedAttributesExcept($ignoreAttributes = array()) {
		// new attributes and old attributes
		$currentAttributes = $this->attributes;
		$oldAttributes = $this->oldAttributes;

		$changes = array();

		// compare old and new
		foreach ($currentAttributes as $name => $newValue) {
			// check that if the attribute should be ignored
			$oldValue = empty($oldAttributes) ? '' : $oldAttributes[$name];

			if ($newValue != $oldValue) {
				if(!in_array($name, $ignoreAttributes) 
					&& array_key_exists($name, $oldAttributes)
					&& array_key_exists($name, $currentAttributes)
					)
				{
 					// Hack: Format the datetimes into readable strings
					if ($this->metadata->columns[$name]->dbType == 'datetime') {
						$oldAttributes[$name] = isset($oldAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($oldAttributes[$name])) : '';
						$currentAttributes[$name] = isset($currentAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($currentAttributes[$name])) : '';
					}
					$changes[$name] = array('old'=>$oldAttributes[$name], 'new'=>$currentAttributes[$name]);
				}
			}
		}

		return $changes;
	}

	/** 
	 * @return array in form of:
	 *	'attributeName' => 'old' => old value
	 *	                   'new' => new value
	 **/
	public function getChangedAttributes($attributeNames = array()) {
		$changes = array();

		if($this->isExistingRecord) {

			// compare old and new
			foreach ($this->attributes as $name => $newValue) {

				// check that if the attribute should be ignored
				if(in_array($name, $attributeNames)) {

					// provide an empty default value if not set
					$oldValue = empty($this->oldAttributes) ? '' : $this->oldAttributes[$name];

					if ($newValue != $oldValue) {
						$changes[$name] = array(
							'old'=>$oldValue,
							'new'=>$newValue,
						);
					}
				}
			}
		}

		return $changes;
	}

	public function getPublicChangedAttributes() {
		return $this->getChangedAttributes($this->publicAttributes);
	}

	public function findByPk($pk, $condition='', $params=array()) {
		// FIXME: decomment when ready for caching records
		// if($cachedFind = $this->findInCacheByPk($pk)) {
		// 	return $cachedFind;
		// }
		return parent::findByPk($pk, $condition, $params);
	}

	/** 
	 * Looks for the record in the cache based on the primary key
	 * @return ActiveRecord
	 */
	public function findInCacheByPk($pk) {
		$cacheId = self::getCacheIdByPk($pk);
		return Yii::app()->cache->get($cacheId);
	}

	/**
	 * Unset the record in the cache
	 * @return ActiveRecord
	 **/
	public function deleteCacheByPk($pk) {
		$cacheId = self::getCacheIdByPk($pk);
		return Yii::app()->cache->delete($cacheId);	
	}

	/**
	 * @return string the cache id for the model/primary-key
	 **/
	public static function getCacheIdByPk($pk) {
		return self::generateCacheId(array(
			get_class($this),
			$pk
		));
	}

	/**
	 * @param $params the unique identifiers to 
	 * @return string imploded identifiers
	**/
	public static function generateCacheId($params = array()) {
		return implode('/', $params);
	}
}