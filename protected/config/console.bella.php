<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/console.php'),
	array(
		'components'=>array(

			// MySQL database settings for bella
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
				'username' => 'root',
				'password' => 'justr1d3',
			),
		)
	)
);