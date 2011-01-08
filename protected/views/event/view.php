<?php
$this->pageTitle = $model->name;

$this->menu = MenuDefinitions::eventMenu($model);
?>

<?php 
//RSVP buttons
$this->renderPartial('_rsvp', array(
	'event'=>$model,
	'eventuser'=>$eventuser,
)); 
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'datesAsSentence',
		'location',
		'description:ntext',
		array( // group displayed as a link
			'label'=>$model->getAttributeLabel('groupId'),
            'type'=>'raw',
            'value'=>PHtml::link(
				PHtml::encode($model->group->name),
				$model->group->permalink,
				array(
					'class'=>'cid',
				)
			)
		),
		array( // creator displayed as a link
            'label'=>$model->getAttributeLabel('creatorId'),
            'type'=>'raw',
            'value'=>PHtml::link(
				PHtml::encode($model->creator->fullName != "" ? $model->creator->fullName : $model->creator->email), 
				$model->creator->permalink, 
				array(
					'class'=>'cid',
				)
			)
		),
		array( //created
			'label'=>$model->getAttributeLabel('created'),
			'type'=>'datetime',
			'name'=>'created',
			'value'=>strtotime($model->created),
		),
		array( //modified
			'label'=>$model->getAttributeLabel('modified'),
			'type'=>'datetime',
			'name'=>'modified',
			'value'=>strtotime($model->modified),
		),
	),
)); 

?>

<!-- List of users in event -->
<div id="users">
	<h2><?php echo $attendees->getTotalItemCount() . ' Attending'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$attendees,
		'itemView'=>'/user/_users',
	)); 
	?>
	
	<h2><?php echo $notattendees->getTotalItemCount() . ' Not Attending'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$notattendees,
		'itemView'=>'/user/_users',
	)); 
	?>
</div>