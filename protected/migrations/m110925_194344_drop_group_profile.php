<?php

class m110925_194344_drop_group_profile extends CDbMigration
{
	public function up()
	{
		$this->dropTable('group_profile');
	}

	public function down()
	{
		echo "m110925_194344_drop_group_profile does not support migration down.\n";
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