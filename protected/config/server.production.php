<?php
// This is the test Web application configuration. Any writable
// CWebApplication properties can be configured here.
// Overrides any settings from main.inc.php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.inc.php'),
	array(
		'components'=>array(
			
			// MySQL database settings for production
			'db'=>array(
				'connectionString' => 'mysql:dbname=poncla_live_dont_mess_with_me;host=173.236.204.211',
				'emulatePrepare' => true,
				'username' => 'poncla_live',
				'password' => '1f3870be274f6c4',
				'charset' => 'utf8',
				'enableParamLogging'=>true
			),
			
			// MySQL database settings for bella
//			'db'=>array(
//				'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
//				'emulatePrepare' => true,
//				'username' => 'root',
//				'password' => 'justr1d3',
//				'charset' => 'utf8',
//				'enableParamLogging'=>false
//			),
	
			// MySQL database settings for alpha
//			'db'=>array(
//				'connectionString' => 'mysql:host=mysql.alpha.poncla.com;dbname=poncla_alpha',
//				'emulatePrepare' => true,
//				'username' => 'poncla_alpha',
//				'password' => 'alpha123',
//				'charset' => 'utf8',
//				'enableParamLogging'=>false
//			),
	
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					// output errors and warning to runtime file
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),
					array(
						'class'=>'CEmailLogRoute',
						'levels'=>'error, warning',
						'emails'=>'support-message-log@poncla.com',
						'enabled'=>true,
						'sentFrom'=>'support-message-log@poncla.com',
					),
				),
			),
			
			'mailer'=>array(
				'shouldEmail'=>true,  
			),
		),
	)
);