<?php

class TutorialActivityGenerator extends CComponent
{
	public static function generateIntroActivity(User $user)
	{
		$activityAttributes = array(
			/*fix me: should be groupless*/
			'groupId' => 10,
			'name' => 'Learn how to use Enactivity',
			'description' => 'Welcome to Enactivity! This is a sample activity to help guide you through the process of creating, sharing, and participating in activities and tasks.',
		);

		$tasksAttributesList = array(
			array(
				'name' => 'Sign up for Enactivity',
			),
			array(
				'name' => 'Read about Enactivity',
			),
			array(
				'name' => 'Create a new Activity',
			),
			array(
				'name' => 'Create a new Task',
			),
		);

		$form = new ActivityAndTasksForm();
		$form->publish($activityAttributes, $tasksAttributesList);

		//Setting responses for Sign up for Enactivity
		Response::signUp($form->tasks[0]->id, $user->id);
		Response::start($form->tasks[0]->id, $user->id);
		Response::complete($form->tasks[0]->id, $user->id);
		Comment::publishComment($taskdummy, array('content' => 'This is signing up'));

		//Setting respones for Read about Enactivity
		Response::signUp($form->tasks[1]->id, $user->id);
		Response::start($form->tasks[1]->id, $user->id);
		Comment::publishComment($taskdummy, array('content' => 'This is reading'));

		//Setting respones for Create a new Activity		
		Response::signUp($form->tasks[2]->id, $user->id);
		Comment::publishComment($taskdummy, array('content' => 'This is creating'));

		//Setting respones for Create a new Task
		Response::signUp($form->tasks[3]->id, $user->id);
		Comment::publishComment($taskdummy, array('content' => 'This is creating number 2'));
	}
	
}

?>