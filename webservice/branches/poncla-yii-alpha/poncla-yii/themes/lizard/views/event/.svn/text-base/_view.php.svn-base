<div class="event">
	<p>
		<span class="eventname"><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></span>
	</p><p>
		<em><?php echo "Starts on" ?></em>
		<?php echo CHtml::encode($data->starts); ?>
		<em><?php echo "ends on"?></em>
		<?php echo CHtml::encode($data->ends); ?>
		<em><?php echo "at"?></em>
		<?php echo CHtml::encode($data->location); ?>
	</p>
	<div id = "status">
		<?php 
		//RSVP buttons
		$this->renderPartial('_rsvp', array(
			'eventuser'=>$eventuser,
		)); 
		?>
	</div>

</div>