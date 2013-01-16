<?php

/**
 * The welcome activity is the initial activity we provide to the user guide
 * them through the basics of the app.
 **/
class WelcomeActivity extends CComponent {

	/** 
	 * Publishes a tutorial activity & tasks for the user to interact with
	 * @param int $userId
	 * @return null
	 * @uses Yii::app()->params[application.components.guides.WelcomeActivity.enabled]
	 **/
	public static function publish($userId)
	{
		if(!Yii::app()->params['application.components.guides.WelcomeActivity.enabled']) {
			return;
		}

		$applicationName = Yii::app()->name;

		$activityAttributes = array(
			"name" => "Meet {$applicationName}",
			"description" => "Welcome to {$applicationName}! This is a sample activity to help guide you through the process of creating, sharing, and participating in activities and tasks.",
		);

		$tasksAttributesList = array(
			array(
				"name" => "Sign up for {$applicationName}",
			),
			array(
				"name" => "Read about {$applicationName}",
			),
			array(
				"name" => "Create a new Activity",
			),
			array(
				"name" => "Create a new Task",
			),
		);

		$form = new ActivityAndTasksForm();
		$form->publishWithoutGroup($activityAttributes, $tasksAttributesList);

		// Setting responses for Sign up
		Response::signUp($form->tasks[0]->id, $userId);
		Response::start($form->tasks[0]->id, $userId);
		Response::complete($form->tasks[0]->id, $userId);
		$signComment = new Comment();
		$signComment ->publishComment($form->tasks[0], array("content" => "I did it! I completed my first task and notified the group by using these nifty interactive buttons."));

		// Setting respones for Read about
		Response::signUp($form->tasks[1]->id, $userId);
		Response::start($form->tasks[1]->id, $userId);
		$readComment = new Comment();
		$readComment->publishComment($form->tasks[1], array("content" => "I'm going to learn more about {$applicationName}. I should mark this task as completed once I feel more comfortable."));

		// Setting respones for Create a new Activity
		Response::pend($form->tasks[2]->id, $userId);
		$newActivityComment = new Comment();
		$newActivityComment->publishComment($form->tasks[2], array("content" => "Great! I will my own Activity for this group then mark this task as complete afterwards."));

		// Setting respones for Create a new Taskwar
		Response::pend($form->tasks[3]->id, $userId);
		$newTaskComment = new Comment();
		$newTaskComment->publishComment($form->tasks[3], array("content" => "What things need to be done for this Activity? I should create my first task for it."));
	}
	
}

?>