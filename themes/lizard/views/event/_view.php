<div class="view">
	<div id = "picture">
		<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/images/1.jpg"></img>
	</div>
	<div id = "eventInfo">
		<div class = "eventText">
			<b><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></b>
			<i><?php echo "starts on" ?></i>
			<?php echo CHtml::encode($data->starts); ?>
			<i><?php echo "ends on"?></i>
			<?php echo CHtml::encode($data->ends); ?>
			<i><?php echo "at"?></i>
			<?php echo CHtml::encode($data->location); ?>
		</div>
	</div>
	<div id = "status">
		<?php 
		//RSVP buttons
		$this->renderPartial('_rsvp', array(
			'eventuser'=>$eventuser,
		)); 
		?>
	</div>

</div>