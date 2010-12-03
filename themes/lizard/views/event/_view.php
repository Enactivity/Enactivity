<div class="event">
	<p>
		<span class="eventname"><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></span>
	</p><p>
		<?php echo CHtml::encode(Yii::app()->format->formatDateTime($data->starts)); ?>
		-
		<?php echo CHtml::encode(Yii::app()->format->formatDateTime($data->ends)); ?>
	</p>
	<div id = "status">
		<?php 
		//RSVP buttons
		$this->renderPartial('_rsvp', array(
			'eventuser'=>$data->getRSVP(Yii::app()->user->id),
		)); 
		?>
	</div>
</div>