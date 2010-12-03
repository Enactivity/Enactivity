<div class="event">
	<p>
		<span class="eventname"><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></span>
	</p><p>
		<em>Starts on</em>
		<?php echo CHtml::encode(Yii::app()->format->formatDateTime($data->starts)); ?>
		<em>ends on</em>
		<?php echo CHtml::encode(Yii::app()->format->formatDateTime($data->ends)); ?>
		<?php 
			if(isset($data->location) && !empty($data->location)):
		?>
		<em>at</em>
		<?php echo CHtml::encode($data->location); ?>
		<?php endif; ?>
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