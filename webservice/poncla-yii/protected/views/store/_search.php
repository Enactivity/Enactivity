
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
        <?php echo $form->label($model,'productType'); ?>
        <?php echo $form->textField($model,'productType',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'purchased'); ?>
        <?php echo $form->textField($model,'purchased'); ?>
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