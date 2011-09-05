<?php
/**
 * Factory used to quickly generate model
 * @author ajsharma
 */
class TaskFactory extends AbstractFactory {

	/**
	 * Returns a new task
	 * @param attributes, overloads default attributes
	 * @return Task unsaved task
	 */
	static function make($attributes = array()) {
		$task = new Task();
		$task->name = "ptask" + uniqid();
		
		// overload attributes
		$task->attributes = $attributes;
		
		return $task;
	}
	
	/**
	 * Make a subtask
	 * @param int $parentId id of the parent task
	 * @param array $attributes
	 * @return Task subtask
	 */
	static function makeSubTask($parentId, $attributes = array()) {
		$parent = Task::model()->findByPk($parentId);

		$task = self::make($attributes);
		$task->appendTo($parent);
		
		$subtask = Task::model()->findByPk($task->id);
		return $subtask;
	}
	
	/**
	 * Returns a task generated via {@link TaskFactory::make()}
	 * @param attributes, overloads default attributes
	 * @return Task saved task
	 */
	static function insert($attributes = array()) {
		$task = self::make($attributes);
		
		$task->saveNode();
		return Task::model()->findByPk($task->id);
	}
}