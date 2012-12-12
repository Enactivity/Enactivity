<?
$this->pageTitle = 'Groups';

?>

<?= PHtml::beginContentHeader(); ?>
	<div class="menu content-header-menu">
		<ul>
			<li>
				<?=
				PHtml::link(
					PHtml::encode('Sync with Facebook'), 
					array('group/syncWithFacebook'),
					array(
						'id'=>'group-sync-menu-item-' . $model->id,
						'class'=>'neutral group-sync-menu-item',
						'title'=>'Get the latest list of your groups from Facebook',
					)
				);
				?>
			</li>
		</ul>
	</div>
<?= PHtml::endContentHeader(); ?>

<section>
	<h1>Member of</h1>
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'cssFile'=>false,
	)); ?>
<section>