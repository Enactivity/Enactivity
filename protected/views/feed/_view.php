<?php 
/**
 * View for individual feed models
 * 
 * @uses ActiveRecordLog $data model
 */

// calculate article class
$articleClass[] = "view";
$articleClass[] = "story";
$articleClass[] = "feed";
$articleClass[] = "feed-" . PHtml::encode($data->id);

// start article
echo PHtml::openTag('article', array(
	'id' => "task-" . PHtml::encode($data->id),
	'class' => implode(" ", $articleClass),
));

// start headers

// info
echo PHtml::openTag('div', array('class'=>'story-info'));
echo PHtml::openTag('time', array('class'=>'created'));
echo PHtml::link(
	PHtml::encode(Yii::app()->format->formatDateTime(strtotime($data->created))), 
	array('feed/view', 'id'=>$data->id)
);
echo PHtml::closeTag('time');
echo PHtml::closeTag('div');

echo PHtml::openTag('h1', array('class'=>'story-title'));

// display <user> <action> <model> <attribute>
$this->widget('application.components.widgets.UserLink', array(
	'userModel' => $data->user,
)); 
echo ' ';
if(isset($data->modelObject)) {
	echo PHtml::encode(strtolower($data->modelObject->getScenarioLabel($data->action)));
	echo ' ';
	echo PHtml::link(
		StringUtils::truncate(PHtml::encode($data->modelObject->feedAttribute), 80),
		array(strtolower($data->focalModel) . '/view', 'id'=>$data->focalModelId)
	);
}
else {
	echo 'deleted something';
}	

echo PHtml::closeTag('h1');

if($data->action == ActiveRecordLog::ACTION_UPDATED) {
	echo Phtml::openTag('p');
	echo 'Changed ';
	// if the referred to model was actually deleted then avoid the null pointer exception
	if(isset($data->modelObject)) {
		echo PHtml::openTag('span', array(
			'class' => 'feed-model-attribute'
		));
		echo PHtml::encode($data->modelObject->getAttributeLabel($data->modelAttribute));
		echo PHtml::closeTag('span');
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
		echo Yii::app()->format->formatDateTime(strtotime($data->oldAttributeValue));
	}
	else {
		echo PHtml::encode($data->oldAttributeValue);
	}
	echo PHtml::closeTag('strong');
	echo PHtml::encode(' to ');
	echo PHtml::openTag('strong');
 	if(is_null($data->newAttributeValue)) {
		echo 'nothing';
	}
	elseif($data->modelObject->metadata->columns[$data->modelAttribute]->dbType == 'datetime') {
		echo Yii::app()->format->formatDateTime(strtotime($data->newAttributeValue));
	}
	else {
		echo PHtml::encode($data->newAttributeValue);
	}
	echo PHtml::closeTag('strong');
	echo Phtml::closeTag('p');
}

echo PHtml::closeTag('article');