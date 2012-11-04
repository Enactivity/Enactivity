<?
/**
 * Lists tasks with no start time
 * @uses calendar
 */

$this->pageTitle = 'Someday';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section class="tasks agenda">
	<?
	if($calendar->itemCount > 0) {
		echo $this->renderPartial('_agenda', array(
			'calendar'=>$calendar,
			'showParent'=>true,
		));
	}
	else {
		//TODO: make more user-friendly
		echo PHtml::openTag('p', array('class'=>'no-results-message blurb'));
		echo 'Nothing here.  Why not check out the ';
		echo PHtml::link('calendar', array('task/calendar'));
		echo ' to see what is listed or ';
		echo PHtml::link('create a new task', array('task/create'));
		echo '?'; 
		echo PHtml::closeTag('p');
	}
	?>		
</section>