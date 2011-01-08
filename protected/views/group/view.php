<?php
$this->pageTitle = $model->name;

$this->menu = MenuDefinitions::groupMenu($model);
?>

<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'groupProfile.description:ntext',	
		'permalink:url',
	),
)); 
?>

<!-- List of users in group -->
<?php if(!Yii::app()->user->isGuest):?>
<div id="users">
	<h2><?php echo $activemembers->getTotalItemCount() . ' Active Members'; ?></h2>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'/user/_users',
		'cssFile'=>false,
	)); 
	?>
</div>
<?php endif; ?>