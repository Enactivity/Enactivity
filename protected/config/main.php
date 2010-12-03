<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
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
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		),
		
	),

	// application components
	'components'=>array(

		// MySQL database settings
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=poncla_yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'enableParamLogging'=>false
		),
		
		// Set the error handler
		'errorHandler'=>array(
			// use 'site/error' action to display error
			'errorAction'=>'site/error',
		),
        
		'format'=>array(
        	'datetimeFormat' => 'l, M d, Y \a\t g:i a', 
		),
        
        // Log settings
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// un/comment the following to show/hide log messages on web pages
				
//				array(
//					'class'=>'CWebLogRoute',
//				),
				
			),
		),
		
		'user'=>array(
			// Map current user to our custom class
			'class' => 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'widgetFactory'=>array(
			'widgets'=>array(
				'CBaseListView' => array(
					'cssFile' => false,
				),
				'CBreadcrumbs' => array(
					//'cssFile' => false,
				),
				'CDetailView' => array(
					'cssFile' => false,
				),
				'CListView' => array(
					'cssFile' => false,
				),
				'CMenu' => array(
					//'cssFile' => false,
				),
				'CPortlet' => array(
					//'cssFile' => false,
				),
				'CButtonColumn' => array(
					'cssFile' => false,
				),
				'CCheckBoxColumn' => array(
					'cssFile' => false,
				),
				'CDataColumn' => array(
					'cssFile' => false,
				),
				'CGridColumn' => array(
					'cssFile' => false,
				),
				'CGridView' => array(
					'cssFile' => false,
				),
				'CLinkColumn' => array(
					'cssFile' => false,
				),
				'CJuiAccordion' => array(
					'cssFile' => false,
				),
				'CJuiAutoComplete' => array(
					'cssFile' => false,
				),
				'CJuiButton' => array(
					'cssFile' => false,
				),
				'CJuiDatePicker' => array(
					'cssFile' => false,
				),
				'CJuiDialog' => array(
					'cssFile' => false,
				),
				'CJuiDraggable' => array(
					'cssFile' => false,
				),
				'CJuiDroppable' => array(
					'cssFile' => false,
				),
				'CJuiInputWidget' => array(
					'cssFile' => false,
				),
				'CJuiProgressBar' => array(
					'cssFile' => false,
				),
				'CJuiResizable' => array(
					'cssFile' => false,
				),
				'CJuiSelectable' => array(
					'cssFile' => false,
				),
				'CJuiSlider' => array(
					'cssFile' => false,
				),
				'CJuiSliderInput' => array(
					'cssFile' => false,
				),
				'CJuiSortable' => array(
					'cssFile' => false,
				),
				'CJuiTabs' => array(
					'cssFile' => false,
				),
				'CJuiWidget' => array(
					'cssFile' => false,
				),
    		),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'ajsharma@poncla.com',
	),
	
	'theme'=>'lizard',
	
	// uncomment to set the default controller
	//'defaultController' => 'login',
);