<div class="view">
		<div class = "icon">
			<img src="<?php echo Yii::app()->theme->baseUrl . '/images/1.jpg'?>"></img>
		</div>
		<div class = "listEvents">
				<div class = "eventListText">
				<b><?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?></b>
				<?php echo on ?>
				<i><?php echo CHtml::encode($data->starts); ?></i>
				<?php echo to ?>
				<i><?php echo CHtml::encode($data->ends); ?></i>
				<?php echo at ?>
				<i><?php echo CHtml::encode($data->location); ?></i>
				<?php echo "for" ?>
				<i><?php echo CHtml::encode($data->group->name); ?></i>
			</div>
		</div>
			<div class = "viewEvent">
					<div class = "viewEventText">
						<?php 
							//RSVP buttons
								$this->renderPartial('_rsvp', array(
									'eventuser'=>$eventuser,
									));
						?>
					</div>
			</div>
</div>