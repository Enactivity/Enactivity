<article class="view">
<dl>
	<dt><h1><?php 
		echo PHtml::link(PHtml::encode($data->name), 
			array('view', 'id'=>$data->id)); 
	?></h1></dt>
	<dd><span class="eventdate"><?php echo PHtml::encode($data->datesAsSentence); ?></span></dd>
	<dd><span class="attendeecount"><?php echo $data->eventUsersAttendingCount == 1 
		? $data->eventUsersAttendingCount . " person attending" 
		: $data->eventUsersAttendingCount . " people attending";?></span></dd>
</dl>
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