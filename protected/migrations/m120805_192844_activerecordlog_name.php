<?php

class m120805_192844_activerecordlog_name extends CDbMigration
{
	// public function up()
	// {
	// }

	// public function down()
	// {
	// 	echo "m120805_192844_activerecordlog_name does not support migration down.\n";
	// 	return false;
	// }

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('activerecordlog', 'focalModelName', 'TEXT NOT NULL AFTER  `focalModelId`');

		$log = new ActiveRecordLog();
		$logs = $log->findAll();

		foreach ($logs as $log) {
			echo "\n Updating log: " . $log->id;

			$model = $log->focalModelObject;
			
			$log->focalModelName = $model->name;
			$log->save();
			
			$log->unsetModels();
			unset($log);
		}
		echo "\n done";
	}

	public function safeDown()
	{
		return false;
	}
	
}