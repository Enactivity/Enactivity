<?
/**
 * Displays calendar widget and agenda of tasks 
 * @uses $calendar
 * @uses $month
 *
 **/
?>

<header class="content-header">
	<nav class="content-header-nav">
		<? $this->widget('zii.widgets.CMenu', array(
			'items'=>array(
				array(
					'label'=>"<i></i> " . PHtml::encode($month->nameOfPreviousMonth), 
					'url'=>$calendar->previousMonthUrl,
					'linkOptions'=>array(
						'id'=>'task-previous-month-menu-item',
						'class'=>'task-previous-month-menu-item',
					),
				),
				array(
					'label'=>PHtml::encode($month->nameOfNextMonth) . " <i></i>", 
					'url'=>$calendar->nextMonthUrl,
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
				<? foreach ($activities as $activityInfo): ?>
				<article class="calendar-activity">
					<time>
						<?= PHtml::encode($time); ?>
					</time>
					<h1>
						<?= PHtml::link(
							PHtml::encode($activityInfo['activity']->shortName),
							$activityInfo['firstTask']->activityURL
						); ?>
					</h1>
					<h2 class="calendar-tasks">
						<span class="calendar-task">
						<?= PHtml::link(
							PHtml::encode($activityInfo['firstTask']->shortName),
							$activityInfo['firstTask']->activityURL
						); ?>
						</span>
						<? if($activityInfo['more']): ?>
						<span class="more">
							<?= PHtml::link(
								'+ ' . PHtml::encode($activityInfo['more']) . ' more',
								array('activity/view', 'id'=>$activityInfo['activity']->id, '#'=>'day-' . $month->currentDate)
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
					'url'=>$calendar->previousMonthUrl,
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
					'url'=>$calendar->nextMonthUrl,
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