<header class="content-header">
	<nav class="content-header-nav">
	</nav>
</header>

<section id="sync" class="content">
	<p class="blurb">Synchronize your group listings with Facebook to invite more
		people to your activities.</p>
	<?= PHtml::htmlButton("Synchronize", array( //html
			'data-ajax-url'=>Yii::app()->createAbsoluteUrl('membership/syncWithFacebook'),
			'data-csrf-token'=>Yii::app()->request->csrfToken,
			'id'=>'membership-sync-with-facebook-menu-item',
			'class'=>'neutral membership-sync-menu-item button',
			'title'=>'Get the latest list of your groups from Facebook',
		)
	); ?>
</section>

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