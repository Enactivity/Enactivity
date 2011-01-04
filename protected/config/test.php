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
			
			'urlManager'=>array(
				'showScriptName'=>true,
			)
		),
		
		//'theme'=>'', //use yii-default
	)
);
