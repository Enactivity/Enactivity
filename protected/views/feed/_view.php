<?php 
// start article
echo PHtml::openTag('article', array(
	'class' => 'view'
));

// start definition list
echo PHtml::openTag('dl');
echo PHtml::openTag('dt');

$this->widget('ext.widgets.UserLink', array(
	'userModel' => $data->user,
)); 
echo ' ';
echo strtolower($data->action);
echo ' '; 
$description = isset($data->modelObject) ? $data->modelObject->feedAttribute : $data->model;
echo CHtml::link(StringUtils::truncate(PHtml::encode($description), 80), array(strtolower($data->model) . '/view', 'id'=>$data->modelId));

echo PHtml::closeTag('dt');

echo PHtml::openTag('dd');
echo PHtml::openTag('span');

echo PHtml::encode(
	Yii::app()->dateformatter->formatDateTime($data->created, 'full', 'short')
);

echo PHtml::closeTag('span');
echo PHtml::closeTag('dd');

echo PHtml::closeTag('dl');
echo PHtml::closeTag('article');