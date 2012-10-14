<?
$this->pageTitle = $model->name;
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<!-- List of users in group -->
<? if(!Yii::app()->user->isGuest):?>
<section id="users">
	<h1><?= $activemembers->totalItemCount . ' Active Members'; ?></h1>
	
	<? 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$activemembers,
		'itemView'=>'/user/_view',
	)); 
	?>
</section>
<? endif; ?>