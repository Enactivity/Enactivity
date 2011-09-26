<?php

class m110925_222858_create_table_comments extends CDbMigration
{
	/*
	public function up()
	{
	}
	*/

	public function down()
	{
		echo "m110925_222858_create_table_comments does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('comment',
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"groupId" => "int(11) unsigned NOT NULL ",
				"creatorId" => "int(11) unsigned DEFAULT NULL",
				"model" => "varchar(45)	NOT NULL",
				"modelId" => "int(11) unsigned DEFAULT NULL",
				"content" => "varchar(4000) NOT NULL",
				"created" => "datetime NOT NULL",
				"modified" => "datetime NOT NULL",
				"PRIMARY KEY (`id`)",
				"KEY `creatorId` (`creatorId`)",
				"KEY `groupId` (`groupId`)",
			),
			"ENGINE=InnoDB  DEFAULT CHARSET=utf8"
		);
		
		// foreign keys
		$this->addForeignKey('comments_ibfk_1', 'comment', 'groupId', 'group', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('comments_ibfk_2', 'comment', 'creatorId', 'user', 'id', 'CASCADE', 'CASCADE');
	}

	/*
	public function safeDown()
	{
	}
	*/
}