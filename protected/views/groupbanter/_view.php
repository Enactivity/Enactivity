<?php 
/**
 * View for individual event models
 * 
 * @param Event $data model
 */

// start article
echo PHtml::openTag('article', array(
	'class' => 'view',		
));

//banters with parents have no headers
if($data->parentId === null) {
	// start headers
	echo PHtml::openTag('header');
	echo PHtml::openTag('hgroup');
	
	echo PHtml::openTag('h1');
	echo PHtml::link(StringUtils::truncate(PHtml::encode($data->content), 80), 
		array('groupbanter/view', 'id'=>$data->id));
	echo PHtml::closeTag('h1');	
	
	echo PHtml::closeTag('h1');

	// close headers
	echo PHtml::closeTag('hgroup');
	echo PHtml::closeTag('header');
} 
//if it has a parent, it's a reply, so show it all
else {
	echo  Yii::app()->format->formatStyledText($data->content);
}

// start footer
echo PHtml::openTag('footer');

// show details
echo PHtml::openTag('ul');

// show creator
echo PHtml::openTag('li');
$this->widget('application.components.widgets.UserLink', array(
	'userModel' => $data->creator,
)); 
echo PHtml::closeTag('li');

// show created date
echo PHtml::openTag('li');
echo PHtml::openTag('date');
echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->created, 
		'full', 'short'));
echo PHtml::closeTag('date');
echo PHtml::closeTag('li');

// show modified date
echo PHtml::openTag('li');
if($data->modified != $data->created) {
	echo PHtml::encode($data->getAttributeLabel('modified'));
	echo ' ';
	echo PHtml::openTag('date');
	echo PHtml::encode(Yii::app()->dateformatter->formatDateTime($data->modified, 
		'full', 'short'));
	echo PHtml::closeTag('date');
}
echo PHtml::closeTag('li');

echo PHtml::closeTag('ul');

// show update & delete menu if user is author
echo PHtml::openTag('div', array(
	'class' => 'menu'
));
if($data->creatorId == Yii::app()->user->id) {
	$this->widget('zii.widgets.CMenu', array(
		'items'=>array(
			array(
				'label'=>'Update', 
				'url'=>array('groupbanter/update', 'id' => $data->id),
				'linkOptions'=>array('class'=>'update_item'), 
			),
			array(
				'label'=>'Delete',
				'url'=>'#',
				'linkOptions'=>array(
					'class'=>'delete_item',
					'csrf' => true,
					'submit' => array(
						'groupbanter/delete',
						'id'=>$data->id,
					),
				),
			),
		)
	));
}
echo PHtml::closeTag('div');

echo PHtml::closeTag('footer');
echo PHtml::closeTag('article');