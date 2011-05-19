<?php 
/**
 * View for individual feed models
 * 
 * @param ActiveRecordLog $data model
 */

// start article
echo PHtml::openTag('article', array(
	'class' => 'view feed'
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// show created date
echo PHtml::openTag('h2');
echo PHtml::openTag('date');
echo PHtml::encode(
	Yii::app()->dateformatter->formatDateTime($data->created, 'full', 'short')
);
echo PHtml::closeTag('date');
echo PHtml::closeTag('h2');

// display <user> <action> <model> <attribute>
echo PHtml::openTag('h1');

$this->widget('ext.widgets.UserLink', array(
	'userModel' => $data->user,
)); 
echo ' ';
if($data->modelObject) {
	echo PHtml::encode(strtolower($data->modelObject->getScenarioLabel($data->action)));
}

if($data->action == 'update') {
	echo ' ';
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

echo PHtml::closeTag('h1');

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

echo PHtml::closeTag('article');