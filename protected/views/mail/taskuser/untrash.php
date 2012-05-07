<?php 
/**
 * View for taskuser model untrash scenario
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

//Great news! [user] is now participating again on [taskName]..
//echo "Great news! " . PHtml::encode($user->fullName) . " is now participating again on " . PHtml::encode($data->task->name) . ".";

foreach($changedAttributes as $header)
{
	echo "Great news! " . PHtml::encode($user->fullName) . " is now participating again on " . PHtml::encode($data->task->name) . ".";
	
}

echo PHtml::closeTag('article');
?>