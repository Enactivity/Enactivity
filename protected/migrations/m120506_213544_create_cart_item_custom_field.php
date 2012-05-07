<?php

class m120506_213544_create_cart_item_custom_field extends CDbMigration
{
	/*
	public function up()
	{
	}

	public function down()
	{
		echo "m120506_213544_new does not support migration down.\n";
		return false;
	}
	*/

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable("cart_item_custom_field", 
			array(
				"id" => "INT UNSIGNED NOT NULL AUTO_INCREMENT",
				"cartItemId" => "INT UNSIGNED NOT NULL",
				"key" => "VARCHAR( 50 ) NOT NULL",
				"value" => "VARCHAR( 255 ) NOT NULL",
				"created" => "DATETIME NOT NULL",
				"modified" => "DATETIME NOT NULL",
				"PRIMARY KEY ( `id` )",
				"KEY `cartItemId` (`cartItemId`)",
			), 
			"ENGINE=InnoDB  DEFAULT CHARSET=utf8"
		);
		
		$this->addForeignKey('cart_item_cffk_1', 'cart_item_custom_field', 'cartItemId',
			'cart_item', 'id', 'CASCADE', 'CASCADE'
		);
	}

	public function safeDown()
	{
		echo "m120506_213544_new does not support migration down.\n";
		return false;
	}
	
}