<?php 
/**
 * View for individual group models
 * 
 * @uses Group $data model
 */

// calculate article class
$articleClass[] = "view";
$articleClass[] = "story";
$articleClass[] = "group";
$articleClass[] = "group-" . PHtml::encode($data->id);

// start article
echo PHtml::openTag('article', array(
	'id' => "group-" . PHtml::encode($data->id),
	'class' => implode(" ", $articleClass),
));

// start headers

// display <user> <action> <model> 
echo PHtml::openTag('h1', array('class'=>'story-title'));

echo PHtml::link(PHtml::encode($data->name), 
	array('view', 'slug'=>$data->slug)); 

echo PHtml::closeTag('h1');

// body
// summarized description
$this->widget('application.components.widgets.TextSummary', array(
	'text' => $data->groupProfile->description,
	'url' => array('group/view', 'id'=>$data->id)
));
// end body

echo PHtml::openTag('ol', array('class' => 'userlist'));
foreach($data->groupUsersActive as $groupMember) {
	$spanClass = "view";
	$spanClass .= " group-member";
	$spanClass .= " group-member-" . $groupMember->id;
	
	echo PHtml::openTag('li');
	echo PHtml::openTag('span', array(
	'class' => $spanClass,		
	));
	$this->widget('application.components.widgets.UserLink', array(
		'userModel' => $groupMember->user,
	));
	echo PHtml::closeTag('span');
	echo PHtml::closeTag('li');
}
echo PHtml::closeTag('ol');

echo PHtml::closeTag('article');
