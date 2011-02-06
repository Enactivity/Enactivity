<?php

$authManager  =  Yii::app()->getAuthManager();

$isEventGroupMember = 'GroupUser::model()->isGroupMember($params["event"], Yii::app()->user->id;';

// Event operations
$authManager->createOperation(
	'readEvent', 
	'read an event', 
	$isEventGroupMember
);

$authManager->createOperation(
	'createEvent', 
	'create an event', 
	$isEventGroupMember
);

$authManager->createOperation(
	'updateEvent', 
	'update an event', 
	$isEventGroupMember
);

$authManager->createOperation(
	'deleteEvent', 
	'delete an event'
);