<?php 
/**
 * Fixture class for GroupUser table
 */

// get the groups and users
$groups = $this->getRows('groups');
$users = $this->getRows('users');

return array(
	'testGroupAdminUser' => array(
		'groupId' => $groups['testgroup']['id'],
		'userId' => $users['admin']['id'],
		'status' => User::STATUS_ACTIVE,
		'created' => date ("Y-m-d H:i:s"),
		'modified' => date ("Y-m-d H:i:s"),
	),
	'testGroupRegisteredUser' => array(
		'groupId' => $groups['testgroup']['id'],
		'userId' => $users['registered']['id'],
		'status' => User::STATUS_ACTIVE,
		'created' => date ("Y-m-d H:i:s"),
		'modified' => date ("Y-m-d H:i:s"),
	),
);