
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="field">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'userId'); ?>
        <?php echo $form->textField($model,'userId',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'sweaterType'); ?>
        <?php echo $form->textField($model,'sweaterType',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'sweaterColor'); ?>
        <?php echo $form->textField($model,'sweaterColor',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'letterColor'); ?>
        <?php echo $form->textField($model,'letterColor',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'letterThreadColor'); ?>
        <?php echo $form->textField($model,'letterThreadColor',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'letters'); ?>
        <?php echo $form->textField($model,'letters',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'extraSmallCount'); ?>
        <?php echo $form->textField($model,'extraSmallCount',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'smallCount'); ?>
        <?php echo $form->textField($model,'smallCount',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'mediumCount'); ?>
        <?php echo $form->textField($model,'mediumCount',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'largeCount'); ?>
        <?php echo $form->textField($model,'largeCount',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'extraLargeCount'); ?>
        <?php echo $form->textField($model,'extraLargeCount',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'extraExtraLargeCount'); ?>
        <?php echo $form->textField($model,'extraExtraLargeCount',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'placed'); ?>
        <?php echo $form->textField($model,'placed'); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'delivered'); ?>
        <?php echo $form->textField($model,'delivered'); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'created'); ?>
        <?php echo $form->textField($model,'created'); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'modified'); ?>
        <?php echo $form->textField($model,'modified'); ?>
    </div>

    <div class="field buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->