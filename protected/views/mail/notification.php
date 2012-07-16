<? 
/**
 * View for individual email notifications
 * 
 * @param ActiveRecordLog $data model
 */

// calculate article class
$articleClass = "view";
$articleClass .= " email";

// start article
echo PHtml::openTag('article', array(
	'class' => 'email'
));

// start headers

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
	StringUtils::truncate(PHtml::encode($data->modelObject->emailAttribute), 80), 
	Yii::app()->request->hostInfo . Yii::app()->createUrl(
		strtolower($data->focalModel) . '/view', array('id'=>$data->focalModelId)
	)
);

echo PHtml::closeTag('p');

if($data->action == ActiveRecordLog::ACTION_UPDATED) {
	echo Phtml::openTag(p);
	echo 'Changed ';
	// if the referred to model was actually deleted then avoid the null pointer exception
	if(isset($data->modelObject)) {
		echo PHtml::openTag('span', array(
			'class' => 'email-model-attribute'
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
	echo Phtml::closeTag(p);
}

echo PHtml::closeTag('article');