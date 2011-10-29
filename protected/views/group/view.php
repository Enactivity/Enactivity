<?php
$this->pageTitle = $model->name;
?>

<?php echo PHtml::beginContentHeader(); ?>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<!-- List of users in group -->
<?php if(!Yii::app()->user->isGuest):?>
<section id="users">
	<h1><?php echo $activemembers->getTotalItemCount() . ' Active Members'; ?></h1>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'/user/_view',
		'cssFile'=>false,
	)); 
	?>
</section>
<?php endif; ?>