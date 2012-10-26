<? 
/**
 * @uses $calendar
 * @uses $month
 */
?>
<div class="menu">
	<? $this->widget('zii.widgets.CMenu', array('items'=>array(
		array(
			'label'=>PHtml::encode($month->nameOfPreviousMonth), 
			'url'=>array('task/calendar',
				'month' => $month->monthIndex - 1 < 1 ? 12 : $month->monthIndex - 1,
				'year' => $month->monthIndex - 1 < 1 ? $month->year - 1 : $month->year,
			),
			'linkOptions'=>array(
				'id'=>'task-previous-month-menu-item',
				'class'=>'task-previous-month-menu-item',
			),
		),
		array(
			'label'=>PHtml::encode($month->nameOfNextMonth), 
			'url'=>array('task/calendar',
				'month' => $month->monthIndex + 1 > 12 ? 1 : $month->monthIndex + 1,
				'year' => $month->monthIndex + 1 > 12 ? $month->year + 1 : $month->year,
			),
			'linkOptions'=>array(
				'id'=>'task-next-month-menu-item',
				'class'=>'task-next-month-menu-item',
			),
		)
	))); ?>
</div>

<article class="calendar">
	<div class="month">
		<? while($month->valid()) : ?>
		<? // if it's the start of a week (Sunday), start a new row ?>
		<? if($month->currentWDay == 0): ?>
		<div class="week">
		<? endif; ?>

			<article class="<?= PHtml::calendarDayClass($month, $calendar); ?>">
				<header>
					<?= PHtml::encode($month->currentMDay); ?>
					<span class="weekday-name"><?= PHtml::encode($month->currentWeekdayShorthand); ?><span>
				</header>
				<? foreach ($calendar->getTasksByDate($month->currentDate) as $times) {
				foreach ($times as $task) {
				
				echo $this->renderPartial('_view', array(
					'data'=>$task,
				));
				}
				}
				?>
			</article>

			<? // if it's the end of a week, end the row ?>
		<? if($month->currentWDay == 6) : ?>
		</div>
		<? endif; ?>

		<? // iterate ?>
		<? $month->next(); ?>
		<? endwhile; ?>
	</div>
</article>