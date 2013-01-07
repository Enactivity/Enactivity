<?php

class TutorialActivityGenerator extends CComponent
{
	public function generateIntroActivity()
	{
		$activityAttributes = array(
			/*fix me: should be groupless*/
			'groupId' => 10,
			'name' => 'Introduction Activity',
			'description' => 'This is a the first activity',
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
	}
	
}

?>