<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/shared.inc.php'),
	array(
		'components'=>array(

			/* Set for server */
			'db'=>array(
				'connectionString' => 'mysql:host=127.0.0.1;dbname=poncla_yii',
				'emulatePrepare' => true,
				'enableProfiling'=>true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'enableParamLogging'=>true,
			),
			
			// MySQL database settings for alpha
			'db-alpha'=>array(
				'connectionString' => 'mysql:host=mysql.alpha.poncla.com;dbname=poncla_alpha',
				'emulatePrepare' => true,
				'username' => 'poncla_alpha',
				'password' => 'alpha123',
				'charset' => 'utf8',
			),
			
			// MySQL database settings for production
			'db-production'=>array(
				'connectionString' => 'mysql:dbname=poncla_live_dont_mess_with_me;host=173.236.204.211',
				'emulatePrepare' => true,
				'username' => 'poncla_live',
				'password' => '1f3870be274f6c4',
				'charset' => 'utf8',
				'enableParamLogging'=>false,
			),
		)
	)
);