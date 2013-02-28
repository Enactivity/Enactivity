
<h1>Quick Details</h1>

<ul>
	<? foreach(array('id', 'facebookId', 'fullName', 'email') as $attribute): ?>
	<li>
		<b><?= PHtml::encode($user->getAttributeLabel($attribute)); ?></b> :
		<?= PHtml::encode($user->$attribute); ?>
	</li>
	<? endforeach; ?>
</ul>


<h2>Groups</h2>

<ul>
	<? foreach($groups as $group): ?>
	<li>
		<?= PHtml::encode($group->name); ?> (<?= PHtml::encode($group->id); ?>)
	</li>
	<? endforeach; ?>
</ul>