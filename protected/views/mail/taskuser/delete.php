<?php 
/**
 * View for taskuser model delete scenario
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

//Oh No! [user] was removed from [taskName].
echo "Oh No! " . PHtml::encode($user->fullName) . " was removed from " . PHtml::encode($newAttributes[name]) . ".";

echo PHtml::closeTag('article');
?>