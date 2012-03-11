<?php

class m120311_225216_cartitem_rename_columns extends CDbMigration
{
	public function up()
	{
		$this->renameColumn("cart_item", "sweater_type", "sweaterType");
		$this->renameColumn("cart_item", "sweater_color", "sweaterColor");
		$this->renameColumn("cart_item", "letter_color", "letterColor");
		$this->renameColumn("cart_item", "letter_thread_color", "letterThreadColor");
		$this->renameColumn("cart_item", "extra_small_count", "extraSmallCount");
		$this->renameColumn("cart_item", "small_count", "smallCount");
		$this->renameColumn("cart_item", "medium_count", "mediumCount");
		$this->renameColumn("cart_item", "large_count", "largeCount");
		$this->renameColumn("cart_item", "extra_large_count", "extraLargeCount");
		$this->renameColumn("cart_item", "extra_extra_large_count", "extraExtraLargeCount");
		$this->renameColumn("cart_item", "isPlaced", "placed");
		$this->renameColumn("cart_item", "isDelivered", "delivered");
	}

	public function down()
	{
		echo "m120311_225216_cartitem_rename_columns does not support migration down.\n";
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