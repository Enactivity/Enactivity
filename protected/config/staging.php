<?php
return array(

	'webApplicationConfig' => array(
		
		'components'=>array(

			// MySQL database settings for alpha
			'db'=>array(
				'connectionString' => 'mysql:host=mysql.ajsharma.dev.enactivity.com;dbname=poncla_alpha',
				'username' => 'poncla_alpha',
				'password' => 'alpha123',
			),
		),

		'metrics' => array(
			'enabled' => false,
		),

		'params'=>array(
			'googleAnalyticsOn'=>false,
		),
	),
);