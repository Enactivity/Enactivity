<?php

require_once(Yii::getPathOfAlias('ext.metrics.kissmetrics') . '/KM.php');

class Metrics extends CApplicationComponent {

	public $enabled = true;

	public $key;

	public $log_dir = "/tmp";
	public $use_cron = false;
	public $to_stderr = true;

	public function init()
	{	
		if($this->enabled) {
			return KM::init($this->key, array(
				'log_dir' => $this->log_dir,
				'use_cron' => $this->use_cron,
				'to_stderr' => $this->to_stderr,
			));
		}
	}

	public function identify($id) {
		if($this->enabled) {
			return KM::identify($id);
		}
	}

	/** 
	 * Record an event
	 * @param string $action
	 * @param array props
	 * @param int|string userId
	 **/
	public function record($action, $props = array(), $userId = null) {
		if($this->enabled) {

			if($userId) {
				self::identify($userId);
			}
			elseif(Yii::app()->user->isAuthenticated) {
				self::identify(Yii::app()->user->id);
			}
		
			return KM::record($action, $props);
		}
	}

	/**
	 * Helper function to record model/scenario
	 * @param CModel
	 * @see record()
	 **/
	public function recordScenario($model, $props = array(), $userId = null) {
		$action = strtolower(get_class($model) . '/' . $model->scenario);
		return $this->record($action, $props, $userId);
	}

	private function events() {
		// KM::record('activated');
		// KM::record('Signed In');
		// KM::record('ad campaign hit', array('campaign source' => 'Campaign Source is the campaign source for any advertising you have directing traffic to your site. KISSmetrics automatically tracks this property for you for all Google Ads if you have our Javascript on your site.', 'campaign terms' => 'Campaign Terms describes the campaign terms from your external ad campaigns.', 'campaign medium' => 'Campaign Medium describes the campaign medium from your external ad campaigns.', 'campaign content' => ' describes the campaign terms from your external ad campaigns.', 'campaign name' => 'Campaign Name describes the campaign medium from your external ad campaigns.'));
		// KM::record('added friend');
		// KM::record('billed', array('Billing Amount' => 'Revenue is the price for a subscription, service, or product. This is one of the most critical properties you should track with KISSmetrics.'));
		// KM::record('canceled', array('reason' => 'Reason describes the reason a user canceled'));
		// KM::record('commented', array('content type' => 'Content Type describes the type of content a user posted (photo, video, etc)'));
		// KM::record('downgraded', array('plan level' => 'Plan Level describes the plan level the user signed up under.'));
		// KM::record('posted content', array('content type' => 'Content Type describes the type of content a user posted (photo, video, etc)'));
		// KM::record('search engine hit', array('search terms' => 'Search Terms is what a person typed into a search engine before clicking a result that landed them on your site. KISSmetrics automatically tracks this property for you for all major search engines if you have our Javascript on your site.'));
		// KM::record('shared', array('outbound destination' => 'Outbound Destination describes the outbound destination (such as 'Twitter') that a user used to share about your app.', 'outbound name' => 'Outbound Name describes the mechanism used (such as 'Tweet results link') that a user used to share about your app.', 'outbound medium' => 'Outbound Medium describes the outbound medium (such as 'social') that a user used to share about your app.');
		// KM::record('signed up', array('plan level' => 'Plan Level describes the plan level the user signed up under.'));
		// KM::record('social hit', array('campaign source' => 'Campaign Source is the campaign source for any advertising you have directing traffic to your site. KISSmetrics automatically tracks this property for you for all Google Ads if you have our Javascript on your site.', 'campaign medium' => 'Campaign Medium describes the campaign medium from your external ad campaigns.', 'campaign name' => 'Campaign Name describes the campaign medium from your external ad campaigns.'));
		// KM::record('subscribed to newsletter', array('newsletter name' => 'Newsletter Name describes the name of your newsletter.'));
		// KM::record('upgraded', array('plan level' => 'Plan Level describes the plan level the user signed up under.'));
		// KM::record('viewed someone else\'s profile');
		// KM::record('viewed signup form');
		// KM::record('visited site');
	}
}