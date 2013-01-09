<?php

class TutorialActivityGenerator extends CComponent
{
	public function generateIntroActivity(User $user)
	{
		$activityAttributes = array(
			/*fix me: should be groupless*/
			'groupId' => 10,
			'name' => 'Learn to use Enactivity',
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
		var_dump($user->id);
		var_dump($form->tasks[0]->id);
		Response::complete($form->tasks[0]->id, $user->id);
	}
	
}

?>