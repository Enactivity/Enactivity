<section class="registrations content">
	<p class="blurb">Ordered by registration (newest to oldest).</p>

	<table>
		<tbody>
			<? foreach($users as $user): ?>
			<tr>
				<td><?= PHtml::encode($user->created); ?></td>
				<td><?= PHtml::encode($user->fullName); ?></td>
				<td><?= PHtml::mailto(PHtml::encode($user->email), PHtml::encode($user->email)); ?></td>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>

	<div class="pager">
		<ul>
			<li class="previous"><a href="<?= $previousPageUrl ?>">Previous</a></li>
			<li class="next"><a href="<?= $nextPageUrl ?>">Next</a></li>
</section>