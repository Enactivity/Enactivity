<?php
/**
 * Fixtures for group
 */
return array(
	// administrative user
	'admin' => array(
		'email' => 'admin@poncla.com',
		'token' => '5d7f3e28571af8824a910e81996f409b8a6f5bd9', 
		'password' => 'ac3642003276203b8ad9ceb60856fd9f7c3c286c', // "test"
		'firstName' => 'Poncla',
		'lastName' => 'Administrator',
		'status' => 'Active',
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'lastLogin' => null,
	),
	
	// registered user
	'registered' => array(
		'email' => 'user@poncla.com',
		'token' => '0865818293977c11289e0e0c33ccae70035399c3',
		'password' => 'c167541bb82fbdde5339fdf01308421608d57b10', // "test"
		'firstName' => 'Test',
		'lastName' => 'Registered',
		'status' => 'Active',
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'lastLogin' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
	),
);