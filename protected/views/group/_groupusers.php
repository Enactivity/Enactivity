<?php foreach($groupUsers as $groupUser): ?>
<div class="user" id="c<?php echo $groupUser->user->id; ?>">

	<?php echo CHtml::link("#{$groupUser->user->id}", $groupUser->user->getUrl($post), array(
		'class'=>'cid',
	)); ?>

	<div class="name">
		<?php echo $groupUser->user->fullName() != "" ? $groupUser->user->fullName() : $groupUser->user->email; ?>
	</div>

</div><!-- user -->
<?php endforeach; ?>