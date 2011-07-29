<?php
/**
 * Fixture class for Task table
 */

$users = $this->getRows('User');
$groups = $this->getRows('Group');

return array(
	'noparenttask' => array(
		'groupId' => 1,
		'name' => 'this is a test goal',
		'priority' => 1,
		'isTrash' => '0',
		'rootId' => '1', //should match id
		'lft' => '1',
		'rgt' => '2',
		'level' => '0',
		'created' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
		'modified' => date ("Y-m-d H:i:s", strtotime("-1 hours")),
	),
);