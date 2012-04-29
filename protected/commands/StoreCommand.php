<?php
Yii::import('system.console.CConsoleCommand');

class StoreCommand extends CConsoleCommand
{

	/**
	 * Loads sweater combinations based on the data files for sweaters
	 */
	public function actionLoadSweatersFromFile() {
		echo "Beginning initialization" . PHP_EOL;
		
		$sweaterFolder = Yii::app()->basePath . '/data/store/sweaters/';

		$styles 			= file($sweaterFolder . 'styles.txt');
		$clothColors 		= file($sweaterFolder . 'clothcolors.txt');
		$letterColors 		= file($sweaterFolder . 'lettercolors.txt');
		$stitchingColors 	= file($sweaterFolder . 'stitchingcolors.txt');
		$sizes 				= file($sweaterFolder . 'sizes.txt');

		foreach ($styles as &$style) {
			foreach ($clothColors as &$clothColor) {
				foreach ($letterColors as &$letterColor) {
					foreach ($stitchingColors as &$stitchingColor) {
						foreach ($sizes as &$size) {
							
							$attributes = array(
								'style' => trim($style),
								'clothColor' => trim($clothColor),
								'letterColor' => trim($letterColor),
								'stitchingColor' => trim($stitchingColor),
								'size' => trim($size),
								'available' => 1,
							);
							echo implode(' -- ', $attributes) . PHP_EOL;

							$sweater = new Sweater();
							if(!$sweater->insertSweater($attributes)) {
								echo "Errors: " . print_r($sweater->errors, true);
							}

							$sweater->detachBehaviors();

							unset($attributes);
							unset($sweater);

							echo "memory usage: " . memory_get_usage() . "\n";
						}
					}
				}
			}
		}

		echo "Done" . PHP_EOL;
	}
}