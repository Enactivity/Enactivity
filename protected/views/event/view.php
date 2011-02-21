<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::eventMenu($model);
?>

<?php 
//RSVP buttons
$this->renderPartial('_rsvp', array(
	'event'=>$model,
	'eventuser'=>$eventuser,
)); 
?>
<?php $this->widget('ext.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'datesAsSentence',
		array(
			'name' => 'location',
			'visible' => strlen($model->location) > 0 ? true : false,
		),
		array( 
			'name' => 'description',
			'type' => 'styledtext',
			'visible' => strlen($model->description) > 0 ? true : false,
		),
		array( // group displayed as a link
			'label'=>$model->getAttributeLabel('group'),
            'type'=>'raw',
            'value'=>PHtml::link(
				PHtml::encode($model->group->name),
				$model->group->permalink,
				array(
					'class'=>'cid',
				)
			),
			'visible'=>Yii::app()->user->model->groupsCount > 1 ? true : false,
		),
//		array( // creator displayed as a link
//            'label'=>$model->getAttributeLabel('creatorId'),
//            'type'=>'raw',
//            'value'=>PHtml::link(
//				PHtml::encode($model->creator->fullName != "" ? $model->creator->fullName : $model->creator->email), 
//				$model->creator->permalink, 
//				array(
//					'class'=>'cid',
//				)
//			)
//		),
//		array( //created
//			'type'=>'datetime',
//			'name'=>'created',
//			'value'=>strtotime($model->created),
//		),
//		array( //modified
//			'type'=>'datetime',
//			'name'=>'modified',
//			'value'=>strtotime($model->modified),
//			'visible'=>$model->modified != $model->created ? true : false,
//		),
	),
)); 
?>

<section id="banter">
	<h2><?php echo $eventBanters->itemCount .' Replies'; ?></h1>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$eventBanters,
		'itemView'=>'/eventbanter/_view',
		'emptyText' => 'No one has replied to this event yet',
	)); 
	?>

	<?php 
	//Event banter form
	$this->renderPartial('/eventbanter/_form', array(
		'event'=>$model,
		'model'=>$eventBanter,
	)); 
	?>
</section>

<!-- List of users in event -->
<section id="users-attending">
	<h2><?php echo $attendees->getTotalItemCount() . ' Attending'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$attendees,
		'itemView'=>'/user/_users',
		'emptyText' => 'No one has signed up to attend yet.',
	)); 
	?>
</section>
	
<section id="users-not-attending">
	<h2><?php echo $notattendees->getTotalItemCount() . ' Not Attending'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$notattendees,
		'itemView'=>'/user/_users',
		'emptyText' => 'No one\'s said no yet.  That\'s a good sign, right?',
	)); 
	?>
</section>