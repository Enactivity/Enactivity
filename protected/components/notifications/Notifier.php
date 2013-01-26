<?php 
class Notifier extends CApplicationComponent {
	
	public $emailEnabled = true;
	public $facebookGroupEnabled = true;

	public $notifyCurrentUser = false;

	/** 
	 * @var string the default email to notifications from
	 **/
	public $defaultFromEmailAddress;

	/** 
	 * @param $to User|array of Users to notify
	 * @param $subject string subject of email
	 * @param $view string alias to view path
	 * @param $data data to pass to view for rendering
	 * @param $from string the from email address
	 */
	protected function notifyByEmail($to, $subject = null, $view = null, $data = array(), $from = null) {

		if(!is_array($to)) {
			$to = array($to);
		}

		// TODO: filter for current user if requested? (maybe here)

		if($this->emailEnabled) {

			$emails = ArrayUtils::extractProperty($to, 'email');
			$from = $from ? $from : $this->defaultFromEmailAddress;

			return Yii::app()->mailer->batchSend($emails, $subject, $view, $data, $from);
		}
		return sizeof($to);
	}

	// TODO: implement (params just guesses)
	protected function notifyByFacebookGroup($to, $subject, $view, $data) {
		
	}

	// Possible alternative to every object having it's own modelScenario function
	public function modelUpdated($model, $to) {

		// Subject
		$userName = Yii::app()->user->model->fullName;
		$label = $model->getScenarioLabel($model->scenario);
		$name = $model->emailName;
		$subject = "{$userName} {$label} {$name}";

		// view
		$view = strtolower(get_class($model)). '/' . $model->scenario;
		
		// $data
		$data = array(
			'data'=>$model, 
			'changedAttributes'=>$model->publicChangedAttributes,
			'user'=>Yii::app()->user->model
		);

		// Can notify by multiple methods (facebook, facebookGroupPost, etc.)
		$this->notifyByEmail($to, $subject, $view, $data);
	}

	/** 
	 * Probably don't use this
	 *
	 **/
	public static function taskPublished($task, $to) {
		// Construct email params
		$subject = "Task name blah";
		$view = "task/publish";
		$data = array(
			'data' => $task
		);

		// Can notify by multiple methods (facebook, facebookGroupPost, etc.)
		$this->notifyByEmail($to, $subject, $view, $data);
	}
}