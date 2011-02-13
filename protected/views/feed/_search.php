<div class="wide form"> 

<?php $form=$this->beginWidget('CActiveForm', array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
)); ?>

    <div class="row"> 
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'groupId'); ?>
        <?php echo $form->textField($model,'groupId'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'model'); ?>
        <?php echo $form->textField($model,'model',array('size'=>45,'maxlength'=>45)); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'modelId'); ?>
        <?php echo $form->textField($model,'modelId'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'action'); ?>
        <?php echo $form->textField($model,'action',array('size'=>20,'maxlength'=>20)); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'modelAttribute'); ?>
        <?php echo $form->textField($model,'modelAttribute',array('size'=>45,'maxlength'=>45)); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'userId'); ?>
        <?php echo $form->textField($model,'userId'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'created'); ?>
        <?php echo $form->textField($model,'created'); ?>
    </div> 

    <div class="row"> 
        <?php echo $form->label($model,'modified'); ?>
        <?php echo $form->textField($model,'modified'); ?>
    </div> 

    <div class="row buttons"> 
        <?php echo CHtml::submitButton('Search'); ?>
    </div> 

<?php $this->endWidget(); ?>

</div><!-- search-form -->