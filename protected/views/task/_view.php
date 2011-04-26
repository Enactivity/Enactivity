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

// event name
echo PHtml::openTag('h1');
echo PHtml::link(
	PHtml::encode($data->name), 
	array('task/view', 'id'=>$data->id)
); 
echo PHtml::closeTag('h1');

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

// body
echo PHtml::openTag('dl');

// event date
if(isset($data->starts)) {
	echo PHtml::openTag('dt');
	echo PHtml::encode($data->getAttributeLabel('starts'));
	echo PHtml::closeTag('dt');
	
	echo PHtml::openTag('dd');
	echo PHtml::openTag('time');
	echo PHtml::encode($data->starts);
	echo PHtml::closeTag('time');
	echo PHtml::closeTag('dd');
}

if(isset($data->ends)) {
	echo PHtml::openTag('dt');
	echo PHtml::encode($data->getAttributeLabel('ends'));
	echo PHtml::closeTag('dt');
	
	echo PHtml::openTag('dd');
	echo PHtml::openTag('time');
	echo PHtml::encode($data->ends);
	echo PHtml::closeTag('time');
	echo PHtml::closeTag('dd');
}

// user count
echo PHtml::openTag('dt');
echo PHtml::encode($data->getAttributeLabel('userTasksCount'));
echo PHtml::closeTag('dt');

echo PHtml::openTag('dd');
echo PHtml::encode($data->userTasksCount);
echo PHtml::closeTag('dd');

// users completed count
echo PHtml::openTag('dt');
echo PHtml::encode($data->getAttributeLabel('userTasksCompletedCount'));
echo PHtml::closeTag('dt');

echo PHtml::openTag('dd');
echo PHtml::encode($data->userTasksCompletedCount);
echo PHtml::closeTag('dd');


echo PHtml::closeTag('dl');
// end body

// start footer
echo PHtml::openTag('footer');

//	tasks toolbar
echo PHtml::openTag('menu');

$this->widget('zii.widgets.CMenu', array(
	'items'=>MenuDefinitions::taskMenu($data),
));
echo PHtml::closeTag('menu');
// end of toolbar

echo PHtml::closeTag('footer');
// end of footer

// close article
echo PHtml::closeTag('article');