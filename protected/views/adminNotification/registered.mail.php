
<h1>Quick Details</h1>

<dl>
	<dt><?= PHtml::encode($user->getAttributeLabel('id')); ?></dt>
	<dd><?= PHtml::encode($user->id); ?></dd>
	<dt><?= PHtml::encode($user->getAttributeLabel('facebookId')); ?></dt>
	<dd><?= PHtml::encode($user->facebookId); ?></dd>
	<dt><?= PHtml::encode($user->getAttributeLabel('fullName')); ?></dt>
	<dd><?= PHtml::encode($user->fullName); ?></dd>
	<dt><?= PHtml::encode($user->getAttributeLabel('email')); ?></dt>
	<dd><?= PHtml::encode($user->email); ?></dd>
</dl>


<h2>Groups</h2>

<ul>
	<? foreach($groups as $group): ?>
	<li>
		<?= PHtml::encode($group->name); ?> (<?= PHtml::encode($group->id); ?>)
	</li>
	<? endforeach; ?>
</ul>