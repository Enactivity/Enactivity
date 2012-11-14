<?php
/**
 * Class file for FacebookNotificationBehavior
 */

Yii::import("ext.facebook.components.FacebookGroupPost");

/**
 * This is the behavior class for behavior "FacebookNotificationBehavior".
 */
class FacebookGroupPostBehavior extends CActiveRecordBehavior
{

	/**
	 * List of attributes that should be ignored by the log
	 * when the ActiveRecord is updated.
	 * @var array
	 */
	public $ignoreAttributes = array();
 
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
			$newAttributes = $this->Owner->attributes;
			$oldAttributes = $this->Owner->oldAttributes;
 
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
			$name = $this->Owner->facebookFeedableName;
			$message = ucfirst($label . " " . "\"" . $name . "\"");
			$groupFacebookId = $this->Owner->group->facebookId;
			$descriptionData = array('data'=>$this->Owner, 'changedAttributes'=>$changes ,'user'=>$currentUser);
			$viewPath = 'ext.facebook.views.' . 'facebookGroupPost' . '.' . strtolower(get_class($this->Owner)). '.' . $this->Owner->scenario;
			
			$post = new FacebookGroupPost();
			$post->post($groupFacebookId, $this->Owner->viewURL, $name, $message, $viewPath, $descriptionData);
		}
	}
	
	public function afterDelete($event) {
		if(isset(Yii::app()->user))
		{
			// store the changes 
			$currentUser = Yii::app()->user->model;
			$name = $this->Owner->facebookFeedableName;
			$time = PHtml::encode(Yii::app()->format->formatDateTime(time())); 
			$message = ucfirst($time) . " something was deleted off " . Yii::app()->name .  ".";
			$groupFacebookId = $this->Owner->group->facebookId;

			$feedPost = new FacebookGroupPost();
			$feedPost->post($groupFacebookId, $this->Owner->viewURL, $name, $message, $viewPath);
		}
	}
}
