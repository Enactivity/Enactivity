<?
$this->pageTitle = 'Group Membership';

?>

<header class="content-header">
	<nav class="menu content-header-menu">
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
	</nav>
</header>

<? if(sizeof($memberships) > 0): ?>
<section class="content">
	<? foreach ($memberships as $membership): ?>
		<? $this->renderPartial('/membership/_view', array(
			'data' => $membership,
		)); ?>
	<? endforeach; ?>
</section>

<section class="content">
	<p class="blurb">Or <?= PHtml::link('create a new group on Facebook', 'https://facebook.com/bookmarks/groups', array('target'=>'_blank')); ?>.</p>
</section>
<? else: ?>
<section class="content">
	<p class="blurb">We couldn't find any groups for you on Facebook, why not <?= PHtml::link('create a new group on Facebook', 'https://facebook.com/bookmarks/groups', array('target'=>'_blank')); ?>?</p>
	<p class="blurb">or...</p>
	<p class="blurb">If we suck and you do have a group, try <?= PHtml::link("synchronizing your groups and we'll try to find them again", array('membership/syncWithFacebook')); ?>.</p>
</section>
<? endif; ?>