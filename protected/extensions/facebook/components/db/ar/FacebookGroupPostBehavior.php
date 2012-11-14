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
	 * List of scenarios on which the post should be made
	 * @var array
	 */
	public $scenarios = array();
 
	/**
	* After the model saves, record the attributes
	* @param CEvent $event
	*/

	public function afterSave($event)
	{
		if(in_array($this->Owner->scenario, $this->scenarios)) {

			if(isset(Yii::app()->user))
			{
				// store the changes 
				$changes = array();
				
				// calculate changes
				if (!$this->Owner->isNewRecord) {
					$changes = $this->Owner->getChangedAttributesExcept($this->ignoreAttributes);
				}

				$currentUser = Yii::app()->user->model;

				$groupFacebookId = $this->Owner->group->facebookId;

				$label = $this->Owner->getScenarioLabel($this->Owner->scenario);
				$name = $this->Owner->facebookGroupPostName;
				$message = ucfirst($label . " " . "\"" . $name . "\"");
							
				$viewPath = 'ext.facebook.views.facebookGroupPost.' 
					. strtolower(get_class($this->Owner)) 
					. '.' . $this->Owner->scenario;

				$viewData = array(
					'data'=>$this->Owner, 
					'changedAttributes'=>$changes,
					'user'=>$currentUser
				);
				
				$post = new FacebookGroupPost();
				$post->post($groupFacebookId, $this->Owner->viewURL, $name, $message, $viewPath, $viewData);
			}
		}
	}
	
	public function afterDelete($event) {
		if(isset(Yii::app()->user))
		{
			$currentUser = Yii::app()->user->model;
			$name = $this->Owner->facebookGroupPostName;
			$time = PHtml::encode(Yii::app()->format->formatDateTime(time())); 
			$message = ucfirst($time) . " something was deleted off " . Yii::app()->name .  ".";
			$groupFacebookId = $this->Owner->group->facebookId;

			$feedPost = new FacebookGroupPost();
			$feedPost->post($groupFacebookId, $this->Owner->viewURL, $name, $message, $viewPath);
		}
	}
}
