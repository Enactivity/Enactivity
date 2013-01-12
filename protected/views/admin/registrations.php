<section class="registrations content">
	<p class="blurb">Ordered by registration (newest to oldest).</p>

	<ol>
		<? foreach($userDataProvider->data as $user): ?>
		<li>
			<?= PHtml::encode($user->created); ?>
			<?= PHtml::encode($user->fullName); ?>
			<?= PHtml::mailto(PHtml::encode($user->email), PHtml::encode($user->email)); ?>
		</li>
		<? endforeach; ?>
	</ol>
</section>