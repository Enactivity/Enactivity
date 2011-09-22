<?php 
/**
 * @uses $data User model
 */

// calculate article class

// start article
echo PHtml::openTag('article', array(
	'id' => "user-" . PHtml::encode($data->id),
	'class' => "view story " . PHtml::taskUserClass($data),
));

$this->widget('application.components.widgets.UserLink', array(
	'userModel' => $data->user,
));

echo PHtml::closeTag('article');
?>