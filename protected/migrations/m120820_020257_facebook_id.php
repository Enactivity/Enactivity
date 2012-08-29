<?php

class m120820_020257_facebook_id extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'facebookId', 'VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `status`');
	}

	public function down()
	{
		echo "m120820_020257_facebook_id does not support migration down.\n";
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