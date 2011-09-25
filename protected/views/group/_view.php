<?php 
/**
 * View for individual group models
 * 
 * @uses Group $data model
 */

// calculate article class
$articleClass[] = "view";
$articleClass[] = "story";
$articleClass[] = "group";
$articleClass[] = "group-" . PHtml::encode($data->id);

// start article
echo PHtml::openTag('article', array(
	'id' => "group-" . PHtml::encode($data->id),
	'class' => implode(" ", $articleClass),
));

// start headers

// display <user> <action> <model> 
echo PHtml::openTag('h1', array('class'=>'story-title'));

echo PHtml::link(PHtml::encode($data->name), 
	array('view', 'slug'=>$data->slug)); 

echo PHtml::closeTag('h1');

echo PHtml::closeTag('article');
