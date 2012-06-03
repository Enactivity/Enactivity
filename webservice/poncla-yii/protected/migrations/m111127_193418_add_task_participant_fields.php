<?php

class m111127_193418_add_task_participant_fields extends CDbMigration
{
	// column names
	
	const participantsCount = "participantsCount";
	const participantsCompletedCount = "participantsCompletedCount";
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		// add columns
		$this->addColumn('task', self::participantsCount, "int NOT NULL DEFAULT '0' AFTER  `level`");
		$this->addColumn('task', self::participantsCompletedCount, "int NOT NULL DEFAULT '0' AFTER  `" . self:: participantsCount . "`");
		
		// calculate column counts
	}

	public function safeDown()
	{
		$this->dropColumn('task', self::participantsCount);
		$this->dropColumn('task', self::participantsCompletedCount);
	}
}