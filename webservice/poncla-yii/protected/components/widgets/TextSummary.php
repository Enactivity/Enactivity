<?php
/**
 * TextSummary php class widget file
 */

/**
 * TextSummary displays the text truncated, followed by a link that
 * prompts the user to "read more".
 * @author Ajay Sharma
 * 
 * @param $this->text the text to summarize
 * @param mixed $url a URL or an action route that can be used to create a URL
 */
class TextSummary extends CWidget {
	
	/**
	 * @var CModel model
	 */
	public $text;
	
	/**
	 * @var mixed $url
	 */
	public $url;
	
	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
	}
 
	public function run()
	{
		// this method is called by CController::endWidget()
		$this->renderSummary();
	}
	
	protected function renderSummary() {
		// summarized description
		echo StringUtils::truncate(
			Yii::app()->format->formatStyledText($this->text),
			250);
		// add a read more link
		if(strlen($this->text) > 250) {
			echo ' ';
			echo PHtml::link('Read more.', 
				$this->url
			);
		}
	}
}