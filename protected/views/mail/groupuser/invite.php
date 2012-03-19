<?php 
/**
 * View for groupuser model invite scenario
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

//Exciting news! [user] invited the following emails [list of emails] to [groupName].
echo "Exiting news! " . PHtml::encode($user->fullName) . "invited the following emails [list of emails] to the " . PHtml::encode($data->name) . ".";

echo PHtml::closeTag('article');