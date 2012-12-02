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
			<span class="status"><?= PHtml::encode($data->currentresponse->statusLabel); ?></span>
		</h1>
	<? $story->endStoryContent(); ?>

	<div class="menu controls">
	<ul>
		<? if($data->currentresponse->canSignUp): ?>
		<li> 
			<?= PHtml::ajaxButton(
				"I'll do this",
				$data->signUpUrl,
				array( //ajax
					'replace' =>"#task-" . PHtml::encode($data->id), 
					'type'=>'POST',
					'data'=>array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
					),
				),
				array( //html
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
			<?= PHtml::ajaxButton(
				"I'm doing this", 
				$data->startUrl,
				array( //ajax
					'replace' =>"#task-" . PHtml::encode($data->id), 
					'type'=>'POST',
					'data'=>array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
					),
				),
				array( //html
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
			<?= PHtml::ajaxButton(
				"I've done this",
				$data->completeUrl,
				array( //ajax
					'replace' =>"#task-" . PHtml::encode($data->id), 
					'type'=>'POST',
					'data'=>array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
					),
				),
				array( //html
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
			<?= PHtml::ajaxButton(
				"I've got more to do",
				$data->resumeUrl,
				array( //ajax
					'replace' =>"#task-" . PHtml::encode($data->id), 
					'type'=>'POST',
					'data'=>array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
					),
				),
				array( //html
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
			<?= PHtml::ajaxButton(
				"Quit", 
				$data->quitUrl,
				array( //ajax
					'replace' =>"#task-" . PHtml::encode($data->id), 
					'type'=>'POST',
					'data'=>array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
					),
				),
				array( //html
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
			<?= PHtml::ajaxButton(
				"Ignore", 
				$data->ignoreUrl,
				array( //ajax
					'replace' =>"#task-" . PHtml::encode($data->id), 
					'type'=>'POST',
					'data'=>array(
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
					),
				),
				array( //html
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