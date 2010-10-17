<?php foreach($users as $user): ?>
<div class="user" id="c<?php echo $user->id; ?>">

	<?php echo CHtml::link("#{$user->id}", $user->getUrl($post), array(
		'class'=>'cid',
		'title'=>'Permalink to this user',
	)); ?>

	<div class="name">
		<?php echo $user->fullName(); ?>
	</div>


</div><!-- user -->
<?php endforeach; ?>