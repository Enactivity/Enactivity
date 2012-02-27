<?php

class m120212_225738_create_store extends CDbMigration
{
	public function up()
	{
		$this->createTable('cart_item',
			array(
				"id" => "int(11) unsigned NOT NULL AUTO_INCREMENT",
				"userId" => "int(11) unsigned NOT NULL",
				"sweater_type" => "varchar(45) NOT NULL",
				"sweater_color" => "varchar(45) NOT NULL",
				"letter_color" => "varchar(45) NOT NULL",
				"letter_thread_color" => "varchar(45) NOT NULL",
				"letters" => "varchar(45) NOT NULL",
				"extra_small_count" => "int(11) unsigned NOT NULL DEFAULT 0",
				"small_count" => "int(11) unsigned NOT NULL DEFAULT 0",
				"medium_count" => "int(11) unsigned NOT NULL DEFAULT 0",
				"large_count" => "int(11) unsigned NOT NULL DEFAULT 0",
				"extra_large_count" => "int(11) unsigned NOT NULL DEFAULT 0",
				"extra_extra_large_count" => "int(11) unsigned NOT NULL DEFAULT 0",
				"isPlaced" => "datetime NOT NULL DEFAULT NULL",
				"isDelivered" => "datetime NOT NULL DEFAULT NULL",
				"created" => "datetime NOT NULL",
				"modified" => "datetime NOT NULL",
				"PRIMARY KEY (`id`)",
				"KEY `userId` (`userId`)",
			),
			"ENGINE=InnoDB DEFAULT CHARSET=utf8"
		);

		// foreign keys
		$this->addForeignKey('cart_ibfk_1', 'cart_item', 'userId', 'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m120212_225738_store does not support migration down.\n";
		return false;
	}
}