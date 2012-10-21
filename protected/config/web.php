<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/all.inc.php'),
	array(
		// application components
		'components'=>array(
		
			'clientScript'=>array(
				'packages'=>array(
					'jquery'=>array(
						'baseUrl'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.7/',
						'js'=>array('jquery.min.js'),
					)
				),
			),
		
			// Set the error handler
			'errorHandler'=>array(
				// use 'site/error' action to display error
				'errorAction'=>'site/error',
			),
			
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
	        
			'format'=>array(
				'class' => 'application.components.utils.Formatter',
				'dateFormat' => 'F d', 
	        	'datetimeFormat' => 'l, F d, \a\t g:i a', 
				'timeFormat' => 'g:i a', 
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
					array(
						'class'=>'CEmailLogRoute',
						'emails'=>'support-message-log@poncla.com',
						'filter' => array(
							'class' => 'CLogFilter',
							'logUser' => true,
							'prefixSession' => true,
							'prefixUser' => true,
						),
						'enabled'=>true,
						'levels'=>'error, warning',
						'sentFrom'=>'support-message-log@' . CHttpRequest::getServerName(),
						'subject'=>'Error on ' . CHttpRequest::getServerName() . ' ' . microtime(),
					),
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
				// 'caseSensitive'=>false,
				// 'matchValue'=>true,
				'rules'=>array(
					'<controller:\w+>'=>'<controller>/index',
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:(view|update|delete)>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
				'showScriptName'=>false,
				'urlFormat'=>'path', //enabled to allow for slugs
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
						'header' => "",
						'nextPageLabel' => 'Next',
						'prevPageLabel' => 'Previous',
					),
					'CListView' => array(
						'ajaxUpdate' => false,
						'cssFile' => false,
						'emptyText' => 'No results yet',
						'summaryText' => false,
						'tagName' => 'div',
					),
					'CMenu' => array(
						//'cssFile' => false,
					),
					'CPortlet' => array(
						//'cssFile' => false,
					),
	    		),
			),
		),
		
		'modules'=>array(
		),
		
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'ajsharma@poncla.com',
			'googleAnalyticsOn'=>false,
		),
		
		'theme'=>'gecko5',
		
		// uncomment to set the default controller
		//'defaultController' => 'login',
	)
);
