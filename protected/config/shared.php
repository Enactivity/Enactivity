<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is some common Web application configurations. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Poncla',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
	),

	// application components
	'components'=>array(
	
		'authManager'=>array(
            'class' => 'CPhpAuthManager',
        ),
	
		// MySQL database settings
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'enableParamLogging'=>false
		),
		
		// MySQL database settings for Macs
//		'db'=>array(
//			'connectionString' => 'mysql:host=127.0.0.1;dbname=poncla_yii',
//			'emulatePrepare' => true,
//			'username' => 'root',
//			'password' => '',
//			'charset' => 'utf8',
//			'enableParamLogging'=>false
//		),
		
		// MySQL database settings for alpha
//		'db'=>array(
//			'connectionString' => 'mysql:host=mysql.alpha.poncla.com;dbname=poncla_alpha',
//			'emulatePrepare' => true,
//			'username' => 'poncla_alpha',
//			'password' => 'alpha123',
//			'charset' => 'utf8',
//			'enableParamLogging'=>false
//		),

		// MySQL database settings for production
//		'db'=>array(
//			'connectionString' => 'mysql:dbname=poncla_live_dont_mess_with_me;host=173.236.204.211',
//			'emulatePrepare' => true,
//			'username' => 'poncla_live',
//			'password' => '1f3870be274f6c4',
//			'charset' => 'utf8',
//			'enableParamLogging'=>true
//		),
		
	),
);
