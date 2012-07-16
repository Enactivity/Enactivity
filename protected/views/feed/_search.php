<div class="wide form"> 

<? $form=$this->beginWidget('CActiveForm', array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
)); ?>

    <div class="field"> 
        <?= $form->label($model,'id'); ?>
        <?= $form->textField($model,'id'); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'groupId'); ?>
        <?= $form->textField($model,'groupId'); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'model'); ?>
        <?= $form->textField($model,'model',array('size'=>45,'maxlength'=>45)); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'modelId'); ?>
        <?= $form->textField($model,'modelId'); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'action'); ?>
        <?= $form->textField($model,'action',array('size'=>20,'maxlength'=>20)); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'modelAttribute'); ?>
        <?= $form->textField($model,'modelAttribute',array('size'=>45,'maxlength'=>45)); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'userId'); ?>
        <?= $form->textField($model,'userId'); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'created'); ?>
        <?= $form->textField($model,'created'); ?>
    </div> 

    <div class="field"> 
        <?= $form->label($model,'modified'); ?>
        <?= $form->textField($model,'modified'); ?>
    </div> 

    <div class="field buttons"> 
        <?= CHtml::submitButton('Search'); ?>
    </div> 

<? $this->endWidget(); ?>

</div><!-- search-form -->