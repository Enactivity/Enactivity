<?php
/**
 * Factory used to quickly generate models
 * @author ajsharma
 */
class UserFactory extends AbstractFactory {

	/**
	 * Returns a new active user in the current group
	 * @param attributes, overloads default attributes
	 * @param group to add user to
	 * @return User unsaved user
	 */
	private static function make($attributes = array(), $groupId = 1) {
		// invite
		$user = new User();
		$user->scenario = User::SCENARIO_INVITE;
		$user->attributes = array(
			'email' => "pemail+" + uniqid() + "@alpha.poncla.com"
		);
		$user->save();
		
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
	
	/**
	 * Returns a user generated via {@link UserFactory::make()}
	 * @param attributes, overloads default attributes
	 * @return User saved user
	 */
	static function insert($attributes = array()) {
		$user = self::make($attributes);
		
		$user->saveNode();
		
		// add user to group
		$groupUser = new GroupUser();
		$groupUser->groupId = $groupId;
		$groupUser->userId = $user->id;
		$groupUser->status = GroupUser::STATUS_ACTIVE;
		$groupUser->save();
		
		return User::model()->findByPk($user->id);
	}
}