<?php
/**
 * This is the procedural initialization for running database tests.
 * The order of objects that need to be created is:
 * 1. Group
 * 2. Users
 * 3. Group_Users
 */
echo PHP_EOL . "Initializing fixtures";

// check basic group and two users exist
$admin = User::model()->findByAttributes(array('email'=>'admin@poncla.com'));
if(is_null($admin)) {
	$admin = UserFactory::insertAdmin(array(
		'email'=>ADMIN_EMAIL,
		'password'=>ADMIN_PASSWORD,
	), null);
	
	echo PHP_EOL . 'init.php: Initializing admin user: ' . $admin->email;
}

$registered = User::model()->findByAttributes(array('email'=>'user@poncla.com'));
if(is_null($registered)) {
	$registered = UserFactory::insert(array(
		'email'=>USER_EMAIL,
		'password'=>USER_PASSWORD,
	), null);
	
	echo PHP_EOL . 'init.php: Initializing registered user: ' . $registered->email;
}

echo PHP_EOL . "Done initializing fixtures" . PHP_EOL;