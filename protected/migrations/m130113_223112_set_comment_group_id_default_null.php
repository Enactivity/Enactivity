<?php

class m130113_223112_set_comment_group_id_default_null extends CDbMigration
{
	// public function up()
	// {
	// }

	public function down()
	{
		echo "m130113_223112_set_comment_group_id_default_null does not support migration down.\n";
		return false;
	}


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn('comment', 'groupId', 'INT( 11 ) UNSIGNED NULL DEFAULT NULL');
	}

	/*
	public function safeDown()
	{
	}
	*/
}