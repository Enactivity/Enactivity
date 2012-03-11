<?php
// This is the test Web application configuration. Any writable
// CWebApplication properties can be configured here.
// Overrides any settings from main.inc.php
return CMap::mergeArray(
	require(dirname(__FILE__).'/web.production.php'),
	array(
		'components'=>array(
			
			// MySQL database settings for alpha
			'db'=>array(
				'connectionString' => 'mysql:host=mysql.alpha.poncla.com;dbname=poncla_alpha',
				'username' => 'poncla_alpha',
				'password' => 'alpha123',
			),
			
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					// output errors and warning to runtime file
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),
					array(
						'class'=>'CEmailLogRoute',
						'levels'=>'error, warning',
						'emails'=>'support-message-log@poncla.com',
						'enabled'=>true,
						'sentFrom'=>'support-message-log@poncla.com',
						'subject'=>'Application log alpha ' . microtime(),
					),
				),
			),
			
			'mail'=>array(
				'dryRun'=>false,
			),
	
			'mailer'=>array(
				'shouldEmail'=>true,  
			),
		),
	)
);