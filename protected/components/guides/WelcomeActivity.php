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
		try {
			if(!Yii::app()->params['application.components.guides.WelcomeActivity.enabled']) {
				return;
			}

			$applicationName = Yii::app()->name;

			$activityAttributes = array(
				"name" => "Meet {$applicationName}",
				"description" => "Welcome to {$applicationName}!"
					. "\nThis is a sample activity to help guide you through the"
					. " process of creating, sharing, and participating in activities"
					. " and tasks.",
			);

			$tasksAttributesList = array(
				array(
					"name" => "Sign up for {$applicationName}",
				),
				array(
					"name" => "Learn about the Next page",
				),
				array(
					"name" => "Start planning a new Activity",
				),
				array(
					"name" => "Explore the calendar",
				),
			);

			$form = new ActivityAndTasksForm();
			$form->publishWithoutGroup($activityAttributes, $tasksAttributesList);

			Response::complete($form->tasks[0]->id, $userId);
			$signComment = new Comment();
			$signComment ->insertComment($form->tasks[0], array(
				"content" => "I did it! I completed my first" 
					. " {$applicationName} task.  Normally, that would mean anyone"
					. " else I invited to participate would also be notified.",
				)
			);

			Response::start($form->tasks[1]->id, $userId);
			$newActivityComment = new Comment();
			$newActivityComment->insertComment($form->tasks[1], array(
				"content" => "The \"next\" page is your home page for {$applicationName}."
					. "\nThere you will find tasks for activities that you have been"
					. " invited to participate in, but have not yet responded to, completed,"
					. " or ignored."
				)
			);

			Response::pend($form->tasks[2]->id, $userId);
			$newActivityComment = new Comment();
			$newActivityComment->insertComment($form->tasks[2], array(
				"content" => "Activities are great for coordinating what needs to be"
					. " done with groups.\nCreate tasks for people to participate in.",
				)
			);

			Response::pend($form->tasks[3]->id, $userId);
			$readComment = new Comment();
			$readComment->insertComment($form->tasks[3], array(
				"content" => "The calendar can be found at " . Yii::app()->createAbsoluteUrl('calendar')
					. " All tasks with start times will show up here.",
				)
			);
		}
		catch(Exception $e) {
			Yii::log($e, 'error', 'WelcomeActivity');
		}
	}
}

?>