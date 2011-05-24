<?php
$this->pageTitle = $model->name;

$this->pageMenu = MenuDefinitions::groupMenu($model);
?>

<?php 

$this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name' => 'About Us',
			'value' => $model->groupProfile->description,
			'type' => 'styledtext',
			'visible' => strlen($model->groupProfile->description) > 0 ? true : false,
			
		),
		'permalink:url',
	),
)); 
?>

<!-- List of users in group -->
<?php if(!Yii::app()->user->isGuest):?>
<section id="users">
	<h1><?php echo $activemembers->getTotalItemCount() . ' Active Members'; ?></h1>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'/user/_users',
		'cssFile'=>false,
	)); 
	?>
</section>
<?php endif; ?>