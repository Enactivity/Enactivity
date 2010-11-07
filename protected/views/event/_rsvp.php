<?php 
/**
 * Widget for user to RSVPs to an event
 * @param $eventuser
 */
?>

<!-- RSVP here -->
<div class="form">
<?php
$form=$this->beginWidget('CActiveForm', array(
	    'id'=>'event-user-rsvp-form',
	    'enableAjaxValidation'=>false,
	));  
if($eventuser->status != EventUser::STATUS_ATTENDING):
	//can't use constants for button names b/c rendering removes spaces
    echo CHtml::submitButton('I\'m Attending', array('name'=>'Attending_Button'));
endif;

if($eventuser->status != EventUser::STATUS_NOT_ATTENDING):
	echo CHtml::submitButton('I\'m Not Attending', array('name'=>'Not_Attending_Button'));
endif;
$this->endWidget();
?>
</div>
<!-- form -->