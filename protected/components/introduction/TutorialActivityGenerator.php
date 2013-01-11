<?php

class TutorialActivityGenerator extends CComponent
{
	public static function generateIntroActivity(User $user)
	{
		$activityAttributes = array(
			/*fix me: should be groupless*/
			'groupId' => 10,
			'name' => 'apple',
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
		Response::signUp($form->tasks[0]->id, $user->id);
		Response::start($form->tasks[0]->id, $user->id);
		Response::complete($form->tasks[0]->id, $user->id);
		Response::signUp($form->tasks[1]->id, $user->id);
		Response::start($form->tasks[1]->id, $user->id);
		Response::signUp($form->tasks[2]->id, $user->id);
		Response::signUp($form->tasks[3]->id, $user->id);
	}
	
}

?>