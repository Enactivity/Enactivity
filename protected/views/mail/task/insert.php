<?php 
/**
 * View for task model insert scenario
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

//Fantastic! [user] created [taskname] (that starts on [date])?
//echo "Fantastic! " . PHtml::encode($user->fullName) . " created " . PHtml::encode($changedAttributes['new']) . ".";

//foreach($changedAttributes as $header)
//{
//	echo "Fantastic! " . PHtml::encode($user->fullName) . " created " . PHtml::encode($header['new']) . ".";	
//}

echo "Fantastic! " . PHtml::encode($user->fullName) . " created " . PHtml::encode($data->name) . ".";	

echo PHtml::closeTag('article');
?>