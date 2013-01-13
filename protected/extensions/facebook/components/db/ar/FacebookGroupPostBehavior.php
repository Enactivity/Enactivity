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
	 * List of scenarios that should be treated as a record change
	 * format: 
	 * array(
	 *    'scenario1' => array()
	 *    'scenario2' => array('attribute1', 'attribute2', ...)
	 *    'scenario3' => array('attribute3', 'attribute4', ...)
	 *    ...
	 * )
	 * @var array
	 **/
	public $scenarios = array();

	/** 
	 * @var boolean should a record be made when the owner is deleted?
	 **/
	public $shouldLogDeletions = false;

 
	/**
	* After the model saves, record the attributes
	* @param CEvent $event
	*/
	public function beforeSave($event)
	{
		// is new record?
		if ($this->isIndivisibleScenario || $this->isDivisibleScenario) {
			$this->recordChanges(); //same handler for both case for now
		}

	}

	public function recordChanges() {
		if(isset(Yii::app()->user) && StringUtils::isNotBlank($this->owner->group)) {
			$scenarioLabel = $this->owner->getScenarioLabel($this->owner->scenario);
			$name = $this->owner->facebookGroupPostName;
			$message = ucfirst($scenarioLabel . " " . "\"" . $name . "\"");
						
			$viewPath = 'ext.facebook.views.groupfeedpost.' 
				. strtolower(get_class($this->owner)) 
				. '.' . $this->owner->scenario;

			$description = $this->renderView($viewPath, array(
				'data'=>$this->owner, 
				'changedAttributes'=>$this->owner->getChangedAttributes($this->scenarioAttributes),
				'user'=>Yii::app()->user->model,
			));
			
			$post = new FacebookGroupPost();
			$post->post($this->owner->group->facebookId, array(
				'link' => $this->owner->viewURL, 
				'name' => $name, 
				'message' => $message, 
				'description' => $description,
			));
			$this->owner->facebookId = $post->id;
		}
	}
	
	/**
	 * Record the deletion
	 * @param CEvent $event
	 */
	public function afterDelete($event) {
		if($this->shouldLogDeletions) {
			$this->recordDeletion();
		}
	}

	public function recordDeletion() {
		if(isset(Yii::app()->user))
		{
			$currentUser = Yii::app()->user->model;
			$name = $this->owner->facebookGroupPostName;
			$time = PHtml::encode(Yii::app()->format->formatDateTime(time())); 
			$message = ucfirst($time) . " something was deleted off " . Yii::app()->name .  ".";
			$groupFacebookId = $this->owner->group->facebookId;
			$description = $this->renderView($viewPath);

			$post = new FacebookGroupPost();
			$post->post($groupFacebookId, array(
				'link' => $this->owner->viewURL, 
				'name' => $name, 
				'message' => $message, 
				'description' => $description,
			));
		}
	}

	protected function renderView($viewPath, $viewData = array()) {
        return Yii::app()->controller->renderPartial($viewPath, $viewData, true);
    }

    /**
	 * @return boolean if the owner's save should be treated as single insert/change
	 **/
	protected function getIsIndivisibleScenario() {
		return array_key_exists($this->Owner->scenario, $this->scenarios)
			&& empty($this->scenarioAttributes);
	} 

	/**
	 * @return boolean if the owner's save should be treated as a change of multiple parts
	 **/
	protected function getIsDivisibleScenario() {
		return array_key_exists($this->Owner->scenario, $this->scenarios)
			&& !empty($this->scenarioAttributes);
	}

	/**
	 * @return array of attributes to record changes to for owner's current scenario
	**/
	protected function getScenarioAttributes() {
		return $this->scenarios[$this->Owner->scenario];
	}
}