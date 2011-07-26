<?php 
/**
 * View for individual task models
 * 
 * @param Task $data model
 */

// calculate article class
$articleClass[] = "view";
$articleClass[] = "task";
$articleClass[] = "task-" . $data->id;
$articleClass[] = $data->hasStarts ? "starts" : "";
$articleClass[] = $data->hasEnds ? "ends" : "";
$articleClass[] = $data->isCompleted ? "completed" : "not-completed";
$articleClass[] = $data->isTrash ? "trash" : "not-trash";
$articleClass[] = $data->isUserParticipating ? "participating" : "not-participating";

// start article
echo PHtml::openTag('article', array(
	'id' => "task-" . $data->id,
	'class' => implode(" ", $articleClass),
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// task name
echo PHtml::openTag('h1');
echo PHtml::link(
		PHtml::encode($data->name), 
		array('/task/view', 'id'=>$data->id),
		array()
	);
echo PHtml::closeTag('h1');

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');



// body

// event date
echo PHtml::openTag('p');
$this->widget('application.components.widgets.TaskDates', array(
	'task'=>$data,
));
echo PHtml::closeTag('p');

//	tasks toolbar
echo PHtml::openTag('menu');
echo PHtml::openTag('ul');

if($data->isParticipatable) {
	// show complete/uncomplete buttons if user is participating
	if($data->isUserParticipating) {
		echo PHtml::openTag('li');
		
		if($data->isUserComplete) {
			echo PHtml::ajaxLink(
				PHtml::encode('Resume'), 
				array('/task/useruncomplete', 'id'=>$data->id),
				array( //ajax
					'replace'=>'#task-' . $data->id,
					'type'=>'POST',
					'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
				),
				array( //html
					'csrf' => true,
					'id'=>'task-useruncomplete-menu-item-' . $data->id,
					'class'=>'task-useruncomplete-menu-item',
					'title'=>'Resume work on this task',
				)
			);
		}
		else {
			echo PHtml::ajaxLink(
				PHtml::encode('Complete'), 
				array('/task/usercomplete', 'id'=>$data->id),
				array( //ajax
					'replace'=>'#task-' . $data->id,
					'type'=>'POST',
					'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
				),
				array( //html
					'csrf' => true,
					'id'=>'task-usercomplete-menu-item-' . $data->id,
					'class'=>'task-usercomplete-menu-item',
					'title'=>'Finish working on this task',
				)
			); 
		}
		echo PHtml::closeTag('li');
		
		// 'participate' button
		echo PHtml::openTag('li');
		echo PHtml::ajaxLink(
			PHtml::encode('Quit'), 
			array('task/unparticipate', 'id'=>$data->id),
			array( //ajax
				'replace'=>'#task-' . $data->id,
				'type'=>'POST',
				'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->getCsrfToken(), 
			),
			array( //html
				'csrf' => true,
				'id'=>'task-unparticipate-menu-item-' . $data->id,
				'class'=>'task-unparticipate-menu-item',
				'title'=>'Quit this task',
			)
		);
		echo PHtml::closeTag('li');
	}
	else {
		echo PHtml::openTag('li');
		echo PHtml::ajaxLink(
			PHtml::encode('Sign up'), 
			array('task/participate', 'id'=>$data->id),
			array( //ajax
				'replace'=>'#task-' . $data->id,
				'type'=>'POST',
				'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
			),
			array( //html
				'csrf'=>true,
				'id'=>'task-participate-menu-item-' . $data->id,
				'class'=>'task-participate-menu-item',
				'title'=>'Sign up for task',
			)
		);
		echo PHtml::closeTag('li');
	}
}

// update link
echo PHtml::openTag('li');
echo PHtml::link(
PHtml::encode('Update'),
array('task/update', 'id'=>$data->id),
array(
		'id'=>'task-update-menu-item-' . $data->id,
		'class'=>'task-update-menu-item',
		'title'=>'Update this task',
)
);
echo PHtml::closeTag('li');

// trash link
echo PHtml::openTag('li');
if($data->isTrash) {
	echo PHtml::ajaxLink(
		PHtml::encode('Restore'), 
		array('task/untrash', 'id'=>$data->id),
		array( //ajax
			'replace'=>'#task-' . $data->id,
			'type'=>'POST',
			'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
		),
		array( //html
			'csrf'=>true,
			'id'=>'task-untrash-menu-item-' . $data->id,
			'class'=>'task-untrash-menu-item',
			'title'=>'Restore this task',
		)
	);
}
else {
	echo PHtml::ajaxLink(
		PHtml::encode('Trash'), 
		array('task/trash', 'id'=>$data->id),
		array( //ajax
			'replace'=>'#task-' . $data->id,
			'type'=>'POST',
			'data'=>Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
		),
		array( //html
			'csrf' => true,
			'id'=>'task-trash-menu-item-' . $data->id,
			'class'=>'task-trash-menu-item',
			'title'=>'Trash this task',
		)
	);
}
echo PHtml::closeTag('li');

echo PHtml::closeTag('ul');
echo PHtml::closeTag('menu');
// end of toolbar

//// list participants
//echo PHtml::openTag('ol', array('class' => 'users'));
//foreach($data->taskUsers as $taskUser) {
//	$spanClass = "view";
//	$spanClass .= " participant";
//	$spanClass .= " participant-" . $taskUser->id;
//	$spanClass .= $taskUser->isCompleted ? " completed" : " not-completed";
//	$spanClass .= $taskUser->isTrash ? " trash" : " not-trash";
//	
//	echo PHtml::openTag('li');
//	echo PHtml::openTag('span', array(
//	'class' => $spanClass,		
//	));
//	$this->widget('application.components.widgets.UserLink', array(
//		'userModel' => $taskUser->user,
//	));
//	echo PHtml::closeTag('span');
//	echo PHtml::closeTag('li');
//}
//echo PHtml::closeTag('ol');

// end body

// close article
echo PHtml::closeTag('article');