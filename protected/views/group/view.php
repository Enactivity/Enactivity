<?php
$this->pageTitle = $model->name;
?>

<header>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
</header>

<!-- List of users in group -->
<?php if(!Yii::app()->user->isGuest):?>
<section id="users">
	<header>
		<hgroup>
			<h1><?php echo $activemembers->getTotalItemCount() . ' Active Members'; ?></h1>
		</hgroup>
	</header>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'/user/_users',
		'cssFile'=>false,
	)); 
	?>
</section>
<?php endif; ?>