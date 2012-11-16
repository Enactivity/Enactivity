<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/console.php'),
	array(
		'components'=>array(

			/* Set for server */
			'db'=>array(
				'connectionString' => 'mysql:host=mysql.alpha.poncla.com;dbname=poncla_alpha',
				'emulatePrepare' => true,
				'enableProfiling'=>true,
				'username' => 'poncla_alpha',
				'password' => 'alpha123',
				'charset' => 'utf8',
				'enableParamLogging'=>true,
			),
		)
	)
);