<section class="details content">
	<? foreach($counts as $title => $count): ?>
	<div>
		<h1><i></i> <?= PHtml::encode($title); ?></h1>
		<p class="date"><i></i> <?= PHtml::encode($count); ?></p>
	</div>
	<? endforeach; ?>
</section>