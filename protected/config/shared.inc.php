<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is some common Web application configurations. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Poncla',

	// preloading 'log' component
	'preload'=>array('log', 'timezonekeeper'),

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
	
		'timezonekeeper' => array(
			'class' => 'TimeZoneKeeper'
		),
	),
);
