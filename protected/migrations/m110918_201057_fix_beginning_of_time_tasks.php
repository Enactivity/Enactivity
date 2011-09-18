<?php

class m110918_201057_fix_beginning_of_time_tasks extends CDbMigration
{
	/*
	public function up()
	{
	}
	*/

	public function down()
	{
		echo "m110918_201057_fix_beginning_of_time_tasks does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		// Find all tasks that start at the beginning of time
		$brokenTasks = Task::model()->findAllByAttributes(array(
			'starts'=>'0000-00-00 00:00:00',
		));
		
		// Set time to null
		foreach ($brokenTasks as $task) {
			$task->starts = null;
			$task->saveNode();
		}
	}

	/*
	public function safeDown()
	{
	}
	*/
}