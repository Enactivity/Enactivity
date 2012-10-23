<?
$this->pageTitle = 'Group Membership';

?>

<?= PHtml::beginContentHeader(); ?>
	<div class="menu toolbox">
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
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<? if($dataProvider->totalItemCount > 0): ?>
<section class="novel">
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'cssFile'=>false,
	)); ?>
<section>

<section>
	<p class="blurb">Or <?= PHtml::link('create a new group on Facebook', 'https://facebook.com/bookmarks/groups', array('target'=>'_blank')); ?>.</p>
<section>
<? else: ?>
<section>
	<p class="blurb">We couldn't find any groups for you on Facebook, why not <?= PHtml::link('create a new group on Facebook', 'https://facebook.com/bookmarks/groups', array('target'=>'_blank')); ?> and then refresh this page?</p>
	<p class="blurb">Or</p>
	<p class="blurb">If we suck and you do have a group, try <?= PHtml::link("synchronizing your groups and we'll try to find them again", array('group/syncWithFacebook')); ?>.</p>
</section>
<? endif; ?>