<?php
/**
 * DetailView class file.
 *
 * @author Ajay Sharma
 */

Yii::import('zii.widgets.CDetailView');

/**
 * DetailView extends the zii.widgets.CDetailView to use definition lists 
 **/
class DetailView extends CDetailView
{
	public $tagName = 'dl';
	public $itemTemplate = "<dt class=\"{class}\">{label}</dt><dd>{value}</dd></tr>\n";
	
	
	public function run() {
		echo CHtml::openTag('section',array('id' => 'details'));
		parent::run();
		echo CHtml::closeTag('section');
	}
}
