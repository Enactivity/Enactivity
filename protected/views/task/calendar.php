<?
/**
 * Displays calendar widget and agenda of tasks 
 * @uses $calendar
 * @uses $month
 *
 **/
$this->pageTitle = Yii::app()->format->formatMonth($month->firstDayOfMonthTimestamp) . " " . $month->year;
?>

<header class="content-header">
	<nav class="content-header-nav">
		<? $this->widget('zii.widgets.CMenu', array(
			'items'=>array(
				array(
					'label'=>"<i></i> " . PHtml::encode($month->nameOfPreviousMonth), 
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
					'label'=>PHtml::encode($month->nameOfNextMonth) . " <i></i>", 
					'url'=>array('task/calendar',
						'month' => $month->monthIndex + 1 > 12 ? 1 : $month->monthIndex + 1,
						'year' => $month->monthIndex + 1 > 12 ? $month->year + 1 : $month->year,
					),
					'linkOptions'=>array(
						'id'=>'task-next-month-menu-item',
						'class'=>'task-next-month-menu-item',
					),
				)
			),
			'encodeLabel'=>false
		)); ?>
	</nav>
</header>

<section id="calendar" class="calendar">
	<div class="month">
		<? while($month->valid()) : ?>
		<? // if it's the start of a week (Sunday), start a new row ?>
		<? if($month->currentWDay == 0): ?>
		<div class="week">
		<? endif; ?>

			<article class="<?= PHtml::calendarDayClass($month, $calendar); ?>">
				<header>
					<span class="day-of-month"><?= PHtml::encode($month->currentMDay); ?></span>
					<span class="weekday-shorthand-name"><?= PHtml::encode($month->currentWeekdayShorthand); ?></span>
				</header>
				<? foreach ($calendar->getTasksByDate($month->currentDate) as $time => $activities): ?>
				<? foreach ($activities as $activityIndex => $activityInfo): ?>
				<article class="activity">
					<time>
						<?= PHtml::encode($time); ?>
					</time>
					<h1>
						<?= PHtml::link(
							PHtml::encode($activityInfo['activity']->shortName),
							$activityInfo['firstTask']->activityURL
						); ?>
					</h1>
					<h2 class="tasks">
						<span class="task">
						<?= PHtml::link(
							PHtml::encode($activityInfo['firstTask']->shortName),
							$activityInfo['firstTask']->activityURL
						); ?>
						</span>
						<? if($activityInfo['more']): ?>
						<span class="more">
							<?= PHtml::link(
								'+ ' . PHtml::encode($activityInfo['more']) . ' more',
								array('activity/view', 'id'=>$activityIndex, '#'=>'day-' . $month->currentDate)
							); ?>
						</span>
						<? endif; ?>
					</h2>
				</article>
				<? endforeach; ?>
				<? endforeach; ?>
			</article>

			<? // if it's the end of a week, end the row ?>
		<? if($month->currentWDay == 6) : ?>
		</div>
		<? endif; ?>

		<? // iterate ?>
		<? $month->next(); ?>
		<? endwhile; ?>
	</div>
</section>

<footer class="content-footer">
	<nav class="content-footer-nav">
		<? $this->widget('zii.widgets.CMenu', array(
			'items'=>array(
				array(
					'label'=>"<i></i> " . PHtml::encode($month->nameOfPreviousMonth), 
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
					'label'=>'Someday', 
					'url'=>array('task/someday'),
					'linkOptions'=>array(
						'id'=>'task-someday-menu-item',
						'class'=>'task-someday-menu-item',
					),
				),
				array(
					'label'=>PHtml::encode($month->nameOfNextMonth) . " <i></i>", 
					'url'=>array('task/calendar',
						'month' => $month->monthIndex + 1 > 12 ? 1 : $month->monthIndex + 1,
						'year' => $month->monthIndex + 1 > 12 ? $month->year + 1 : $month->year,
					),
					'linkOptions'=>array(
						'id'=>'task-next-month-menu-item',
						'class'=>'task-next-month-menu-item',
					),
				)
			),
			'encodeLabel'=>false
		)); ?>
	</nav>
</footer>