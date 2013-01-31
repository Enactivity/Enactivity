<?php
Yii::import('system.console.CConsoleCommand');

class UserCommand extends CConsoleCommand
{

	/**
	 * Moves appropriate deploy configs to be used on system
	 * @param string $env the name of the environment
	 */
	public function actionPromote($userId) {
		$user = User::model()->findByPk($userId);
		if($user->promote()) {
			echo "{$user->fullName} was promoted.";
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
			echo "{$user->fullName} was demoted.";
			return;
		}

		throw new Exception("There was an error demoting the user");
	}
}