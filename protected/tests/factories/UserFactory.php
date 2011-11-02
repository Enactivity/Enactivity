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
	 * @return User
	 */
	static function make($attributes = array()) {
		// invite
		$user = new User();
		$user->scenario = User::SCENARIO_INVITE;
		$user->email = "pemail+" . StringUtils::uniqueString() . "@alpha.poncla.com";
		$user->attributes = $attributes;

		return $user;
	}

	/**
	 * Generate a user who has not yet registered
	 * @see UserFactory::make
	 * @param array $attributes
	 * @param int $groupId
	 * @return User
	 */
	static function insertInvited($attributes = array(), $groupId = null) {
		// setup group if not defined
		if(is_null($groupId)) {
			$group = GroupFactory::insert();
			$groupId = $group->id;
		}

		// invite user
		$user = new User();
		$email = isset($attributes['email']) ? $attributes['email'] : "pemail+" . StringUtils::uniqueString() . "@alpha.poncla.com";
		if(!$user->inviteUser($email)) {
			throw new Exception("User factory failed on invite: " . CVarDumper::dumpAsString($user->errors));
		}

		// add user to group
		$groupUser = new GroupUser();
		if(!$groupUser->insertGroupUser($groupId, $user->id)) {
			throw new Exception("User factory failed on group invite: " . CVarDumper::dumpAsString($groupUser->errors));
		}

		return User::model()->findByPk($user->id);
	}

	/**
	 * Returns a user generated via {@link UserFactory::insertInvited()}
	 * that is an active part of the group
	 * @param array $attributes, overloads default attributes
	 * @param int $groupId
	 * @return User saved user
	 */
	static function insert($attributes = array(), $groupId = null) {
		// invite
		$user = self::insertInvited($attributes, $groupId);

		// register
		$password = StringUtils::uniqueString();
		
		$user->scenario = User::SCENARIO_REGISTER;
		$user->attributes = array(
			'firstName' => "pfirst" . StringUtils::createRandomAlphaString(),
			'lastName' => "plast" . StringUtils::createRandomAlphaString(),
			'password' => $password,
		);

		// overload attributes
		$user->attributes = $attributes;
		$user->confirmPassword = $user->password;
		
		if(!$user->registerUser($attributes)) {
			throw new Exception("User factory failed on register: " . CVarDumper::dumpAsString($user->errors));
		}

		return User::model()->findByPk($user->id);
	}

	/**
	 * Returns an admin user generated via {@link UserFactory::insertInvited()}
	 * that is an active part of the group
	 * @param array $attributes, overloads default attributes
	 * @param int $groupId
	 * @return User saved user
	 */
	static function insertAdmin($attributes = array(), $groupId = null) {
		// invite
		$user = self::insert($attributes, $groupId);
		$user->isAdmin = 1;
		if(!$user->promoteToAdmin()) {
			throw new Exception("User factory failed on admin: " . CVarDumper::dumpAsString($user->errors));
		}

		return User::model()->findByPk($user->id);
	}
}