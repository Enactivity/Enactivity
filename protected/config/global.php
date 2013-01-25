<?php
return array(

	'consoleApplicationConfig' => array(
		'basePath'=>'inherit',
		'components'=>'inherit',
		'import'=>'inherit',
		'name'=>'inherit',
		'preload'=>'inherit',
	),

	'webApplicationConfig' => array( // CWebApplication properties

		'basePath'=>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',

		'controllerMap'=>array(
			'min'=>array(
				'class'=>'ext.minscript.controllers.ExtMinScriptController',
			),
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
		
			'clientScript'=>array(
				//@see https://bitbucket.org/TeamTPG/minscript/wiki/Configuration
				'class'=>'ext.minscript.components.ExtMinScript', 
				'minScriptControllerId'=>'min',
				'minScriptLmCache'=>false, // ignored if YII_DEBUG = true
				'packages'=>array(
					'jquery'=>array(
						'baseUrl'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.8/',
						'js'=>array('jquery.min.js'),
					),
					'jquery.ui'=>array(
						'baseUrl'=>'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/',
						'js'=>array('jquery-ui.min.js'),
						'depends'=>array(
							'jquery',
						),
					),
					'modernizr'=>array(
						'basePath'=>'application.javascripts',
						'js'=>array('Modernizr.js'),
					),
					'application'=>array(
						'basePath'=>'application.javascripts',
						'depends'=>array(
							'jquery',
							'jquery.ui',
							'modernizr',
						),
						'js'=>array(
							'jquery/offset/ScrollTop.js',
							'AjaxLoader.js',
							'AjaxButton.js',
							'ClearInputsButton.js',
							'DateInputPolyfill.js',
							'DateTimePicker.js',
							'DropDown.js',
							'ReloadWindowButton.js',
							'SmoothScroll.js',
							'TargetHeaderFix.js',
							'Pjax.js',
						),
					)
				),
			),

			'db'=>array(
				'charset' => 'utf8',
				'connectionString' => '', // set in local
				'emulatePrepare' => true,
				'password' => '', // set in local
				'username' => '', // set in local
			),
		
			// Set the error handler
			'errorHandler'=>array(
				// use 'site/error' action to display error
				'errorAction'=>'site/error',
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
					'CFileLogRoute' => array(
						'class'=>'CFileLogRoute',
						'filter' => array(
							'class' => 'CLogFilter',
							'logUser' => true,
							'prefixSession' => true,
							'prefixUser' => true,
						),
						'levels'=>'error, warning',
					),
					'CEmailLogRoute' => array(
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
						'sentFrom'=>'support-message-log@' . $_SERVER['SERVER_NAME'],
						'subject'=>'Error on ' . $_SERVER['SERVER_NAME'] . ' ' . microtime(),
					),
				),
			),

			'mailer' => array(
				'class' => 'application.components.mail.Mailer',
				'enabled' => true,
				'logging' => false,
				'transportType' => 'php',
				'viewPath' => 'application.views.mail',
			),
			
			'request'=>array(
				'class' => 'application.components.web.HttpRequest',
				'enableCookieValidation'=>true,
				'enableCsrfValidation'=>true,
			),

			'session'=>array(
				'savePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'../runtime/sessions',
			),
			
			'user'=>array(
				// Map current user to our custom class
				'class' => 'application.components.auth.WebUser',
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
			),
			
			'urlManager'=>array(
				// 'caseSensitive'=>false,
				// 'matchValue'=>true,
				'rules'=>array(
					// 'gii'=>'gii',
					// 'gii/<controller:\w+>'=>'gii/<controller>',
					// 'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
					// get rid of ? to ensure proxy caching
					'min/<g:\w+>/<lm:\d+>/' => 'min/serve', 
					'next'=>'task/next',
					'calendar'=>'task/calendar',
					'login'=>'site/login',
					'logout'=>'site/logout',
					'<controller:\w+>'=>'<controller>/index',
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<id:\d+>/<action>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
				'showScriptName'=>false,
				'urlFormat'=>'path', //enabled to allow for slugs
			),

			'viewRenderer' => array(
				'class' => 'ext.mustache.MustacheViewRenderer',
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
						'htmlOptions' => array(
						),
						'firstPageLabel' => 'First',
						'lastPageLabel' => 'Last',
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

		'name'=>'Enactivity',

		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'ajsharma@poncla.com',
			
			'feedbackEmail' => 'team@poncla.com',
			'googleAnalyticsOn' => true,

			'application.components.guides.WelcomeActivity.enabled' => true,

			// flag to control whether or not email notification emails should be sent
			'ext.behaviors.model.EmailNotificationBehavior.enabled' => true,
			'ext.behaviors.model.EmailNotificationBehavior.notifyCurrentUser' => false,
		),

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
		
		'modules'=>array(

		),
	),

	'yiiDebug' => false,
	'yiiTraceLevel' => 0,

	// Set yiiPath (relative to Environment.php)
	'yiiPath'  => dirname(__FILE__) . '/../../yii_framework/yii.php',
	'yiicPath' => dirname(__FILE__) . '/../../yii_framework/yiic.php',
	'yiitPath' => dirname(__FILE__) . '/../../yii_framework/yiit.php',

	// Static function Yii::setPathOfAlias()
    'yiiSetPathOfAlias' => array(
        // uncomment the following to define a path alias
        //'local' => 'path/to/local-folder'
    ),
);