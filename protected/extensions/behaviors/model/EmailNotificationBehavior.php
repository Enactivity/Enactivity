<?php
/**
 * Class file for EmailNotificationBehavior
 */

Yii::import("application.components.ar.db.EmailableRecord");
Yii::import("application.components.notifications.NotificationBehavior");

/**
 * This is the behavior class for behavior "EmailNotificationBehavior".
 * The EmailNotificationBehavior implements EmailRecord Model
 */
class EmailNotificationBehavior extends NotificationBehavior
{
	public function getEnabled() {
		return Yii::app()->params['ext.behaviors.model.EmailNotificationBehavior.enabled'];
	}

	public function afterSave($event)
	{
		if($this->enabled && $this->isNotifiableScenario && isset(Yii::app()->user)) {
			Yii::app()->notifier->modelUpdated($this->owner, $this->owner->whoToNotifyByEmail());
		}
	}
}