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
			
			'mail'=>array(
				'dryRun'=>true,
			),
	
			'mailer'=>array(
				'shouldEmail'=>false,  
			),
		),
	)
);