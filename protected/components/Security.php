<?php
$authManager  =  Yii::app()->authManager;

$authManager->createOperation('createEvent', 'create a ');
$authManager->createOperation('readEvent', 'read a ');
$authManager->createOperation('updateEvent', 'update a ');
$authManager->createOperation('deleteEvent', 'delete a ');

$authManager->createOperation('createEventBanter', 'create a ');
$authManager->createOperation('readEventBanter', 'read a ');
$authManager->createOperation('updateEventBanter', 'update a ');
$authManager->createOperation('deleteEventBanter', 'delete a ');

$authManager->createOperation('createEventUser', 'create a ');
$authManager->createOperation('readEventUser', 'read a ');
$authManager->createOperation('updateEventUser', 'update a ');
$authManager->createOperation('deleteEventUser', 'delete a ');

$authManager->createOperation('createEventUser', 'create a ');
$authManager->createOperation('readEventUser', 'read a ');
$authManager->createOperation('updateEventUser', 'update a ');
$authManager->createOperation('deleteEventUser', 'delete a ');

$authManager->createOperation('createGroup', 'create a ');
$authManager->createOperation('readGroup', 'read a ');
$authManager->createOperation('updateGroup', 'update a ');
$authManager->createOperation('deleteGroup', 'delete a ');

$authManager->createOperation('createGroupBanter', 'create a ');
$authManager->createOperation('readGroupBanter', 'read a ');
$authManager->createOperation('updateGroupBanter', 'update a ');
$authManager->createOperation('deleteGroupBanter', 'delete a ');

$authManager->createOperation('createGroupProfile', 'create a ');
$authManager->createOperation('readGroupProfile', 'read a ');
$authManager->createOperation('updateGroupProfile', 'update a ');
$authManager->createOperation('deleteGroupProfile', 'delete a ');

$authManager->createOperation('createGroupUser', 'create a ');
$authManager->createOperation('readGroupUser', 'read a ');
$authManager->createOperation('updateGroupUser', 'update a ');
$authManager->createOperation('deleteGroupUser', 'delete a ');

$authManager->createOperation('createUser', 'create a ');
$authManager->createOperation('readUser', 'read a ');
$authManager->createOperation('updateUser', 'update a ');
$authManager->createOperation('deleteUser', 'delete a ');
 

/// sample code begins here /////////////////
$bizRule = 'return Yii::app()->user->id =  = $params["post"]->authID;';
$task = $authManager->createTask('updateOwnPost', 'update a post by author himself', $bizRule);
$task->addChild('updatePost');
 
$role = $authManager->createRole('reader');
$role->addChild('readPost');
 
$role = $authManager->createRole('author');
$role->addChild('reader');
$role->addChild('createPost');
$role->addChild('updateOwnPost');
 
$role = $authManager->createRole('editor');
$role->addChild('reader');
$role->addChild('updatePost');
 
$role = $authManager->createRole('admin');
$role->addChild('editor');
$role->addChild('author');
$role->addChild('deletePost');