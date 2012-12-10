<?
$this->pageTitle = 'Group Membership';

?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
	<div class="menu toolbox">
		<ul>
			<li>
				<?=
				PHtml::link(
					'<i></i> Sync with Facebook', 
					array('membership/syncWithFacebook'),
					array(
						'id'=>'membership-sync-with-facebook-menu-item',
						'class'=>'neutral membership-sync-menu-item',
						'title'=>'Get the latest list of your groups from Facebook',
					)
				);
				?>
			</li>
		</ul>
	</div>
<?= PHtml::endContentHeader(); ?>

<? if(sizeof($memberships) > 0): ?>
<section>
	<? foreach ($memberships as $membership): ?>
		<? $this->renderPartial('/membership/_view', array(
			'data' => $membership,
		)); ?>
	<? endforeach; ?>
</section>

<section>
	<p class="blurb">Or <?= PHtml::link('create a new group on Facebook', 'https://facebook.com/bookmarks/groups', array('target'=>'_blank')); ?>.</p>
</section>
<? else: ?>
<section>
	<p class="blurb">We couldn't find any groups for you on Facebook, why not <?= PHtml::link('create a new group on Facebook', 'https://facebook.com/bookmarks/groups', array('target'=>'_blank')); ?>?</p>
	<p class="blurb">or...</p>
	<p class="blurb">If we suck and you do have a group, try <?= PHtml::link("synchronizing your groups and we'll try to find them again", array('membership/syncWithFacebook')); ?>.</p>
</section>
<? endif; ?>