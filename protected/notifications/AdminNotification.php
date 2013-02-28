<?php 
class AdminNotification extends Notification {
	
	/** 
	 * @param Comment the comment that was published
	 * @param User author of comment
	 **/
	public static function registered($user) {
		$to = Yii::app()->params['adminEmail'];

		// Subject
		$userName = $user->fullName;
		$subject = "{$userName} registered for " . Yii::app()->name;
		
		// Data
		$data = array(
			'groups'=>$user->groups,
			'user'=>$user,
		);

		Yii::app()->notifier->notifyByEmail($to, $subject, 
			'adminNotification/registered', $data
		);
	}
}