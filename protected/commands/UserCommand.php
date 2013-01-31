<?php
Yii::import('system.console.CConsoleCommand');

class UserCommand extends CConsoleCommand
{

	public function actionFindByEmail($email) {
		$user = User::findByEmail($email);
		if($user) {
			echo "{$user->fullName} has id: {$user->id}.\n";
			return;
		}

		echo "No user with email [{$email}] found.\n";
	}


	/**
	 * Moves appropriate deploy configs to be used on system
	 * @param string $env the name of the environment
	 */
	public function actionPromote($userId) {
		$user = User::model()->findByPk($userId);
		if($user->promote()) {
			echo "{$user->fullName} was promoted.\n";
			return;
		}

		throw new Exception("There was an error promoting the user");
	}

	/**
	 * Moves appropriate deploy configs to be used on system
	 * @param string $env the name of the environment
	 */
	public function actionDemote($userId) {
		$user = User::model()->findByPk($userId);
		if($user->demote()) {
			echo "{$user->fullName} was demoted.\n";
			return;
		}

		throw new Exception("There was an error demoting the user");
	}
}