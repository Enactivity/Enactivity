<?php 
/**
 * View for taskcomment model insert scenario
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

//Yo! [user] just left a comment for [taskName]
echo "Yo! " . PHtml::encode($user->fullName) . " just left a comment for " . PHtml::link(PHtml::encode($data->getModelObject()->name), PHtml::taskURL($data->getModelObject())) . "." ;

echo PHtml::closeTag('article');
?>