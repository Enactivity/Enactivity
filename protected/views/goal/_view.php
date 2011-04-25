<?php 
/**
 * View for individual event models
 * 
 * @param Event $data model
 */

// start article
echo PHtml::openTag('article', array(
	'class' => 'view' 
		. ' goal'
		. ' goal-' . $data->id,		
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

// goal name
echo PHtml::openTag('h1');
echo PHtml::link(
	PHtml::encode($data->name), 
	array('view', 'id'=>$data->id)
); 
echo PHtml::closeTag('h1');

echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');
// end of header

// start body
echo PHtml::openTag('p'); 
echo PHtml::encode($data->tasksCount . " tasks");
echo PHtml::closeTag('p');
// end of body

// start footer
echo PHtml::openTag('footer');

//	goals toolbar
echo PHtml::openTag('menu');

$this->widget('zii.widgets.CMenu', array(
	'items'=>MenuDefinitions::goalMenu($data),
));
echo PHtml::closeTag('menu');
echo PHtml::closeTag('footer');
//end of footer

// close article
echo PHtml::closeTag('article');