<?php
Yii::import('system.console.CConsoleCommand');

class GenerateAuthCommand extends CConsoleCommand
{
	const DEFAULT_CONFIG = 'auth';

	public function run($args) {
		
		$authManager = Yii::app()->authManager;
		$authManager->clearAll(); //reset old auths
		
		// Event operations
		echo "configuring group operations\n";
		$isEventGroupMember = 'GroupUser::model()->isGroupMember($params["event"], Yii::app()->user->id;';

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
			'delete an event',
			$isEventGroupMember
		);
		
		// Event banter operations
		$authManager->createOperation('createEventBanter', 'create a ');
		$authManager->createOperation('readEventBanter', 'read a ');
		$authManager->createOperation('updateEventBanter', 'update a ');
		$authManager->createOperation('deleteEventBanter', 'delete a ');
		
		
		// Event banter operations
		$authManager->createOperation('createEventUserOperation', 'create a ');
		$authManager->createOperation('readEventUserOperation', 'read a ');
		$authManager->createOperation('updateEventUserOperation', 'update a ');
		$authManager->createOperation('deleteEventUserOperation', 'delete a ');
		
		// Group operations
		$authManager->createOperation('createGroupOperation', 'create a ');
		$authManager->createOperation('readGroupOperation', 'read a ');
		$authManager->createOperation('updateGroupOperation', 'update a ');
		$authManager->createOperation('deleteGroupOperation', 'delete a ');
		
		// Group banter operations
		$authManager->createOperation('createGroupBanterOperation', 'create a ');
		$authManager->createOperation('readGroupBanterOperation', 'read a ');
		$authManager->createOperation('updateGroupBanterOperation', 'update a ');
		$authManager->createOperation('deleteGroupBanterOperation', 'delete a ');
		
		// Group profile operations
		$authManager->createOperation('createGroupProfileOperation', 'create a ');
		$authManager->createOperation('readGroupProfileOperation', 'read a ');
		$authManager->createOperation('updateGroupProfileOperation', 'update a ');
		$authManager->createOperation('deleteGroupProfileOperation', 'delete a ');
		
		// Group user operations
		$authManager->createOperation('createGroupUserOperation', 'create a ');
		$authManager->createOperation('readGroupUserOperation', 'read a ');
		$authManager->createOperation('updateGroupUserOperation', 'update a ');
		$authManager->createOperation('deleteGroupUserOperation', 'delete a ');
		
		// User operations
		$authManager->createOperation('createUserOperation', 'create a ');
		$authManager->createOperation('readUserOperation', 'read a ');
		$authManager->createOperation('updateUserOperation', 'update a ');
		$authManager->createOperation('deleteUserOperation', 'delete a ');	
		
		$authManager->save();
		
		echo "\n\ndone";
	}
}