<?
/**
 * @uses $model 
 * @uses $subtasks
 * @uses $ancestors
 * @uses $newTask
 * @user $comment
 * @uses $commentsDataProvider
 * @uses $feedDataProvider
 */
?>

<header class="content-header">
	<nav class="content-header-nav">
		<ul>
			<li>
				<?= 
				PHtml::link(
					"<i></i> " . PHtml::encode($model->activity->name),
					$model->activity->viewUrl,
					array(
						'id'=>'task-activity-menu-item-' . $model->id,
						'class'=>'neutral task-activity-menu-item',
						'title'=>'View this ' . PHtml::encode($model->activity->name),
				)); ?>
			</li>
			<li>
				<?=
				PHtml::link(
					"<i></i> " . PHtml::encode('Edit'), 
					array('task/update', 'id'=>$model->id),
					array(
						'id'=>'task-update-menu-item-' . $model->id,
						'class'=>'neutral task-update-menu-item',
						'title'=>'Edit this task',
					)
				);
				?>
			</li>
			<li>
				<?=
				PHtml::link(
					"<i></i> " . PHtml::encode('Timeline'), 
					array('task/feed', 'id'=>$model->id),
					array(
						'id'=>'task-feed-menu-item',
						'class'=>'neutral task-feed-menu-item',
						'title'=>'View recent history of this task',
					)
				);
				?>
			</li>
		</ul>
	</nav>
</header>

<section class="user-response content">
	<div class="task-response-status">
		<p>Your current response: <span class="status"><?= PHtml::encode($response->statusLabel); ?></span></p>
	</div>
	<div class="menu controls">
		<ul>
			<? if($response->canSignUp): ?>
			<li> 
				<?= PHtml::htmlButton(
					"I'll do this",
					array( // html
						'data-ajax-url'=>$model->signUpUrl,
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-sign-up-menu-item-' . $model->id,
						'name'=>'task-sign-up-menu-item-' . $model->id,
						'class'=>'positive task-sign-up-menu-item',
						'title'=>'Sign up for task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($response->canStart): ?>
			<li>
				<?= PHtml::htmlButton(
					"I'm doing this", 
					array( // html
						'data-ajax-url'=>$model->startUrl, 
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-start-menu-item-' . $model->id,
						'name'=>'task-start-menu-item-' . $model->id,
						'class'=>'positive task-start-menu-item',
						'title'=>'Show that you\'ve started working on this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($response->canComplete): ?>
			<li>
				<?= PHtml::htmlButton(
					"I've done this",
					array( // html
						'data-ajax-url'=>$model->completeUrl,
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-complete-menu-item-' . $model->id,
						'name'=>'task-complete-menu-item-' . $model->id,
						'class'=>'positive task-complete-menu-item',
						'title'=>'Finish working on this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($response->canResume): ?>
			<li>
				<?= PHtml::htmlButton(
					"I've got more to do",
					array( // html
						'data-ajax-url'=>$model->resumeUrl,
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-resume-menu-item-' . $model->id,
						'name'=>'task-resume-menu-item-' . $model->id,
						'class'=>'neutral task-resume-menu-item',
						'title'=>'Resume work on this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($response->canQuit): ?>
			<li>
				<?= PHtml::htmlButton(
					"Quit",
					array( // html
						'data-ajax-url'=>$model->quitUrl,
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-quit-menu-item-' . $model->id,
						'name'=>'task-quit-menu-item-' . $model->id,
						'class'=>'neutral task-quit-menu-item',
						'title'=>'Quit this task',
					)
				); ?>
			</li>
			<? endif; ?>

			<? if($response->canIgnore): ?>
			<li>
				<?= PHtml::htmlButton(
					"Ignore",
					array( // html
						'data-ajax-url'=>$model->ignoreUrl,
						'data-csrf-token'=>Yii::app()->request->csrfToken,
						'id'=>'task-ignore-menu-item-' . $model->id,
						'name'=>'task-ignore-menu-item-' . $model->id,
						'class'=>'neutral task-ignore-menu-item',
						'title'=>'Ignore this task',
					)
				); ?>
			</li>
			<? endif; ?>
		</ul>
	</div>
</section>

<section class="briefs content">
	<? if($model->starts): ?>
	<div class="start-date">
		<h1><i></i> Date</h1>
		<p class="date"><i></i> <?= PHtml::encode($model->startDate); ?></p>
	</div>
	<div class="start-time">
		<h1><i></i> Time</h1>
		<p class="time"><i></i> <?= PHtml::encode($model->formattedStartTime); ?></p>
	</div>
	<? endif; ?>
	<div class="participant-count">
		<h1><i></i> Signed up</h1>
		<p class="count"><?= PHtml::encode($model->participantsCount); ?></p>
	</div>
	<div class="participant-completed-count">
		<h1><i></i> Completed</h1>
		<p class="count"><?= PHtml::encode($model->participantsCompletedCount); ?></p>
	</div>
</section>

<section id="participating" class="content">
	<? foreach($model->participatingresponses as $usertask) {
		echo $this->renderPartial('/response/_view', array(
			'data'=>$usertask,
		));
	} ?>
</section>

<section id="comments" class="content">
	<h1>Comments</h1>
	
	<? if($comments): ?>
	<? foreach($comments as $taskComment): ?>
	<?= $this->renderPartial('/comment/_view', array(
		'data'=>$taskComment,
	)); ?>
	<? endforeach; ?>
	<? elseif($model->isCommentable): ?>
	
	<? else: ?>
	<p class="blurb">Sorry, comments have been disabled for this activity</p>
	<? endif; ?>
	
	<? if($model->isCommentable): ?>
	<?= $this->renderPartial('/comment/_form', array('model'=>$comment)); ?>
	<? endif; ?>
</section>