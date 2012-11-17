<?php
Yii::import('system.console.CConsoleCommand');

class GenerateAuthCommand extends CConsoleCommand
{
	public function run($args) {
		
		$authManager = Yii::app()->authManager;
		$authManager->clearAll(); //reset old auths
		
		// Event operations
		echo "configuring event operations\n";
		$isEventGroupMemberFunction = 'membership::model()->'
			. 'isGroupMember($params["event"]->groupId, Yii::app()->user->id);';

		$authManager->createOperation(
			'readEvent', 
			'read an event', 
			$isEventGroupMemberFunction
		);
		
		$authManager->createOperation(
			'createEvent', 
			'create an event', 
			$isEventGroupMemberFunction
		);
		
		$authManager->createOperation(
			'updateEvent', 
			'update an event', 
			$isEventGroupMemberFunction
		);
		
		$authManager->createOperation(
			'deleteEvent', 
			'delete an event',
			$isEventGroupMemberFunction
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
		echo "configuring group operations\n";
		$authManager->createOperation('createGroupOperation', 'create a ');
		$authManager->createOperation('readGroupOperation', 'read a ');
		$authManager->createOperation('updateGroupOperation', 'update a ');
		$authManager->createOperation('deleteGroupOperation', 'delete a ');
		
		// Group banter operations
		$authManager->createOperation('createGroupBanterOperation', 'create a ');
		$authManager->createOperation('readGroupBanterOperation', 'read a ');
		$authManager->createOperation('updateGroupBanterOperation', 'update a ');
		$authManager->createOperation('deleteGroupBanterOperation', 'delete a ');
		
		// Group user operations
		$authManager->createOperation('createmembershipOperation', 'create a ');
		$authManager->createOperation('readmembershipOperation', 'read a ');
		$authManager->createOperation('updatemembershipOperation', 'update a ');
		$authManager->createOperation('deletemembershipOperation', 'delete a ');
		
		// User operations
		$authManager->createOperation('createUserOperation', 'create a ');
		$authManager->createOperation('readUserOperation', 'read a ');
		$authManager->createOperation('updateUserOperation', 'update a ');
		$authManager->createOperation('deleteUserOperation', 'delete a ');	
		
		
		$authManager->createRole('groupmember');
		
		$authManager->createRole('creator');
		
		$authManager->createRole('admin');
		
		$authManager->save();
		
		echo "\n\ndone";
	}
}