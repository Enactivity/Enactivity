<?php
$this->pageTitle = StringUtils::truncate($model->content, 60);

$this->menu = MenuDefinitions::groupBanterMenu($model);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content:ntext',
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
)); ?>

<?php if($model->parent == null): ?>
<!-- List of users in event -->
<div id="replies">
	<h2><?php echo $model->repliesCount() . ' Replies'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=> $replies,
		'itemView'=>'_view',
	)); 
	?>	
</div>

<!-- Reply form -->
<div id="reply">
	<h2><?php echo 'Add Your Reply'; ?></h2>
	
	<?php 
		echo $this->renderPartial('_form', array(
			'model'=>$reply,
			'action'=>array('reply', 'parentId' => $model->id),
		)); 
	endif;
?>
</div>