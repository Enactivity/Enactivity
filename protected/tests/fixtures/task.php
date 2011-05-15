<?php
/**
 * Fixture class for Task table
 */

$users = $this->getRows('User');
$groups = $this->getRows('Group');

return array(
	'noparenttask' => array(
		'groupId' => 1,
		'parentId' => null,
		'name' => 'this is a test goal',
		'priority' => 1,
		'isTrash' => '0',
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
	),
);