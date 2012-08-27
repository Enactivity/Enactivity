<?php

class m120827_001316_facebook_alterations extends CDbMigration
{
	public function up()
	{
		// drop user->password column
		$this->dropColumn('user', 'password');

		// drop group->slug
		$this->dropColumn('group', 'slug');

		// add group->facebookId
		$this->addColumn('group', 'facebookId', 'VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `name`');
		$this->createIndex('facebookId', 'group', 'facebookId', true);
	}

	public function down()
	{
		echo "m120827_001316_facebook_alterations does not support migration down.\n";
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