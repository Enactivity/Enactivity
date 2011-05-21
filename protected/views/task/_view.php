<?php 
/**
 * View for individual task models
 * 
 * @param Task $data model
 */

// calculate article class
$articleClass = "view";
$articleClass .= " task";
$articleClass .= " task-" . $data->id;
$articleClass .= $data->isCompleted ? " completed" : " not-completed";
$articleClass .= $data->isTrash ? " trash" : " not-trash";

// start article
echo PHtml::openTag('article', array(
	'class' => $articleClass,		
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// event date
echo PHtml::openTag('h2');
if(isset($data->starts)) {
	echo PHtml::openTag('time');
	echo Yii::app()->format->formatDateTime(strtotime($data->starts));
	echo PHtml::closeTag('time');
}

if(isset($data->starts) && isset($data->ends)) {
	echo PHtml::encode(' to ');	
}

if(isset($data->ends)) {
	echo PHtml::openTag('time');
	echo Yii::app()->format->formatDateTime(strtotime($data->ends));
	echo PHtml::closeTag('time');
}
echo PHtml::closeTag('h2');

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

//	tasks toolbar
echo PHtml::openTag('menu');
echo PHtml::openTag('ul');

// update link
echo PHtml::openTag('li');
echo PHtml::link(
	PHtml::encode('Update'), 
	array('task/update', 'id'=>$data->id),
	array(
		'id'=>'task-update-menu-item-' . $data->id,
		'class'=>'task-update-menu-item',
	)
);
echo PHtml::closeTag('li');

// show complete/uncomplete buttons if user is participating
if($data->isUserParticipating) {
	echo PHtml::openTag('li');
	
	if($data->isUserComplete) {
		echo PHtml::link(
			PHtml::encode('Uncomplete'), 
			array('/task/useruncomplete', 'id'=>$data->id),
			array(
				'submit'=>array(
					'task/useruncomplete',
					'id'=>$data->id,
				),
				'csrf' => true,
				'id'=>'task-useruncomplete-menu-item-' . $data->id,
				'class'=>'task-useruncomplete-menu-item',
			)
		);
	}
	else {
		echo PHtml::link(
			PHtml::encode('Complete'), 
			array('/task/usercomplete', 'id'=>$data->id),
			array(
				'submit'=>array(
					'task/usercomplete',
					'id'=>$data->id,
				),
				'csrf' => true,
				'id'=>'task-usercomplete-menu-item-' . $data->id,
				'class'=>'task-usercomplete-menu-item',
			)
		); 
	}
	echo PHtml::closeTag('li');
	
	// 'participate' button
	echo PHtml::openTag('li');
	echo PHtml::link(
		PHtml::encode('Quit'), 
		array('task/unparticipate', 'id'=>$data->id),
		array(
			'submit'=>array(
				'task/unparticipate',
				'id'=>$data->id,
			),
			'csrf' => true,
			'id'=>'task-unparticipate-menu-item-' . $data->id,
			'class'=>'task-unparticipate-menu-item',
		)
	);
	echo PHtml::closeTag('li');
}
else {
	echo PHtml::openTag('li');
	echo PHtml::link(
		PHtml::encode('Sign up'), 
		array('task/participate', 'id'=>$data->id),
		array(
			'submit'=>array(
				'task/participate',
				'id'=>$data->id,
			),
			'csrf' => true,
			'id'=>'task-participate-menu-item-' . $data->id,
			'class'=>'task-participate-menu-item',
		)
	);
	echo PHtml::closeTag('li');
}

echo PHtml::openTag('li');
if($model->isTrash) {
	echo PHtml::link(
		PHtml::encode('UnTrash'), 
		array('task/untrash', 'id'=>$data->id),
		array(
			'submit'=>array(
				'task/untrash',
				'id'=>$data->id,
			),
			'csrf' => true,
			'id'=>'task-untrash-menu-item-' . $data->id,
			'class'=>'task-untrash-menu-item',
		)
	);
}
else {
	echo PHtml::link(
		PHtml::encode('Trash'), 
		array('task/trash', 'id'=>$data->id),
		array(
			'submit'=>array(
				'task/trash',
				'id'=>$data->id,
			),
			'confirm'=>'Are you sure you want to trash this item?',
			'csrf' => true,
			'id'=>'task-trash-menu-item-' . $data->id,
			'class'=>'task-trash-menu-item',
		)
	);
}
echo PHtml::closeTag('li');

echo PHtml::closeTag('ul');
echo PHtml::closeTag('menu');
// end of toolbar

// list participants
echo PHtml::openTag('ol', array('class' => 'participants'));
foreach($data->participants as $user) {
	echo PHtml::openTag('li');	
	$this->widget('application.components.widgets.UserLink', array(
		'userModel' => $user,
	));
	echo PHtml::closeTag('li');
}
echo PHtml::closeTag('ol');

// end body

// close article
echo PHtml::closeTag('article');