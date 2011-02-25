<?php 
// TODO: PHPDocs file info

// start article
echo PHtml::openTag('article', array(
	'class' => 'view',		
));

// start headers
echo PHtml::openTag('header');
echo PHtml::openTag('hgroup');

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

// close headers
echo PHtml::closeTag('hgroup');
echo PHtml::closeTag('header');

// body
// summarized description
echo StringUtils::truncate(
	Yii::app()->format->formatStyledText($data->description),
	250);
// add a read more link
if(strlen($data->description) > 250) {
	echo ' ';
	echo PHtml::link('Read more.', 
		array('view', 'id'=>$data->id)
	);
}
// end body

// start footer
echo PHtml::openTag('footer');

// RSVP menu
echo PHtml::openTag('menu');
$this->renderPartial('_rsvp', array(
	'event'=>$data,
	'eventuser'=>$data->getRSVP(Yii::app()->user->id),
)); 
echo PHtml::closeTag('menu');
echo PHtml::closeTag('footer');

// close article
echo PHtml::closeTag('article');