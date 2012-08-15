<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
defined('YII_DEBUG') or define('YII_DEBUG', false); // otherwise is set to true in framework

return CMap::mergeArray(
	require(dirname(__FILE__).'/all.inc.php'),
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