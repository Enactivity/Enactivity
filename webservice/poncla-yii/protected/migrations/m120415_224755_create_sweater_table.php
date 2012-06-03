<?php

class m120415_224755_create_sweater_table extends CDbMigration
{
	public function down()
	{
		echo "m120415_224755_create_sweater_table does not support migration down.\n";
		return false;
	}

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable("sweater", 
			array(
				"id" => "INT UNSIGNED NOT NULL AUTO_INCREMENT",
				"style" => "VARCHAR( 20 ) NOT NULL",
				"clothColor" => "VARCHAR( 50 ) NOT NULL",
				"letterColor" => "VARCHAR( 50 ) NOT NULL",
				"stitchingColor" => "VARCHAR( 50 ) NOT NULL",
				"size" => "VARCHAR( 20 ) NOT NULL",
				"available" => "BOOL NOT NULL DEFAULT '0'",
				"created" => "DATETIME NOT NULL",
				"modified" => "DATETIME NOT NULL",
				"PRIMARY KEY (  `id` )",
			), 
			"ENGINE=InnoDB  DEFAULT CHARSET=utf8"
		);
		
		$this->createIndex(
			"style", 
			"sweater",
			"style,clothColor,letterColor,stitchingColor,size", 
			true
		);
	}

}