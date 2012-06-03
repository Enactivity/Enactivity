<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/console.php'),
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
		)
	)
);