<article class="item event">
	<header>
		<h2><span><?php echo PHtml::link(PHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></span></h2>
	</header>
	<section>
		<span class="eventdate"><?php echo PHtml::encode($data->datesAsSentence); ?></span>
		<span class="attendeecount"><?php echo $data->eventUsersAttendingCount == 1 
		? $data->eventUsersAttendingCount . " person attending" 
		: $data->eventUsersAttendingCount . " people attending";?></span>
	</section>
	<footer>
	<?php 
	//RSVP buttons
	$this->renderPartial('_rsvp', array(
		'event'=>$data,
		'eventuser'=>$data->getRSVP(Yii::app()->user->id),
	)); 
	?>
	</footer>
</article>