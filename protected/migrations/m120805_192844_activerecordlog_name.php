<?php

class m120805_192844_activerecordlog_name extends CDbMigration
{
	public function up()
	{
		$this->addColumn('activerecordlog', 'focalModelName', 'TEXT NOT NULL AFTER  `focalModelId`');

		try {
			$log = new ActiveRecordLog();
			$logs = $log->findAll();

			foreach ($logs as $log) {
				echo "\n Updating log: " . $log->id;
				echo "\n   1: " . memory_get_usage();
				
				$log->focalModelName = $log->focalModelObject ? $log->focalModelObject->name : "Something";
				echo "\n name: " . $log->focalModelName;
				$log->save();

				echo "\n   2: " . memory_get_usage();
				
				$log->detachBehaviors();
				$log->unsetModels();
				unset($log);

				echo "\n   3: " . memory_get_usage();
			}
		}
		catch(Exception $e) {
			echo $e;
			return false;
		}

		echo "\n done";
	}

	// public function down()
	// {
	// 	echo "m120805_192844_activerecordlog_name does not support migration down.\n";
	// 	return false;
	// }
}