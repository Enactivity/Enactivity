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
				
				$model = $log->focalModelObject;
				$log->focalModelName = $model ? $model->name : "Something";
				echo "\n name: " . $log->focalModelName;
				$log->save();

				echo "\n before: " . memory_get_usage();
				
				if($model) {
					$model->detachBehaviors();
					unset($model);
				}

				$log->detachBehaviors();
				$log->unsetModels();
				unset($log);

				echo "\n  after: " . memory_get_usage();
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

	
	public function up()
	{

	}	
}