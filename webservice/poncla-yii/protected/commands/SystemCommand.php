<?php
Yii::import('system.console.CConsoleCommand');

class SystemCommand extends CConsoleCommand
{

	/**
	 * Moves appropriate deploy configs to be used on system
	 * @param string $env the name of the environment
	 */
	public function actionConfig($env) {
		echo "Beginning config\n";
		$configFolder = Yii::app()->basePath . '/config/';
		
		$websource = $configFolder . 'web.' . $env . '.php';
		$webdest = $configFolder . 'web.local.php';
		
		$consolesource = $configFolder . 'console.' . $env . '.php';
		$consoledest = $configFolder . 'console.local.php';
		
		if(copy($websource, $webdest) && copy($consolesource, $consoledest)) {
			echo "Config successful\n";
			return;
		}
		else {
			throw new Exception("There was an error deploying config files");
		}
	}
	
	/**
	 * Deploys yii files
	 */
	public function actionDeploy() {
		
	}
}