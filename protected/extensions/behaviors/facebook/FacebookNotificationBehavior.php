<?php
/**
 * Class file for FacebookNotificationBehavior
 */

/**
 * This is the behavior class for behavior "FacebookNotificationBehavior".
 */
class FacebookNotificationBehavior extends CActiveRecordBehavior
{

	/**
	 * List of attributes that should be ignored by the log
	 * when the ActiveRecord is updated.
	 * @var array
	 */
	public $ignoreAttributes = array();
	
	private $_oldAttributes = array();
 
	/**
	* After the model saves, record the attributes
	* @param CEvent $event
	*/

	public function afterSave($event)
	{
		if(isset(Yii::app()->user))
		{
			// store the changes 
			$changes = array();
			
			// new attributes and old attributes
			$newAttributes = $this->Owner->getAttributes();
			$oldAttributes = $this->Owner->getOldAttributes();
 
			// compare old and new
			foreach ($newAttributes as $name => $value) {
				// check that if the attribute should be ignored in the log
				$oldValue = empty($oldAttributes) ? '' : $oldAttributes[$name];

	 			if ($value != $oldValue) {
	 				if(!in_array($name, $this->ignoreAttributes) 
	 					&& array_key_exists($name, $oldAttributes)
	 					&& array_key_exists($name, $newAttributes)
	 				)
	 				{
	 					// Hack: Format the datetimes into readable strings
	 					if ($this->Owner->metadata->columns[$name]->dbType == 'datetime') {
							$oldAttributes[$name] = isset($oldAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($oldAttributes[$name])) : '';
							$newAttributes[$name] = isset($newAttributes[$name]) ? Yii::app()->format->formatDateTime(strtotime($newAttributes[$name])) : '';
						}

	 					$changes[$name] = array('old'=>$oldAttributes[$name], 'new'=>$newAttributes[$name]);
	 				}
				}
			}
			$currentUser = Yii::app()->user->model;
			$label = $this->Owner->getScenarioLabel($this->Owner->scenario);
			$name = $this->Owner->emailName;
			$message = ucfirst($label . " " . "\"" . $name . "\"");
			$link = 
			$groupFacebookId = $this->Owner->group->facebookId;
			Yii::app()->FB->addGroupPost($groupFacebookId, array(
				'message' => $message,
				'link' => PHtml::link(PHtml::encode($this->Owner->name), PHtml::taskURL($this->Owner)),
				));
		}
	}
	
	public function afterDelete($event) {
		if(isset(Yii::app()->user))
		{
			// store the changes 
			$currentUser = Yii::app()->user->model;
			$name = $this->Owner->emailName;
			$time = PHtml::encode(Yii::app()->format->formatDateTime(time())); 
			$message = ucfirst($time) . " something was deleted off Poncla.";
			$link = 
			$groupFacebookId = $this->Owner->group->facebookId;
			Yii::app()->FB->addGroupPost($groupFacebookId, array(
				'message' => $message,
				'link' => PHtml::link(PHtml::encode($this->Owner->name), PHtml::taskURL($this->Owner)),
				));
		}
	}
	
	public function afterFind($event) {
		// Save old values
		$this->setOldAttributes($this->Owner->getAttributes());
	}
 
 	/**
 	 * Get the old attribute for the current owner
 	**/
	public function getOldAttributes() {
		return $this->_oldAttributes;
	}
 
	public function setOldAttributes($value) {
		$this->_oldAttributes = $value;
	}

}
