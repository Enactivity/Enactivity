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
	Yii::app()->format->formatDateTime(strtotime($data->created))
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
	array(strtolower($data->focalModel) . '/view', 'id'=>$data->focalModelId)
);

echo PHtml::closeTag('h1');

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

if($data->action == ActiveRecordLog::ACTION_UPDATED) {
	echo Phtml::openTag(p);
	echo 'Changed ';
	// if the referred to model was actually deleted then avoid the null pointer exception
	if(isset($data->modelObject)) {
		echo PHtml::encode($data->modelObject->getAttributeLabel($data->modelAttribute));
	}
	else {
		echo PHtml::encode($data->modelAttribute);
	}
	echo ' from ';
	echo PHtml::openTag('strong');
	if(is_null($data->oldAttributeValue)) {
		echo 'nothing';
	}
	elseif($data->modelObject->metadata->columns[$data->modelAttribute]->dbType == 'datetime') {
		echo Yii::app()->format->formatDateTime(strtotime($data->newAttributeValue));
	}
	else {
		echo PHtml::encode($data->oldAttributeValue);
	}
	echo PHtml::closeTag('strong');
	echo PHtml::encode(' to ');
	echo PHtml::openTag('strong');
	$new = isset($data->newAttributeValue) ? $data->newAttributeValue : 'nothing';
	echo PHtml::encode($new);
	echo PHtml::closeTag('strong');
	echo Phtml::closeTag(p);
}

echo PHtml::closeTag('article');