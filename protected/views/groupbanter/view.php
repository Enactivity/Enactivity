<?php
$this->pageTitle = StringUtils::truncate($model->content, 60);

$this->pageMenu = MenuDefinitions::groupBanterMenu($model);
?>

<?php $this->widget('ext.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content:styledtext',
		array( // group displayed as a link
			'label'=>$model->getAttributeLabel('groupId'),
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
			'type'=>'datetime',
			'name'=>'created',
			'value'=>strtotime($model->created),
		),
		array( //modified
			'type'=>'datetime',
			'name'=>'modified',
			'value'=>strtotime($model->modified),
			'visible'=>$model->modified != $model->created ? true : false,
		),
	),
)); ?>

<?php if($model->parent == null): ?>
<!-- List of users in event -->
<section id="replies">
	<h2><?php echo $model->repliesCount() . ' Replies'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=> $replies,
		'itemView'=>'_view',
	)); 
	?>	
</section>

<!-- Reply form -->
<section id="reply">
	<h2><?php echo 'Add Your Reply'; ?></h2>
	
	<?php 
		echo $this->renderPartial('_form', array(
			'model'=>$reply,
			'action'=>array('reply', 'parentId' => $model->id),
		)); 
	endif;
?>
</section>