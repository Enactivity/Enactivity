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

foreach($changedAttributes as $attributeName => $attributeArray)
{
	// user updating a date and time originally not null
	if(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] != '')
	{
		if ($data->metadata->columns[$attributeName]->dbType == 'datetime')
		{
			$attributeArray['old'] = Yii::app()->format->formatDateTime(strtotime($attributeArray['old']));
			$attributeArray['new'] = Yii::app()->format->formatDateTime(strtotime($attributeArray['new'])); 
		}
		echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " updated " . PHtml::encode($data->name) . " from ". PHtml::encode($attributeArray['old']) . " to " . PHtml::encode($attributeArray['new']) . ".";
	}
	// user removing a set date and time
	else if(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] == '')
	{
		if($attributeArray['old']->metadata->columns[$attributeName]->dbType == 'datetime')
		{
			$attributeArray['old'] = Yii::app()->format->formatDateTime(strtotime($attributeArray['old']));
		}
		echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " removed the date and time for " . PHtml::encode($data->name) . " which used to start at ". PHtml::encode($attributeArray['old']) . ".";	
	}
	// user updating a date and time originally null
	else
	{
		if($attributeArray['new']->metadata->columns[$attributeName]->dbType == 'datetime')
		{
			$attributeArray['new'] = Yii::app()->format->formatDateTime(strtotime($attributeArray['new'])); 
		}
		echo "Hey there! Just letting you know, " . PHtml::encode($user->fullName) . " added a date and time for " . PHtml::encode($data->name) . " which now starts at " . PHtml::encode($attributeArray['new']) . ".";
	}
}

echo PHtml::closeTag('article');
?>