<?php
// This is the test Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/web.php'),
	array(
		'components'=>array(
			
			// MySQL database settings for bella
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
				'username' => 'root',
				'password' => 'justr1d3',
			),
		),
	)
);