<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),

			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'enableProfiling'=>true,
				'enableParamLogging'=>true		
			),

			'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// un/comment the following to show/hide log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
		),
		'theme'=>'', //use yii-default
	)
);
