<?php 
class ResponseNotification extends Notification {
	
	/** 
	 * @param Comment the comment that was published
	 * @param User author of comment
	 **/
	public static function start($response, $task, $user) {

		// To
		$participants = $task->participants;

		// Subject
		$userName = $user->fullName;
		$name = $task->name;
		$subject = "{$userName} started work on {$name}";
		
		// Data
		$data = array(
			'response'=>$response,
			'task'=>$task,
			'user'=>$user,
		);

		Yii::app()->notifier->notifyByEmail($participants, $subject, 
			'responseNotification/start', $data
		);
	}
}