<?php 
/**
 * View for taskuser model complete scenario
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

//Great! [user] just completed [taskName]. So far, [taskCount] out of [totalTaskCount] people also completed the task. note: for the future, want to indicate level of completion.
echo "Great! " . PHtml::encode($user->fullName) . " just completed " . PHtml::encode($newAttributes[name]) . ".";

echo PHtml::closeTag('article');
?>