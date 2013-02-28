<?php 

Yii::import("ext.facebook.components.FacebookGroupPost");

class Notifier extends CApplicationComponent {
	
	public $emailEnabled = true;
	public $facebookGroupEnabled = true;

	public $skipCurrentUser = true;

	/** 
	 * @var string the default email to notifications from
	 **/
	public $defaultFromEmailAddress;

	/** 
	 * @param $to User|string|array of Users|strings to notify
	 * @param $subject string subject of email
	 * @param $view string alias to view path
	 * @param $data data to pass to view for rendering
	 * @param $from string the from email address
	 */
	public function notifyByEmail($to, $subject, $view, $data = array(), $from = null) {

		if(!is_array($to)) {
			$to = array($to);
		}

		if($this->emailEnabled) {

			if(is_object($to[0])) {
				$emails = ArrayUtils::extractProperty($to, 'email');
			}
			else {
				$emails = $to;
			}

			if($this->skipCurrentUser) {
				$emails = ArrayUtils::unsetByValue($emails, Yii::app()->user->model->email);
			}

			$from = $from ? $from : $this->defaultFromEmailAddress;

			return Yii::app()->mailer->batchSend($emails, $subject, $view, $data, $from);
		}
		return sizeof($to);
	}

	/** 
	 * @param $to Group|array of Groups to notify
	 * @param $link string url to link to
	 * @param $name string name of the linked page
	 * @param $message string main content of the facebook post
	 * @param $view string alias to view path
	 * @param $data array of data to pass to view for rendering a description of the link
	 */
	public function notifyByFacebookGroup($to, $link, $name, $message, $view, $data = array()) {
		
		if(!is_array($to)) {
			$to = array($to);
		}

		// TODO: move rendering and for loop into FacebookGroupPost

		$description = Yii::app()->FB->renderView($view, $data, true);

		if($this->facebookGroupEnabled) {

			foreach ($to as $group) {
				$post = new FacebookGroupPost();
				$post->post($group->facebookId, array(
					'link' => $link, 
					'name' => $name, 
					'message' => $message, 
					'description' => $description,
				));
			}
		}
		return sizeof($to);
	}
}