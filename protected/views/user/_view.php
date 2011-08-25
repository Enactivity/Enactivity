<?php 
/**
 * @uses $data User model
 */

// calculate article class
$articleClass[] = "view";
$articleClass[] = "story";
$articleClass[] = "user";
$articleClass[] = "user-" . PHtml::encode($data->id);

// start article
echo PHtml::openTag('article', array(
	'id' => "user-" . PHtml::encode($data->id),
	'class' => implode(" ", $articleClass),
));

$this->widget('application.components.widgets.UserLink', array(
			'userModel' => $data,
));

echo PHtml::closeTag('article');
?>