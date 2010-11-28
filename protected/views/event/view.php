<?php
$this->pageTitle = $model->name . ' - ' . Yii::app()->name;
$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Events', 
		'url'=>array('index'),
		'linkOptions'=>array('id'=>'event_index_menu_item'),
	),
	array('label'=>'Create a New Event', 
		'url'=>array('create'),
		'linkOptions'=>array('id'=>'event_create_menu_item'),
	),
	array('label'=>'Update This Event', 
		'url'=>array('update', 'id'=>$model->id),
		'linkOptions'=>array('id'=>'event_update_menu_item'),
	),
	array('label'=>'Delete This Event', 
		'url'=>'#', 
		'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this item?',
			'id'=>'event_delete_menu_item',
		)
	),
	array('label'=>'Admin: Manage Events', 
		'url'=>array('admin'),
		'linkOptions'=>array('id'=>'event_admin_menu_item'), 
		'visible'=>Yii::app()->user->isAdmin,
	),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'description',
		array( // creator displayed as a link
            'label'=>$model->getAttributeLabel('creatorId'),
            'type'=>'raw',
            'value'=>CHtml::link(
				CHtml::encode($model->creator->fullName() != "" ? $model->creator->fullName() : $model->creator->email), 
				$model->creator->getUrl(), 
				array(
					'class'=>'cid',
					'title'=>'Permalink to this user',
				)
			)
		),
		array( // group displayed as a link
			'label'=>$model->getAttributeLabel('groupId'),
            'type'=>'raw',
            'value'=>CHtml::link(
				CHtml::encode($model->group->name),
				$model->group->getUrl(),
				array(
					'class'=>'cid',
					'title'=>'Permalink to this group',
				)
			)
		),
		'starts',
		'ends',
		'location',
		'created',
		'modified',
	),
)); 

?>

<?php 
//RSVP buttons
$this->renderPartial('_rsvp', array(
	'eventuser'=>$eventuser,
)); 
?>

<!-- List of users in event -->
<div id="users">
	<h3>
		<?php echo $attendees->getTotalItemCount() . ' Attending'; ?>
	</h3>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$attendees,
		'itemView'=>'_users',
	)); 
	?>
</div>