<?php 
/**
 * View for taskuser model uncomplete scenario
 * 
 */

// calculate article class
$articleClass = "view";
$articleClass .= " email";

// start article
echo PHtml::openTag('article', array(
	'class' => 'email'
));

// created date
echo PHtml::openTag('p');
echo PHtml::openTag('strong');
echo PHtml::openTag('time');
echo PHtml::encode(
	//FIXME: use actual event time
	Yii::app()->format->formatDateTime(time())
);
echo PHtml::closeTag('time');
echo PHtml::closeTag('strong');
echo PHtml::closeTag('p');
echo PHtml::openTag('p');

//Hey there. [user] is now again working on [taskName] along with [taskCount] other people.
echo "Hey there. " . PHtml::encode($user->fullName) . " is now again working on " . PHtml::link(PHtml::encode($data->task->name), PHtml::taskURL($data->task)) . ".";

echo PHtml::closeTag('article');
?>