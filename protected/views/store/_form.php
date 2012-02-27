
<div class="form">

<?php $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
    'id'=>'cart-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="field">
        <?php echo $form->labelEx($model,'sweater_type'); ?>
        <?php echo $form->dropDownList($model,'sweater_type', CartItem::getSweaterChoices(), array()); ?>
        <?php echo $form->error($model,'sweater_type'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'sweater_color'); ?>
        <?php echo $form->dropDownList($model,'sweater_color', CartItem::getSweaterColors(), array()); ?>
        <?php echo $form->error($model,'sweater_color'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'letter_color'); ?>
        <?php echo $form->dropDownList($model,'letter_color', CartItem::getLetterColors(), array()); ?>
        <?php echo $form->error($model,'letter_color'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'letter_thread_color'); ?>
        <?php echo $form->dropDownList($model,'letter_thread_color', CartItem::getLetterThreadColors(), array()); ?>
        <?php echo $form->error($model,'letter_thread_color'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'letters'); ?>
        <?php echo $form->textField($model,'letters',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'letters'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'extra_small_count'); ?>
        <?php echo $form->numberField($model,'extra_small_count',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'extra_small_count'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'small_count'); ?>
        <?php echo $form->numberField($model,'small_count',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'small_count'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'medium_count'); ?>
        <?php echo $form->numberField($model,'medium_count',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'medium_count'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'large_count'); ?>
        <?php echo $form->numberField($model,'large_count',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'large_count'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'extra_large_count'); ?>
        <?php echo $form->numberField($model,'extra_large_count',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'extra_large_count'); ?>
    </div>

    <div class="field">
        <?php echo $form->labelEx($model,'extra_extra_large_count'); ?>
        <?php echo $form->numberField($model,'extra_extra_large_count',array('size'=>11,'min'=>0)); ?>
        <?php echo $form->error($model,'extra_extra_large_count'); ?>
    </div>

    <div class="field buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add to Cart' : 'Update Order'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->