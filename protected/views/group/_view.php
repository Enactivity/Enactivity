<?php 
/**
 * View for individual group models
 * 
 * @uses Group $data model
 */

// calculate article class
$articleClass[] = "view";
$articleClass[] = "story";

// start article
echo PHtml::openTag('article', array(
	'id' => "group-" . PHtml::encode($data->id),
	'class' => "view story " . PHtml::groupClass($data),
));

// start headers

// display <user> <action> <model> 
echo PHtml::openTag('h1', array('class'=>'story-title'));

echo PHtml::link(PHtml::encode($data->name), 
	array('view', 'id'=>$data->id)); 

echo PHtml::closeTag('h1');

echo PHtml::closeTag('article');
