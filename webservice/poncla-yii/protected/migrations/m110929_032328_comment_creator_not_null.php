<?php

class m110929_032328_comment_creator_not_null extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('comment', 'creatorId', 'INT( 11 ) UNSIGNED NOT NULL');
	}

	public function down()
	{
		echo "m110929_032328_comment_creator_not_null does not support migration down.\n";
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