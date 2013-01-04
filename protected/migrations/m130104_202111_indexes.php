<?php

class m130104_202111_indexes extends CDbMigration
{
	// public function up()
	// {
	// }

	public function down()
	{
		echo "m130104_202111_starts_index does not support migration down.\n";
		return false;
	}


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {

		$this->createIndex('created', 'activerecordlog', 'created');

		$this->createIndex('isTrash', 'activity', 'isTrash');
		$this->createIndex('created', 'activity', 'created');

		$this->createIndex('model', 'comment', 'model');
		$this->createIndex('modelId', 'comment', 'modelId');
		$this->createIndex('created', 'comment', 'created');

		$this->createIndex('starts', 'task', 'starts');
		$this->createIndex('created', 'task', 'created');
		$this->createIndex('isTrash', 'task', 'isTrash');

		$this->createIndex('facebookId', 'user', 'facebookId', true);

	}


	/*
	public function safeDown()
	{
	}
	*/
}