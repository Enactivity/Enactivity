<div class="item event">
	<div class="eventname">
		<span><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></span>
	</div>
	<div class="eventdate">
		<span><?php echo CHtml::encode($data->datesAsSentence); ?></span>
	</div>
	<?php 
	//RSVP buttons
	$this->renderPartial('_rsvp', array(
		'event'=>$data,
		'eventuser'=>$data->getRSVP(Yii::app()->user->id),
	)); 
	?>
</div>