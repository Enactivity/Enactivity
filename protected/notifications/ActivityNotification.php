<?php 
class ActivityNotification extends Notification {
	
	/** 
	 * @param Activity activity that was published
	 * @param User author of activity
	 **/
	public static function publish($activity, $user) {

		// Subject
		$userName = $user->fullName;
		$label = $activity->getScenarioLabel($activity->scenario);
		$name = $activity->name;
		$subject = "{$userName} {$label} {$name}";
		
		// Data
		$data = array(
			'activity'=>$activity, 
			'user'=>$user,
		);

		Yii::app()->notifier->notifyByEmail($activity->whoToNotifyByEmail, $subject, 
			'activityNotification/publish', $data
		);
		Yii::app()->notifier->notifyByFacebookGroup($activity->group, 
			$activity->viewUrl, $name, $subject, 
			'activityNotification/publish', $data
		);
	}
}