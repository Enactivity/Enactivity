<?php 
/**
 * Widget for user to RSVPs to an event
 * @param $eventuser
 */

// start form
$form = $this->beginWidget('ext.widgets.ActiveForm', 
	array(
	    'enableAjaxValidation' => false,
		'htmlOptions' => array(
			'class' => 'rsvp'
		),
	));
	
echo $form->hiddenField($event, 'id');

echo PHtml::openTag('li');
if($eventuser->status == EventUser::STATUS_ATTENDING) {
	//can't use constants for button names b/c rendering removes spaces
    echo PHtml::submitButton('You are attending', 
    	array(
    		'name'=>'Attending_Button', 
    		'disabled'=>'disabled', 
    		'class'=>'disabled'
    	)
    );
}
else {
	echo PHtml::submitButton('I\'m attending', 
		array('name'=>'Attending_Button'));
}
echo PHtml::closeTag('li');


echo PHtml::openTag('li');
if($eventuser->status == EventUser::STATUS_NOT_ATTENDING) {
	echo PHtml::submitButton('You are not attending', 
		array(
			'name'=>'Not_Attending_Button', 
			'disabled'=>'disabled', 
			'class'=>'disabled'
		)
	);
}
else {
	echo PHtml::submitButton('I\'m not attending', 
		array('name'=>'Not_Attending_Button'));
}
echo PHtml::closeTag('li');
$this->endWidget();
// end of rsvp form