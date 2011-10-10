<?php
/**
 * Factory used to quickly generate models
 * @author ajsharma
 */
class UserFactory extends AbstractFactory {

	/**
	 * Generate a user who has not yet registered, no group-user made
	 * @param array $attributes
	 * @param int $groupId
	 */
	static function make($attributes = array()) {
		// invite
		$user = new User();
		$user->scenario = User::SCENARIO_INVITE;
		$user->email = "pemail+" . uniqid() . "@alpha.poncla.com";
		$user->attributes = $attributes;

		return $user;
	}

	/**
	 * Generate a user who has not yet registered
	 * @param array $attributes
	 * @param int $groupId
	 */
	static function insertInvited($attributes, $groupId = 1) {
		$user = self::make($attributes);
		$user->save();

		// add user to group
		$groupUser = new GroupUser();
		$groupUser->groupId = $groupId;
		$groupUser->userId = $user->id;
		$groupUser->status = GroupUser::STATUS_ACTIVE;
		$groupUser->save();

		$foundUser = User::model()->findByPk($user->id);
		return $foundUser;
	}

	/**
	 * Returns a user generated via {@link UserFactory::insertInvited()}
	 * that is an active part of the group
	 * @param array $attributes, overloads default attributes
	 * @param int $groupId
	 * @return User saved user
	 */
	static function insert($attributes = array(), $groupId = 1) {
		// invite
		$user = self::insertInvited($attributes, $groupId);

		// register
		$user->scenario = User::SCENARIO_REGISTER;
		$user->attributes = array(
			'firstName' => "pfirst" + uniqid(),
			'lastName' => "plast" + uniqid(),
			'password' => "pw" + uniqid(),
		);

		// overload attributes
		$user->attributes = $attributes;

		$foundUser = User::model()->findByPk($user->id);
		return $foundUser;
	}

	/**
	 * Returns an admin user generated via {@link UserFactory::insertInvited()}
	 * that is an active part of the group
	 * @param array $attributes, overloads default attributes
	 * @param int $groupId
	 * @return User saved user
	 */
	static function insertAdmin($attributes = array(), $groupId = 1) {
		// invite
		$user = self::insert($attributes, $groupId);
		$user->isAdmin = 1;
		$user->save();

		$foundUser = User::model()->findByPk($user->id);
		return $foundUser;
	}
}