<?php

class m120227_005716_user_add_phonenumber extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'phoneNumber', 'VARCHAR( 50 ) NULL DEFAULT NULL AFTER `lastName`');
	}

	public function down()
	{
		echo "m120227_005716_user_add_phonenumber does not support migration down.\n";
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