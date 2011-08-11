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

// start headers

// event name
echo PHtml::openTag('h1');
echo PHtml::link(PHtml::encode($data->name), 
	array('view', 'id'=>$data->id)
); 
echo PHtml::closeTag('h1');

// event date
echo PHtml::openTag('h2');
echo PHtml::openTag('time');
echo PHtml::encode($data->datesAsSentence);
echo PHtml::closeTag('time');
echo PHtml::closeTag('h2');

// event attendee count
echo PHtml::openTag('h2');
echo PHtml::openTag('span');
echo $data->eventUsersAttendingCount;
echo $data->eventUsersAttendingCount == 1 
	? ' person attending' 
	: ' people attending';
echo PHtml::closeTag('span');
echo PHtml::closeTag('h2');

// body
// summarized description
$this->widget('application.components.widgets.TextSummary', array(
	'text' => $data->description,
	'url' => array('view', 'id'=>$data->id),
));
// end body

// start footer
echo PHtml::openTag('footer');

// RSVP menu
echo PHtml::openTag('div', array(
	'class'=>'menu'
));
$this->renderPartial('_rsvp', array(
	'event'=>$data,
	'eventuser'=>$data->getRSVP(Yii::app()->user->id),
)); 
echo PHtml::closeTag('div');
echo PHtml::closeTag('footer');

// close article
echo PHtml::closeTag('article');