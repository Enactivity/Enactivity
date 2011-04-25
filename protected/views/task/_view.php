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
echo PHtml::encode($data->name);
echo PHtml::closeTag('h1');

// event date
if(isset($data->starts) 
|| $data->ends) {
	echo PHtml::openTag('h2');
	echo PHtml::openTag('time');
	echo PHtml::encode($data->starts . "-" . $data->ends);
	echo PHtml::closeTag('time');
	echo PHtml::closeTag('h2');
}

// event attendee count
echo PHtml::openTag('h2');
echo PHtml::openTag('span');
echo $data->userTasksCount;
echo $data->userTasksCount == 1 
	? ' person signed up' 
	: ' people signed up';
echo PHtml::closeTag('span');
echo PHtml::closeTag('h2');

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

// body

// end body

// start footer
echo PHtml::openTag('footer');
// FIXME: needs a menu
echo PHtml::link('menu to go here');
echo PHtml::closeTag('footer');

// close article
echo PHtml::closeTag('article');