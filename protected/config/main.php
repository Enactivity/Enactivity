<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/shared.php'),
	array(
		// application components
		'components'=>array(
		
			// Set the error handler
			'errorHandler'=>array(
				// use 'site/error' action to display error
				'errorAction'=>'site/error',
			),
	        
			'format'=>array(
				'class' => 'application.components.utils.Formatter',
	        	'datetimeFormat' => 'l, M d, Y \a\t g:i a', 
			),
	        
	        // Log settings
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'info, error, warning',
					),
					array(
	                    'class'=>'CEmailLogRoute',
	                    'levels'=>'error, warning',
	                    'emails'=>'support-message-log@poncla.com',
						'enabled'=>false,
						'sentFrom'=>'support-message-log@poncla.com',
	                ),
					// un/comment the following to show/hide log messages on web pages
			//		array(
			//			'class'=>'CWebLogRoute',
			//		),
					
				),
			),
			
			'request'=>array(
				'enableCookieValidation'=>true,
				'enableCsrfValidation'=>true,
			),
			
			'user'=>array(
				// Map current user to our custom class
				'class' => 'WebUser',
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
			),
			// uncomment the following to enable URLs in path-format
			
			'urlManager'=>array(
				'urlFormat'=>'path', //enabled to allow for slugs
				'rules'=>array(
					'<slug:\w+>'=>'group/view/slug/<slug>',
					//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
				'showScriptName'=>false,
			),
			
			'widgetFactory'=>array(
				'widgets'=>array(
					'CBaseListView' => array(
						'cssFile' => false,
						'summaryText' => false,
						'tagName' => 'section',
					),
					'CBreadcrumbs' => array(
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
					'CDetailView' => array(
						'cssFile' => false,
					),
					'CGridColumn' => array(
						'cssFile' => false,
					),
					'CGridView' => array(
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
					'CLinkColumn' => array(
						'cssFile' => false,
					),
					'CLinkPager' => array(
						'cssFile' => false,
					),
					'CListView' => array(
						'cssFile' => false,
						'emptyText' => 'None yet',
						'summaryText' => false,
						'tagName' => 'section',
					),
					'CMenu' => array(
						//'cssFile' => false,
					),
					'CPortlet' => array(
						//'cssFile' => false,
					),
	    		),
			),
			
			'mailer'=>array(
        		'class'=>'application.extensions.mailer.Mailer',
        		'mta'=>'php',  
		    ),
		),
	
		'modules'=>array(
			// uncomment the following to enable the Gii tool
			// custom url manager must also be disabled
//			'gii'=>array(
//				'class'=>'system.gii.GiiModule',
//				'password'=>'123456',
//			),
		),
		
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'ajsharma@poncla.com',
		),
		
		'theme'=>'gecko5',
		
		// uncomment to set the default controller
		//'defaultController' => 'login',
	)
);
