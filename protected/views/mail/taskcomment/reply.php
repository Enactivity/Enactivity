<?php 
/**
 * View for taskcomment model reply scenario
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

//Just a heads up, [user] replied to a comment for [taskName].
echo "Just a heads up, " . PHtml::encode($user->fullName) . " replied to a comment for " . PHtml::encode($newAttributes[name]) . ".";

echo PHtml::closeTag('article');
?>