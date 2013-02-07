<?php
return array(

	'webApplicationConfig' => array(
		
		'components'=>array(
			
			// MySQL database settings for production
			'db'=>array(
				'connectionString' => 'mysql:dbname=enactivity_production;host=production.enactivity.com',
				'password' => '1f3870be274f6c4',
				'username' => 'poncla_live',
			),
		),
	),
);