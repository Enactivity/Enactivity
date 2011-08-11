<?php 
/**
 * @uses $data User model
 */

// start article
echo PHtml::openTag('article', array(
	'id' => "user-" . $data->id,
	'class' => 'user',
));

$this->widget('application.components.widgets.UserLink', array(
			'userModel' => $data,
));

echo PHtml::closeTag('article');
?>