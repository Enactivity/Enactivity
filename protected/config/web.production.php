<?php
// This is the test Web application configuration. Any writable
// CWebApplication properties can be configured here.
// Overrides any settings from main.inc.php
return CMap::mergeArray(
	require(dirname(__FILE__).'/web.php'),
	array(
		'components'=>array(
			
			// MySQL database settings for production
			'db'=>array(
				'connectionString' => 'mysql:dbname=poncla_live_dont_mess_with_me;host=173.236.204.211',
				'emulatePrepare' => true,
				'username' => 'poncla_live',
				'password' => '1f3870be274f6c4',
				'charset' => 'utf8',
				'enableParamLogging'=>false,
			),
			
			'mail'=>array(
				'dryRun'=>true,
			),
			
			'mailer'=>array(
				'shouldEmail'=>false,  
			),
		),
		
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			'adminEmail'=>'ajsharma@poncla.com', // this is used in contact page
			'googleAnalyticsOn'=>true, // should enable google analytics 
		),
	)
);