<?
/**
 * Displays calendar widget and agenda of tasks 
 * @uses $calendar
 * @uses $month
 *
 **/
$this->pageTitle = Yii::app()->format->formatMonth($month->firstDayOfMonthTimestamp) . " " . $month->year;
?>

<?= PHtml::beginContentHeader(); ?>
<h1><?= PHtml::encode($this->pageTitle); ?></h1>
<?= PHtml::endContentHeader(); ?>

<section id="calendar-container">
	<? 
	// show task calendar
	echo $this->renderPartial('_calendar', array(
		'calendar'=>$calendar,
		'month'=>$month,
	));
	?>
</section>