<?php
/**
 * Fixture class for Goal table
 */

$users = $this->getRows('User');
$groups = $this->getRows('Group');

return array(
	'testgoal' => array(
		'name' => 'this is a test goal',
		'groupId' => 1,
		'ownerId' => null,
		'isCompleted' => '0',
		'isTrash' => '0',
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
	),
);