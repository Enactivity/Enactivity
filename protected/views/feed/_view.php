<?php 
/**
 * View for individual feed models
 * 
 * @param ActiveRecordLog $data model
 */

// calculate article class
$articleClass = "view";
$articleClass .= " feed";
$articleClass .= " feed-" . $data->id;

// start article
echo PHtml::openTag('article', array(
	'class' => 'feed'
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// created date
echo PHtml::openTag('h2');
echo PHtml::openTag('date');
echo PHtml::encode(
	Yii::app()->dateformatter->formatDateTime($data->created, 'full', 'short')
);
echo PHtml::closeTag('date');
echo PHtml::closeTag('h2');

echo PHtml::openTag('h1');

// display <user> <action> <model> <attribute>
$this->widget('application.components.widgets.UserLink', array(
	'userModel' => $data->user,
)); 
echo ' ';
if($data->modelObject) {
	echo PHtml::encode(strtolower($data->modelObject->getScenarioLabel($data->action)));
}
else {
	echo 'deleted something';
}	
echo ' '; 
echo PHtml::link(
	StringUtils::truncate(PHtml::encode($data->modelObject->feedAttribute), 80), 
	array(strtolower($data->model) . '/view', 'id'=>$data->modelId)
);

echo PHtml::closeTag('h1');

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

if($data->action == ActiveRecordLog::ACTION_UPDATED) {
	echo 'Changed ';
	echo PHtml::encode($data->modelObject->getAttributeLabel($data->modelAttribute));
	echo ' from ';
	echo PHtml::openTag('strong');
	echo PHtml::encode($data->oldAttributeValue);
	echo PHtml::closeTag('strong');
	echo PHtml::encode(' to ');
	echo PHtml::openTag('strong');
	echo PHtml::encode($data->newAttributeValue);
	echo PHtml::closeTag('strong');
}

echo PHtml::closeTag('article');