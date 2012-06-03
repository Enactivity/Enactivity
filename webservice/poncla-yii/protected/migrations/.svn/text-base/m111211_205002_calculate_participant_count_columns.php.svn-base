<?php
/**
 * Recalculates the counters for task table.
 * WARNING: Will destroy data and eat lots of memory
 * @author ajsharma
 *
 */
class m111211_205002_calculate_participant_count_columns extends CDbMigration
{
	public function up()
	{
		echo "\nBeginning migration\n";
		echo "Setting task counters to zero\n";
		
		$allTasks = Task::model()->updateAll(
			array(
				'participantsCount' => 0,
				'participantsCompletedCount' => 0,
			)
		);
		
		echo "Getting leaves\n";
		$leaves = Task::model()->scopeLeaves()->findAll();
		echo "Found " . sizeof($leaves) . " leaves\n";
		
		/* @var Task $leaf */
		foreach ($leaves as $leaf) {
			echo "Getting participanting users for task " . $leaf->id . "\n";
			$taskusers = $leaf->participatingTaskUsers;
			
			/* @var TaskUser $taskuser */
			foreach ($taskusers as $taskuser) {
				if((int)$taskuser->isCompleted == 1) {
					$leaf->incrementParticipantCounts(1, 1);
				}
				else {
					$leaf->incrementParticipantCounts(1, 0);
				}
				
				$taskuser->detachBehaviors();
				unset($taskuser);
			}
			
			$leaf->detachBehaviors();
			unset($taskusers);
			unset($leaf);
			echo "Updated participanting users for task\n";
			echo "memory usage: " . memory_get_usage() . "\n";
		}
		echo "Done counter migration\n";
	}

	public function down()
	{
		echo "m111211_205002_calculate_participant_count_columns does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}