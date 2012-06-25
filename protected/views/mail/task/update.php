<?php 
/**
 * View for task model update scenario
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

//Hey there! Just letting you know, [user] changed the start date for [taskName] from [oldStartDate] to [newStartDate].
//echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " changed the start date for [taskName] from [oldStartDate] to [newStartDate].";

//Hey there! Just letting you know, [user] changed the task name from [oldTaskName] to [newTaskName].
//echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " changed the task name from " . PHtml::encode($changedAttributes['old']) . " to " . PHtml::encode($changedAttributes['new']) . ".";

foreach($changedAttributes as $header)
{
	if(!isset($header['old'])
	{
		echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " updated " . PHtml::encode($data->name) . " with " . PHtml::encode($header['new']) . ".";
	}
	else
	{
		echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " updated " . PHtml::encode($data->name) . " from ". PHtml::encode($header['old']) . " to " . PHtml::encode($header['new']) . ".";
	}
}

echo PHtml::closeTag('article');
?>