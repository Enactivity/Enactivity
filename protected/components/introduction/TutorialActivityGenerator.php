<?php

class TutorialActivityGenerator extends CComponent
{
	public static function generateIntroActivity(User $user)
	{
		$activityAttributes = array(
			'name' => 'Banana2',
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
		$signComment = new Comment();
		$signComment ->publishComment($form->tasks[0], array('content' => 'Sign up for an Activity'));

		//Setting respones for Read about Enactivity
		Response::signUp($form->tasks[1]->id, $user->id);
		Response::start($form->tasks[1]->id, $user->id);
		$readComment = new Comment();
		$readComment->publishComment($form->tasks[1], array('content' => 'Read more about us!'));

		//Setting respones for Create a new Activity		
		Response::signUp($form->tasks[2]->id, $user->id);
		$newActivityComment = new Comment();
		$newActivityComment->publishComment($form->tasks[2], array('content' => 'Creating an Activity'));

		//Setting respones for Create a new Task
		Response::signUp($form->tasks[3]->id, $user->id);
		$newTaskComment = new Comment();
		$newTaskComment->publishComment($form->tasks[3], array('content' => 'Creating a Task'));
	}
	
}

?>