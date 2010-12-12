<?php

/**
 * UserPasswordRecoveryForm class.
 * UserPasswordRecoveryForm is the data structure for keeping
 * user password form data. It is used by the 'recoverPassword' action of 'SiteController'.
 */
class UserPasswordRecoveryForm extends CFormModel
{
	public $usernameOrEmail;

	/**
	 * Declares the validation rules.
	 * The rules state that usernameOrEmail and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// usernameOrEmail and password are required
			array('usernameOrEmail', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'usernameOrEmail'=>'Email',
		);
	}
	
	/**
	 * Reset the user's password
	 */
	public function recoverPassword() {
		$user = User::findByUsernameOrEmail($this->usernameOrEmail);
		if(isset($user)) {
			$user->recoverPassword();
		}
		else {
			Yii::app()->user->setFlash('error', 'No user was found with that username or email');
		}
	}
}
