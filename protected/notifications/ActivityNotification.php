<?php 
class ActivityNotification extends Notification {
	
	/** 
	 * @param Activity activity that was published
	 * @param User author of activity
	 **/
	public static function publish($activity, $user) {

		// To
		$to = $activity->whoToNotifyByEmail;

		// Subject
		$userName = $user->fullName;
		$label = $activity->getScenarioLabel($activity->scenario);
		$name = $activity->nameForEmails;
		$subject = "{$userName} {$label} {$name}";
		
		// Data
		$data = array(
			'activity'=>$activity, 
			'user'=>$user,
		);

		Yii::app()->notifier->notifyByEmail($to, $subject, 'activityNotification/publish', $data);
		// TODO: Yii::app()->notifier->notifyByFacebookGroup($to, $subject, 'activity/publish', $data);
	}
}