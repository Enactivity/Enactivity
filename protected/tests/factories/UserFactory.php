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
		$user->attributes = array(
			'email' => "pemail+" + uniqid() + "@alpha.poncla.com"
		);

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

		return User::model()->findAllByPk($user->id);
	}

	/**
	 * Returns a user generated via {@link UserFactory::make()}
	 * @param attributes, overloads default attributes
	 * @return User saved user
	 */
	static function insert($attributes = array(), $groupId = 1) {
		// invite
		$user = self::insertInvited($attributes, $groupId);

		// register
		$user = User::model()->findById($user->id);
		$user->scenario = User::SCENARIO_REGISTER;
		$user->attributes = array(
			'firstName' => "pfirst" + uniqid(),
			'lastName' => "plast" + uniqid(),
			'password' => "pw" + uniqid(),
		);

		// overload attributes
		$user->attributes = $attributes;

		$user->save();

		return User::model()->findByPk($user->id);
	}
}