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
echo PHtml::openTag('ul');

// checking for different scenarios of edit/delete
if ($goalOwner == $currentUser){
	echo Phtml::openTag('li');
	echo PHtml::link(Edit, 
		array('update', 'id'=>$data->id)
	); 
	echo Phtml::closeTag('li');
	echo Phtml::openTag('li');
	echo PHtml::link(Delete); 
	echo Phtml::closeTag('li');
} elseif (isset($goalOwner)){
	echo "Sorry, there is a owner already, you can't edit.";
} else {
	echo Phtml::openTag('li');
	echo PHtml::link(Edit, 
		array('update', 'id'=>$data->id)
	); 
	echo Phtml::closeTag('li');
	echo Phtml::openTag('li');
	echo PHtml::link(Delete); 
	echo Phtml::closeTag('li');
}

//shows current owner otherwise show take ownership button
if (isset($goalOwner)){
	echo PHtml::openTag('li');
	echo "Goal Owner: ";
	/*echo PHtml::link(PHtml::encode($data->ownerId), 
		array('view', 'id'=>$data->ownerId)
	); */
	$this->widget('ext.widgets.UserLink', array(
		'userModel' => $data->owner,
	));
	echo Phtml::closeTag('li');
} else {
	echo PHtml::openTag('li');
	echo PHtml::link('Take Ownership'); 
	echo PHtml::closeTag('li');
	echo PHtml::openTag('li');
	echo "Goal Owner: None ";
	echo PHtml::closeTag('li');
}
echo PHtml::closeTag('ul');

// close article
echo PHtml::closeTag('article');