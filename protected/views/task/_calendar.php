<? 
/**
 * @uses $calendar
 * @uses $month
 */
?>
<h1><?= PHtml::encode($month->name . " " . $month->year); ?></h1>

<div class="calendar-nav">
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

<article class="story calendar">
	<table>
		<thead>
			<tr>

				<? foreach (array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat") as $weekdayname): ?>
				<th>
				<?= PHtml::encode($weekdayname); ?>
				</th>
				<? endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<? while($month->valid()) : ?>
			<? // if it's the start of a week (Sunday), start a new row ?>
			<? if($month->currentWDay == 0): ?>
			<tr>
			<? endif; ?>

				<?= PHtml::tag('td', array('class' => PHtml::calendarDayClass($month, $calendar))); ?>
				<?= PHtml::calendarDayLink($month, $calendar); ?>
				</td>

			<? // if it's the end of a week, end the row ?>
			<? if($month->currentWDay == 6) : ?>
			</tr>
			<? endif; ?>

			<? // iterate ?>
			<? $month->next(); ?>
			<? endwhile; ?>
		</tbody>
	</table>
</article>