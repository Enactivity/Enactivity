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
				'overrideLocal' => 'dev',
				'overrideDomain' => $_SERVER['SERVER_NAME'],
			),

			'metrics' => array(
				'reportingEnabled' => false,
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