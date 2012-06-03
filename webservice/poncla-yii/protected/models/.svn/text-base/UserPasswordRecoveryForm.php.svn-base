<?php

/**
 * UserPasswordRecoveryForm class.
 * UserPasswordRecoveryForm is the data structure for keeping
 * user password form data. It is used by the 'recoverPassword' action of 'SiteController'.
 */
class UserPasswordRecoveryForm extends CFormModel
{
	/**
	 * @var string
	 */
	public $email;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email is required
			array('email', 'required'),
			
			// trim inputs
			array('email', 'filter', 'filter'=>'trim'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
		);
	}
	
	/**
	 * Reset the user's password
	 * @return void
	 */
	public function recoverPassword() {
		$user = User::model()->findByAttributes(
			array(
				'email' => $this->email,
			)
		);
		
		if(isset($user)) {
			$user->recoverPassword();
		}
		else {
			Yii::app()->user->setFlash('error', 'No user was found with that email');
		}
	}
}
