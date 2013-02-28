<?php 
class CommentNotification extends Notification {
	
	/** 
	 * @param Comment the comment that was published
	 * @param User author of comment
	 **/
	public static function insert($comment, $model, $user) {

		// Subject
		$userName = $user->fullName;
		$name = $model->name;
		$subject = "{$userName} commented on {$name}";
		
		// Data
		$data = array(
			'comment'=>$comment, 
			'model'=>$model,
			'user'=>$user,
		);

		Yii::app()->notifier->notifyByEmail($comment->whoToNotifyByEmail, $subject, 
			'commentNotification/insert', $data
		);
	}
}