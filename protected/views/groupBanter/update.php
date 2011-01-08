<?php
$this->pageTitle = StringUtils::truncate($model->content, 60);

$this->menu=array(
	array('label'=>'Delete', 
		'url'=>'#', 
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Are you sure you want to delete this item?'),
		'visible'=>Yii::app()->user->id == $model->creatorId,
	),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>