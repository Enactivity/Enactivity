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

        'FB'=>array(
        	'class'=>'ext.FB',
			'appID' => '292638224164928',
			'appSecret' => '0bd60d2a765da09c12bc2d1b37aa20c5',
			'appNamespace' => 'ponclainc',
			'isFileUploadEnabled' => false,
			'scope' => array(
				'email',
				'publish_stream',
				'user_groups',
			),
        ),

        'FacebookGroupFeedPost'=>array(
        	'class'=>'application.components.db.ar.FacebookGroupFeedPost',
        ),
        
		'mail' => array(
				'class' => 'ext.YiiMail',
				'transportType' => 'php',
				'viewPath' => 'application.views.mail',
				'logging' => false,
				'dryRun' => true,
		),
	
		'mailer'=>array(
        		'class'=>'application.extensions.mailer.Mailer',
        		'mailTransferAgent'=>'php',
				'shouldEmail'=>false,  
		),
	),
);
