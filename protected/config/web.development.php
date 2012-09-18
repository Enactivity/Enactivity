<?php

// debug mode on
defined('YII_DEBUG') or define('YII_DEBUG', true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// This is the test Web application configuration. Any writable
// CWebApplication properties can be configured here.
// Overrides any settings from main.inc.php
return CMap::mergeArray(
	require(dirname(__FILE__).'/web.php'),
	array(
		'components'=>array(
	
			'db'=>array(
				'connectionString' => 'mysql:host=127.0.0.1;dbname=poncla_yii',
				'emulatePrepare' => true,
				'enableProfiling'=>true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'enableParamLogging'=>true,
			),

			'FB'=>array(
				'appID' => '454101737963215',
				'appSecret' => '30fa98515c5f35ddc2f9176920dca10c',
				'appNamespace' => 'ponclatest',
	        ),
			
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					// output errors and warning to runtime file
					array(
						'class'=>'CFileLogRoute',
						'filter' => array(
							'class' => 'CLogFilter',
							'logUser' => true,
							'prefixSession' => true,
							'prefixUser' => true,
						),
						'levels'=>'error, warning',
					),
					// show log messages on web pages
					array(
						'class'=>'CWebLogRoute',
						'filter' => array(
							'class' => 'CLogFilter',
							'logUser' => true,
							'prefixSession' => true,
							'prefixUser' => true,
						),
					),
				),
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
			),
		),
	)
);