<?php

/**
 * Migration that sets all Active user's group memberships as active
 **/
class m120708_211313_ensure_no_pending_active_users extends CDbMigration
{
	public function up()
	{
		$user = new User();
		$users = $user->findAllByAttributes(
			array(
				'status' => User::STATUS_ACTIVE,
			)
		);
		
		echo "\nFound " . sizeof($users) . " active users.\n";
		foreach ($users as $user) {
			foreach ($user->groupUsers as $groupUser) {
				echo "\n Updating groupUser: " . $groupUser->id;
				$groupUser->joinGroupUser();
			}
			unset($user->groupUsers);
		}
		echo "done";
	}

	public function down()
	{
		echo "m120708_211313_ensure_no_pending_active_users does not support migration down.\n";
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