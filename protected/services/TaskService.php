<?php 
/**
 * Service layer for interacting with Tasks
 **/
class TaskService extends Service {

	/**
	 * Get the next tasks the user is signed up for
	 * @param User model
	 * @return CArrayDataProvider
	 */
	public static function nextTasksForUser($user) {
		return new CArrayDataProvider(
			$user->nextTasks(
				array(
					'pagination'=>false,
				)
			)
		);
	}

	/**
	 * Get an ActiveDataProvider with data about tasks for a given month
	 * @param int
	 * @param Month 
	 * @return CActiveDataProvider
	 */
	public static function tasksForUserInMonth($userId, $month) {
		$taskWithDateQueryModel = new Task();
		$datedTasks = new CActiveDataProvider(
			$taskWithDateQueryModel
			->scopeUsersGroups($userId)
			->scopeByCalendarMonth($month->monthIndex, $month->year),
			array(
				'criteria'=>array(
					'condition'=>'isTrash=0'
				),
				'pagination'=>false,
			)
		);

		return $datedTasks;
	}

	/**
	 * Get an ActiveDataProvider with data about tasks with no start date
	 * @param int
	 * @return CActiveDataProvider
	 */
	public static function tasksForUserWithNoStart($userId) {
		$taskWithoutDateQueryModel = new Task();
		$datelessTasks = new CActiveDataProvider(
		$taskWithoutDateQueryModel
			->scopeUsersGroups($userId)
			->scopeNoWhen()
			->scopeNotCompleted()
			->roots(),
			array(
				'criteria'=>array(
					'condition'=>'isTrash=0'
				),
				'pagination'=>false,
			)
		);

		return $datelessTasks;
	}
}