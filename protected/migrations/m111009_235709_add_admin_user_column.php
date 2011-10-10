<?php
/**
 * Adding isAdmin column to user table
 * @author ajsharma
 */
class m111009_235709_add_admin_user_column extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('user', "isAdmin", "tinyint(1) NOT NULL DEFAULT '0' AFTER  `status`");
	}

	public function safeDown()
	{
		$this->dropColumn('user', 'isAdmin');
	}
}