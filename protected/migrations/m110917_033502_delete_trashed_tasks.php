<?php

class m110917_033502_delete_trashed_tasks extends CDbMigration
{
	public function up()
	{
	}

	public function down()
	{
		echo "m110917_033502_delete_trashed_tasks does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		try {
			$deletedTasks = Task::model()->findAllByAttributes(array(
						'isDeleted' => '1',
			));
			foreach ($deletedTasks as $deletedTask) {
				$deletedTask->deleteNode();
			}
		}
		catch(Exception $e) {
			return false;
		}
		
		$this->dropColumn('Task', 'isDeleted');
		return true;
	}
	
	/*
	public function safeDown()
	{
	}
	*/
}