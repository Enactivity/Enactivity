<?php
return array(

	'webApplicationConfig' => array(

		'components'=>array(

			'clientScript'=>array(
				'minScriptDebug'=>true,
			),

			'db'=>array(
				'enableParamLogging'=>true,
				'enableProfiling' => true,
			),

			'FB'=>array(
				'appID' => '163029810507491',
				'appSecret' => 'e00d0f1d1353df24d6ff3c86cb4766b5',
				'appNamespace' => 'enactivity_test',
	        ),
			
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					// show log messages on web pages
					'CWebLogRoute' => array(
						'class'=>'CWebLogRoute',
						'filter' => array(
							'class' => 'CLogFilter',
							'logUser' => true,
							'prefixSession' => true,
							'prefixUser' => true,
						),
					),
					'CProfileLogRoute' => array(
	                    'class'=>'CProfileLogRoute',
	                    'report'=>'summary',
	                ),
				),
			),

			'mailer' => array(
				'overrideLocal' => 'eng',
				'overrideDomain' => 'poncla.com',
			),

			'notifier' => array(
				'skipCurrentUser' => false,
			),
		
			// 'urlManager'=>array(
			// 	'rules'=>null, //to allow gii
			// ),
		),
		
		'modules'=>array(
			// uncomment the following to enable the Gii tool
			// custom url manager must also be disabled
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'notsochewy',
				// 'ipFilters'=>false,
			),
		),

		'params'=>array(
			'googleAnalyticsOn'=>false,

			'ext.behaviors.model.EmailNotificationBehavior.notifyCurrentUser' => true,
		),
	),

	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => true,
	'yiiTraceLevel' => 3,
);