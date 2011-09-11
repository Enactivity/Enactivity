<?php
$this->pageTitle = Yii::app()->format->formatMonth($month->timestamp) . " " . $month->year;
$this->menu[] = array(
	'label'=>'Previous Month', 
	'url'=>array('task/calendar',
		'month' => $month->intValue - 1 < 1 ? 12 : $month->intValue - 1,
		'year' => $month->intValue - 1 < 1 ? $month->year - 1 : $month->year,
	),
	'linkOptions'=>array('id'=>'task_next_month_menu_item'),
);

$this->menu[] = array(
	'label'=>'Next Month', 
	'url'=>array('task/calendar',
		'month' => $month->intValue + 1 > 12 ? 1 : $month->intValue + 1,
		'year' => $month->intValue + 1 > 12 ? $month->year + 1 : $month->year,
	),
	'linkOptions'=>array('id'=>'task_next_month_menu_item'),
);
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle); ?></h1>
</header>

<?php 
// show task calendar
echo $this->renderPartial('_calendar', array(
	'dataProvider'=>$datedTasksProvider,
	'month'=>$month,
));
?>

<?php
// agenda
echo $this->renderPartial('_agenda', array(
	'datedTasks'=>$datedTasksProvider->data,
	'datelessTasks'=>$datelessTasksProvider->data,
	'showParent'=>'true',
));

// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask, 'inline'=>true));
