<?php
/**
 * @param datedTasks Task[] tasks with dates
 * @param datelessTasks Task[] task with no dates
 * @param showParent boolean defaults to true
 */

// instantiate the arrays if needed
$datedTasks = empty($datedTasks) ? array() : $datedTasks;
$datelessTasks = empty($datelessTasks) ? array() : $datelessTasks;
$showParent = empty($showParent) ? $showParent : true;

?>
<?php 
$currentDate = null;
foreach($datedTasks as $task) {
	if(isset($task->starts)) {
		$taskDate = Yii::app()->format->formatDate($task->startTimestamp);
		if($taskDate != $currentDate) {
			$currentDate = $taskDate;
			$htmlId = 'day-' . $task->startDate;

			if($showParent) :
			?>
			<div class="menu novel-controls">
				<ol>
					<li>
						<?php
						echo PHtml::link(
							'Add Task',
							array('task/create/',
								'day' => PHtml::encode(date('d', $task->startTimestamp)),
								'month' => PHtml::encode(date('m', $task->startTimestamp)),
								'year' => PHtml::encode(date('Y', $task->startTimestamp)),
							)
						);
						?>
					</li>
				</ol>
			</div>
			<?php
			endif;
			echo PHtml::openTag('h1', array(
				'id' => PHtml::dateTimeId($task->startTimestamp),
				'class' => 'agenda-date',
			));
			echo $currentDate;
			echo PHtml::closeTag('h1');
		}
		echo $this->renderPartial('_view', array(
			'data'=>$task, 
			'showParent'=>$showParent,
		));
	}
}

if(!empty($datelessTasks)) {
	echo PHtml::openTag('h1', array('id' => 'no-start-datedTasks'));
	echo 'Someday';
	echo PHtml::closeTag('h1');
	foreach($datelessTasks as $task) {
		if(!isset($task->starts)) {
			echo $this->renderPartial('_view', array(
				'data'=>$task,
				'showParent'=>$showParent,
			));
		}
	}
}
?>