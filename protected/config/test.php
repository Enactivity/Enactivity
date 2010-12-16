<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),

			'db'=>array(
				'enableProfiling'=>true,
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
		
		'modules'=>array(
		// uncomment the following to enable the Gii tool
		
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'123456',
			),
			
		),
		
		//'theme'=>'', //use yii-default
	)
);
