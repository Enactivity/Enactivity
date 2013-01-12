<section class="registrations content">
	<p class="blurb">Ordered by registration (newest to oldest).</p>

	<table>
		<tbody>
			<? foreach($userDataProvider->data as $user): ?>
			<tr>
				<td><?= PHtml::encode($user->created); ?></td>
				<td><?= PHtml::encode($user->fullName); ?></td>
				<td><?= PHtml::mailto(PHtml::encode($user->email), PHtml::encode($user->email)); ?></td>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>
</section>