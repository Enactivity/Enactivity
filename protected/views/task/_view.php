<? 
/**
 * View for individual task models
 * 
 * @param Task $data model
 */
?>
<article id="task-<?= PHtml::encode($data->id); ?>" class="<?= PHtml::taskClass($data); ?>">
	<div class="task-time">
		<? if($data->starts): ?>
		<time><?= PHtml::encode($data->formattedStartTime); ?></time>
		<? endif; ?>
	</div>
	<div class="task-body">
		<h1>
			<?= PHtml::link(
				PHtml::encode($data->name), 
				array('/task/view', 'id'=>$data->id)
			); ?>
		</h1>
		<ul class="participants">
			<? foreach($data->participants as $index => $user): ?>
			<? if($index >= 10) { break; } ?>
				<li>
					<?= PHtml::image($user->pictureUrl); ?>
				</li>
			<? endforeach; ?>
		</ul>
		<ul class="details">
			<li>
				<i></i><span class="count"><?= PHtml::encode($data->participantsCount); ?></span> signed up
				<? if($data->isUserParticipating): ?>
				<span class="user-participating">(Including you!)</span>
				<? endif; ?>
			</li>
			<li>
				<i></i><span class="count"><?= PHtml::encode($data->participantsCompletedCount); ?></span> completed
				<? if($data->isUserComplete): ?>
				<span class="user-participating">(Including you!)</span>
				<? endif; ?>
			</li>
		</ul>
	</div>

	<div class="menu controls">
		<ul>
			<li>
				<?= PHtml::dropDownList("response", $data->currentresponse->status, Response::getStatusLabels()); ?>
			</li>
		</ul>
	</div>
</article>