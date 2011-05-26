<?php
/**
* AnalyticsWidget class file
* 
* @author Ajay Sharma
*/
class AnalyticsWidget extends CWidget {

	public $googleAnalyticsOn = false;
	
	public function init() {
		parent::init();
		if(isset(Yii::app()->params['googleAnalyticsOn'])) {
			$this->googleAnalyticsOn = Yii::app()->params['googleAnalyticsOn'];
		}
	}
	
    public function run() {
    	if($this->googleAnalyticsOn) {
    		$script = Yii::getPathOfAlias('ext.analytics.assets')
				. '/google.analytics.js';
    		$publishedScript = Yii::app()->getAssetManager()->publish($script);
	        Yii::app()->clientScript->registerScriptFile(
	        	$publishedScript, 
	        	CClientScript::POS_HEAD
	        );
    	}
    }
}