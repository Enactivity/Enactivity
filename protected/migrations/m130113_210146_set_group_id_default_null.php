<?php

class m130113_210146_set_group_id_default_null extends CDbMigration
{
	public function down()
	{
		echo "m130113_210146_set_group_id_default_null does not support migration down.\n";
		return false;
	}

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn('task', 'groupId', 'INT( 11 ) UNSIGNED NULL DEFAULT NULL');
	}

	/*
	public function safeDown()
	{
	}
	*/
}