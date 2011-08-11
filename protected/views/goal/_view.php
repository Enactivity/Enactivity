<?php 
/**
 * View for individual goal models
 * 
 * @param Goal $data model
 */

// calculate article class
$articleClass = "view";
$articleClass .= " goal";
$articleClass .= " goal-" . $data->id;
$articleClass .= $data->isCompleted ? " completed" : " not-completed";
$articleClass .= $data->isTrash ? " trash" : " not-trash";

// start article
echo PHtml::openTag('article', array(
	'class' => $articleClass,		
));

// start headers

// goal name
echo PHtml::openTag('h1');
echo PHtml::link(
	PHtml::encode($data->name), 
	array('view', 'id'=>$data->id)
); 
echo PHtml::closeTag('h1');

// start body
echo PHtml::openTag('p'); 
echo PHtml::encode($data->tasksCount . " tasks");
echo PHtml::closeTag('p');
// end of body

// start footer
echo PHtml::openTag('footer');

//	goals toolbar
echo PHtml::openTag('div', array(
	'class' => 'menu'
));

$this->widget('zii.widgets.CMenu', array(
	'items'=>MenuDefinitions::goalMenu($data),
));
echo PHtml::closeTag('div');
echo PHtml::closeTag('footer');
//end of footer

// close article
echo PHtml::closeTag('article');