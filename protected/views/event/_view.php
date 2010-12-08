<div class="event">
	<div class="eventname">
		<span><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></span>
	</div>
	<div class="eventdate">
		<span>
		<?php echo CHtml::encode(Yii::app()->dateformatter->formatDateTime($data->starts, 'full', 'short')); ?>
		-
		<?php echo CHtml::encode(Yii::app()->dateformatter->formatDateTime($data->ends, 'long', 'short')); ?>
		</span>
	</div>
	<div id = "status">
		<?php 
		//RSVP buttons
		$this->renderPartial('_rsvp', array(
			'event'=>$data,
			'eventuser'=>$data->getRSVP(Yii::app()->user->id),
		)); 
		?>
	</div>
</div>