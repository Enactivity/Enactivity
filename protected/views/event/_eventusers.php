<?php foreach($eventUsers as $eventUser): ?>
<div class="user" id="c<?php echo $eventUser->user->id; ?>">

	<?php echo CHtml::link("#{$eventUser->user->id}", $eventUser->user->getUrl($post), array(
		'class'=>'cid',
		'title'=>'Permalink to this user',
	)); ?>

	<div class="name">
		<?php echo $eventUser->user->fullName() != "" ? $eventUser->user->fullName() : $eventUser->user->email; ?>
	</div>

</div><!-- user -->
<?php endforeach; ?>