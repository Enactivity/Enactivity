<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/console.php'),
	array(
		'components'=>array(

			// MySQL database settings for alpha
			'db'=>array(
				'class'=>'CDbConnection',
				'connectionString' => 'mysql:host=mysql.alpha.poncla.com;dbname=poncla_alpha',
				'username' => 'poncla_alpha',
				'password' => 'alpha123',
			),
		)
	)
);