
<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="field">
        <?= $form->label($model,'id'); ?>
        <?= $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?= $form->label($model,'userId'); ?>
        <?= $form->textField($model,'userId',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?= $form->label($model,'productType'); ?>
        <?= $form->textField($model,'productType',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?= $form->label($model,'purchased'); ?>
        <?= $form->textField($model,'purchased'); ?>
    </div>

    <div class="field">
        <?= $form->label($model,'delivered'); ?>
        <?= $form->textField($model,'delivered'); ?>
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