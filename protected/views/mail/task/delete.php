<?php 
/**
 * View for task model delete scenario
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

//Aww. [user] deleted [taskname] that [taskCount] out of [totalTaskCount] people completed in [group name].
echo "Aww. " . PHtml::encode($user->fullName) . "deleted " . PHtml::encode($newAttributes[name]) . " in " . PHtml::encode($data->name) . ".";

echo PHtml::closeTag('article');
?>