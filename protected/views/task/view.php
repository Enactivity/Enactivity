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
$this->pageTitle = $model->name;
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
		<p><span class="status">Currently: <?= PHtml::encode($response->statusLabel); ?></span></p>
	</div>
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
</section>

<? if($model->starts): ?>
<section class="details content">
	<div class="start-date">
		<h1>Date</h1>
		<span class="date"><i></i> <?= PHtml::encode($model->startDate); ?></span>
	</div>
	<div class="start-time">
		<h1>Time</h1>
		<span class="time"><i></i> <?= PHtml::encode($model->formattedStartTime); ?></span>
	</div>
	<div class="participant-count">
		<h1>Signed up</h1>
		<span class="count"><?= PHtml::encode($model->participantsCount); ?></span>
	</div>
	<div class="participant-completed-count">
		<h1>Completed</h1>
		<span class="count"><?= PHtml::encode($model->participantsCompletedCount); ?></span>
	</div>
</section>
<? endif; ?>

<section id="participating" class="content">
	<? foreach($model->participatingresponses as $usertask) {
		echo $this->renderPartial('/response/_view', array(
			'data'=>$usertask,
		));
	} ?>
</section>