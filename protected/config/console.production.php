<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/console.php'),
	array(
		'components'=>array(

			// MySQL database settings for production
			'db'=>array(
				'class'=>'CDbConnection',
				'connectionString' => 'mysql:dbname=enactivity_production;host=173.236.204.211',
				'emulatePrepare' => true,
				'username' => 'poncla_live',
				'password' => '1f3870be274f6c4',
				'charset' => 'utf8',
				'enableParamLogging'=>false,
			),
		)
	)
);