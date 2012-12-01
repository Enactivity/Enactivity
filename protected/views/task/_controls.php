<div class="menu controls">
	<ul>
		<? if($response->canSignUp): ?>
		<li>
			<?= PHtml::button(
				"I'll do this", 
				array( //html
					'submit'=>array('task/signup', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-sign-up-menu-item-' . $model->id,
					'class'=>'positive task-sign-up-menu-item',
					'title'=>'Sign up for task',
				)
			); ?>
		</li>
		<? endif; ?>

		<? if($response->canStart): ?>
		<li>
			<?= PHtml::button(
				"I'm doing this", 
				array( //html
					'submit'=>array('task/start', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-start-menu-item-' . $model->id,
					'class'=>'positive task-start-menu-item',
					'title'=>'Show that you\'ve started working on this task',
				)
			); ?>
		</li>
		<? endif; ?>

		<? if($response->canComplete): ?>
		<li>
			<?= PHtml::button(
				"I've done this",
				array( //html
					'submit'=>array('/task/complete', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-complete-menu-item-' . $model->id,
					'class'=>'positive task-complete-menu-item',
					'title'=>'Finish working on this task',
				)
			); ?>
		</li>
		<? endif; ?>

		<? if($response->canResume): ?>
		<li>
			<?= PHtml::button(
				"I've got more to do",
				array( //html
					'submit'=>array('/task/resume', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-resume-menu-item-' . $model->id,
					'class'=>'neutral task-resume-menu-item',
					'title'=>'Resume work on this task',
				)
			); ?>
		</li>
		<? endif; ?>

		<? if($response->canQuit): ?>
		<li>
			<?= PHtml::button(
				"Quit", 
				array( //html
					'submit' => array('task/quit', 'id'=>$model->id),
					'csrf' => true,
					'id'=>'task-quit-menu-item-' . $model->id,
					'class'=>'neutral task-quit-menu-item',
					'title'=>'Quit this task',
				)
			); ?>
		</li>
		<? endif; ?>

		<? if($response->canIgnore): ?>
		<li>
			<?= PHtml::button(
				"Ignore", 
				array( //html
					'submit'=>array('task/ignore', 'id'=>$model->id),
					'csrf'=>true,
					'id'=>'task-ignore-menu-item-' . $model->id,
					'class'=>'neutral task-ignore-menu-item',
					'title'=>'Ignore this task',
				)
			); ?>
		</li>
		<? endif; ?>
	</ul>
</div>