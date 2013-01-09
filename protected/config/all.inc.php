<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is some common Web application configurations. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Enactivity',

	// preloading 'log' component
	'preload'=>array(
		'log',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.extensions.*',
		'application.services.*',
	),

	// application components
	'components'=>array(
	
		'authManager'=>array(
            'class' => 'CPhpAuthManager',
        ),

        'cache'=>array(
        	'class'=>'CMemCache',
        	'useMemcached'=>true,
        ),

        'FB'=>array(
        	'class'=>'ext.facebook.FB',
			'appID' => '284699434983364',
			'appSecret' => '53924a0540f0e41b7ea4befcfc09a1b9',
			'appNamespace' => 'enactivity',
			'isFileUploadEnabled' => false,
			'scope' => array(
				'email',
				'publish_stream',
				'user_groups',
			),
        ),
        
		'mail' => array(
				'class' => 'ext.YiiMail',
				'transportType' => 'php',
				'viewPath' => 'application.views.mail',
				'logging' => false,
				'dryRun' => false,
		),
	
		'mailer'=>array(
        		'class'=>'application.extensions.mailer.Mailer',
        		'mailTransferAgent'=>'php',
				'shouldEmail'=>false,  
		),
	),

	'params'=>array(
		//flag to control whether or not email notification emails should be sent
		'emailNotificationsOn'=>false,
		'feedbackEmail' => 'team@poncla.com',
	),
);
