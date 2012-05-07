<?php 
/**
 * View for group model update scenario
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

//display Hey there. Just letting you know <user> changed the group name from <oldname> to <newname>
//echo "Hey there. Just letting you know " . PHtml::encode($user->fullName) . " updated the name of your group to " . PHtml::encode($data->name) . ".";

foreach($changedAttributes as $header)
{
	echo "Hey there. Just letting you know " . PHtml::encode($user->fullName) . " updated the name of your group to " . PHtml::encode($data->name) . ".";
}

echo PHtml::closeTag('article');