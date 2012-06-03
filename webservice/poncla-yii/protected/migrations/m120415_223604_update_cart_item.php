<?php

class m120415_223604_update_cart_item extends CDbMigration
{

	public function down()
	{
		echo "m120415_223604_update_cart_item does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->dropTable("cart_item");
		
		$this->createTable("cart_item",
			array(
				"id" => "INT UNSIGNED NOT NULL AUTO_INCREMENT",
				"userId" => "INT UNSIGNED NOT NULL",
				"productType" => "VARCHAR( 255 ) NOT NULL",
				"productId" => "INT UNSIGNED NOT NULL",
				"quantity" => "INT NOT NULL",
				"purchased" => "DATETIME NULL",
				"delivered" => "DATETIME NULL",
				"created" => "DATETIME NOT NULL",
				"modified" => "DATETIME NOT NULL",
				"PRIMARY KEY (  `id` )",
			),
			"ENGINE=InnoDB  DEFAULT CHARSET=utf8"
		);
	}

}