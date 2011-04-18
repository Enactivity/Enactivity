<?php 
/**
 * View for individual event models
 * 
 * @param Event $data model
 */

// start article
echo PHtml::openTag('article', array(
	'class' => 'view',		
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// goal name
echo PHtml::openTag('h1');
echo PHtml::link(PHtml::encode($data->name), 
	array('view', 'id'=>$data->id)
); 
echo PHtml::closeTag('h1');

//	goals toolbar
$currentUser = Yii::app()->user->id;
$goalOwner = $data->ownerId;
$currentGoal = $data->id;

echo "current user is: $currentUser";

// checking for different scenarios of edit/delete
// start footer
echo PHtml::openTag('footer');

// RSVP menu
echo PHtml::openTag('menu');

$this->widget('zii.widgets.CMenu', array(
	'items'=>MenuDefinitions::goalMenu($data),
));
echo PHtml::closeTag('menu');
echo PHtml::closeTag('footer');

// close article
echo PHtml::closeTag('article');