<? 
/**
 * View for individual task models
 * 
 * @param Task $data model
 */
$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"task-" . PHtml::encode($data->id),
		'class'=>PHtml::taskClass($data),
	),
)); ?>

	<? $story->beginStoryContent(); ?>
		<? // task name ?>
		<h1>
			<? if($data->starts): ?>
			<time><?= PHtml::encode($data->formattedStartTime); ?></time>
			<? endif; ?>
			<?= PHtml::link(
				PHtml::encode($data->name), 
				array('/task/view', 'id'=>$data->id)
			); ?>
		</h1>
	<? $story->endStoryContent(); ?>

	<div class="menu controls">
	<ul>
		<? if($data->currentresponse->canSignUp): ?>
		<li> 
			<?= PHtml::button(
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

		<? if($data->currentresponse->canStart): ?>
		<li>
			<?= PHtml::button(
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

		<? if($data->currentresponse->canComplete): ?>
		<li>
			<?= PHtml::button(
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

		<? if($data->currentresponse->canResume): ?>
		<li>
			<?= PHtml::button(
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

		<? if($data->currentresponse->canQuit): ?>
		<li>
			<?= PHtml::button(
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

		<? if($data->currentresponse->canIgnore): ?>
		<li>
			<?= PHtml::button(
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
<? $this->endWidget(); ?>