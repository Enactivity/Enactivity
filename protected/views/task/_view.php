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
			<? foreach($data->participantsSummary as $index => $user): ?>
				<li>
					<?= PHtml::image($user->pictureUrl); ?>
				</li>
			<? endforeach; ?>
		</ul>
		<ul class="details">
			<li>
				<i></i>
				<? if($data->participantsCompletedCount): ?>
				<span class="count"><?= PHtml::encode($data->participantsCompletedCount); ?></span> 
				of
				<span class="count"><?= PHtml::encode($data->participantsCount); ?></span>				
				participants have done this
				<? elseif($data->participantsCount): ?>
				<span class="count"><?= PHtml::encode($data->participantsCount); ?></span>
				participants
				<? else: ?>
				No one has signed up yet
				<? endif; ?>
			</li>
		</ul>
	</div>

	<div class="menu controls">
		<ul>
			<? if($data->myResponse->canSignUp): ?>
			<li> 
				<?= PHtml::htmlButton(
					"I'll do this",
					array( // html
						'data-ajax-url'=>$data->signUpUrl,
						'data-container-id'=>"#task-" . PHtml::encode($data->id), 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-sign-up-menu-item-' . $data->id,
						'name'=>'task-sign-up-menu-item-' . $data->id,
						'class'=>'positive task-sign-up-menu-item',
						'title'=>'Sign up for task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($data->myResponse->canStart): ?>
			<li>
				<?= PHtml::htmlButton(
					"I'm doing this", 
					array( // html
						'data-ajax-url'=>$data->startUrl,
						'data-container-id'=>"#task-" . PHtml::encode($data->id), 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-start-menu-item-' . $data->id,
						'name'=>'task-start-menu-item-' . $data->id,
						'class'=>'positive task-start-menu-item',
						'title'=>'Show that you\'ve started working on this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($data->myResponse->canComplete): ?>
			<li>
				<?= PHtml::htmlButton(
					"I've done this",
					array( // html
						'data-ajax-url'=>$data->completeUrl,
						'data-container-id'=>"#task-" . PHtml::encode($data->id), 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-complete-menu-item-' . $data->id,
						'name'=>'task-complete-menu-item-' . $data->id,
						'class'=>'positive task-complete-menu-item',
						'title'=>'Finish working on this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($data->myResponse->canResume): ?>
			<li>
				<?= PHtml::htmlButton(
					"I've got more to do",
					array( // html
						'data-ajax-url'=>$data->resumeUrl,
						'data-container-id'=>"#task-" . PHtml::encode($data->id), 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-resume-menu-item-' . $data->id,
						'name'=>'task-resume-menu-item-' . $data->id,
						'class'=>'neutral task-resume-menu-item',
						'title'=>'Resume work on this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($data->myResponse->canQuit): ?>
			<li>
				<?= PHtml::htmlButton(
					"Quit",
					array( // html
						'data-ajax-url'=>$data->quitUrl,
						'data-container-id'=>"#task-" . PHtml::encode($data->id), 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-quit-menu-item-' . $data->id,
						'name'=>'task-quit-menu-item-' . $data->id,
						'class'=>'neutral task-quit-menu-item',
						'title'=>'Quit this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($data->myResponse->canIgnore): ?>
			<li>
				<?= PHtml::htmlButton(
					"Ignore",
					array( // html
						'data-ajax-url'=>$data->ignoreUrl,
						'data-container-id'=>"#task-" . PHtml::encode($data->id), 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-ignore-menu-item-' . $data->id,
						'name'=>'task-ignore-menu-item-' . $data->id,
						'class'=>'neutral task-ignore-menu-item',
						'title'=>'Ignore this task',
					)
				); ?>
			</li>
			<? endif; ?>
		</ul>
	</div>
</article>