
<div class="form">

<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
    'id'=>'cart-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?= $form->errorSummary($model); ?>

    <div class="field">
        <?= $form->labelEx($model,'quantity'); ?>
        <?= $form->numberField($model,'quantity',array('size'=>11,'min'=>0)); ?>
        <?= $form->error($model,'quantity'); ?>
    </div>
    
    <? if(Yii::app()->user->isAdmin) :?>
    <div class="field">
        <?= $form->labelEx($model,'isDelivered'); ?>
        <?= $form->checkBox($model,'isDelivered',array()); ?>
        <?= $form->error($model,'isDelivered'); ?>
    </div>
    <? endif; ?>

    <div class="field buttons">
        <?= CHtml::submitButton($model->isNewRecord ? 'Add to Cart' : 'Update Order'); ?>
    </div>

<? $this->endWidget(); ?>

</div><!-- form -->