
<div class="form">

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
    'id'=>'cart-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="field">
        <?php echo $form->labelEx($model,'sweaterType'); ?>
        <?php echo $form->dropDownList($model,'sweaterType', CartItem::getSweaterChoices(), array()); ?>
        <?php echo $form->error($model,'sweaterType'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'sweaterColor'); ?>
        <?php echo $form->dropDownList($model,'sweaterColor', CartItem::getSweaterColors(), array()); ?>
        <?php echo $form->error($model,'sweaterColor'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'letterColor'); ?>
        <?php echo $form->dropDownList($model,'letterColor', CartItem::getLetterColors(), array()); ?>
        <?php echo $form->error($model,'letterColor'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'letterThreadColor'); ?>
        <?php echo $form->dropDownList($model,'letterThreadColor', CartItem::getLetterThreadColors(), array()); ?>
        <?php echo $form->error($model,'letterThreadColor'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'letters'); ?>
        <?php echo $form->textField($model,'letters',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'letters'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'extraSmallCount'); ?>
        <?php echo $form->numberField($model,'extraSmallCount',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'extraSmallCount'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'smallCount'); ?>
        <?php echo $form->numberField($model,'smallCount',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'smallCount'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'mediumCount'); ?>
        <?php echo $form->numberField($model,'mediumCount',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'mediumCount'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'largeCount'); ?>
        <?php echo $form->numberField($model,'largeCount',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'largeCount'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'extraLargeCount'); ?>
        <?php echo $form->numberField($model,'extraLargeCount',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'extraLargeCount'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'extraExtraLargeCount'); ?>
        <?php echo $form->numberField($model,'extraExtraLargeCount',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'extraExtraLargeCount'); ?>
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