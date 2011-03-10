<?php
/**
* AnalyticsWidget class file
* 
* @author Ajay Sharma
*/
class AnalyticsWidget extends CWidget {

	public $on = false;
	
    public function run() {
    	if($this->on) {
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