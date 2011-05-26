<?php
// This is the test Web application configuration. Any writable
// CWebApplication properties can be configured here.
// Overrides any settings from main.inc.php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.inc.php'),
	array(
		'components'=>array(
			
			// MySQL database settings for bella
			'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'justr1d3',
			'charset' => 'utf8',
			'enableParamLogging'=>false
			),
		),
	)
);