<?php 
/**
 * Fixture class for GroupUser table
 */

// get the groups and users
$groups = $this->getRows('groups');
$users = $this->getRows('users');

return array(
	'testGroupAdminUser' => array(
		'groupId' => 1,
		'userId' => 1,
		'status' => User::STATUS_ACTIVE,
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
	),
	'testGroupRegisteredUser' => array(
		'groupId' => 1,
		'userId' => 2,
		'status' => User::STATUS_ACTIVE,
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
	),
);