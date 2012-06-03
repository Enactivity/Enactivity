
<div class="form">

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
    'id'=>'cart-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="field">
        <?php echo $form->labelEx($model,'quantity'); ?>
        <?php echo $form->numberField($model,'quantity',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'quantity'); ?>
    </div>
    
    <?php if(Yii::app()->user->isAdmin) :?>
    <div class="field">
        <?php echo $form->labelEx($model,'isDelivered'); ?>
        <?php echo $form->checkBox($model,'isDelivered',array()); ?>
        <?php echo $form->error($model,'isDelivered'); ?>
    </div>
    <?php endif; ?>

    <div class="field buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add to Cart' : 'Update Order'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->