<?php
// Include all security classes in security folder
foreach (glob(dirname(__FILE__) . '/auth/*.php') as $filename) 
{ 
    require_once $filename; 
} 

$authManager = Yii::app()->getAuthManager();

$authManager->createOperation('createEventBanter', 'create a ');
$authManager->createOperation('readEventBanter', 'read a ');
$authManager->createOperation('updateEventBanter', 'update a ');
$authManager->createOperation('deleteEventBanter', 'delete a ');

$authManager->createOperation('createEventUserOperation', 'create a ');
$authManager->createOperation('readEventUserOperation', 'read a ');
$authManager->createOperation('updateEventUserOperation', 'update a ');
$authManager->createOperation('deleteEventUserOperation', 'delete a ');

$authManager->createOperation('createGroupOperation', 'create a ');
$authManager->createOperation('readGroupOperation', 'read a ');
$authManager->createOperation('updateGroupOperation', 'update a ');
$authManager->createOperation('deleteGroupOperation', 'delete a ');

$authManager->createOperation('createGroupBanterOperation', 'create a ');
$authManager->createOperation('readGroupBanterOperation', 'read a ');
$authManager->createOperation('updateGroupBanterOperation', 'update a ');
$authManager->createOperation('deleteGroupBanterOperation', 'delete a ');

$authManager->createOperation('createGroupProfileOperation', 'create a ');
$authManager->createOperation('readGroupProfileOperation', 'read a ');
$authManager->createOperation('updateGroupProfileOperation', 'update a ');
$authManager->createOperation('deleteGroupProfileOperation', 'delete a ');

$authManager->createOperation('createGroupUserOperation', 'create a ');
$authManager->createOperation('readGroupUserOperation', 'read a ');
$authManager->createOperation('updateGroupUserOperation', 'update a ');
$authManager->createOperation('deleteGroupUserOperation', 'delete a ');

$authManager->createOperation('createUserOperation', 'create a ');
$authManager->createOperation('readUserOperation', 'read a ');
$authManager->createOperation('updateUserOperation', 'update a ');
$authManager->createOperation('deleteUserOperation', 'delete a ');