<?php 
/**
 * View for individual group models
 * 
 * @param Group $data model
 */

// start article
echo PHtml::openTag('article', array(
	'class' => 'view'
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// display <user> <action> <model> 
echo PHtml::openTag('h1');

echo PHtml::link(PHtml::encode($data->name), 
	array('view', 'slug'=>$data->slug)); 

echo PHtml::closeTag('h1');

// body
// summarized description
$this->widget('ext.widgets.TextSummary', array(
	'text' => $data->groupProfile->description,
	'url' => array('group/view', 'id'=>$data->id)
));
// end body

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

echo PHtml::closeTag('article');
