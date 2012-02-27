
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
        <?php echo $form->label($model,'sweater_type'); ?>
        <?php echo $form->textField($model,'sweater_type',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'sweater_color'); ?>
        <?php echo $form->textField($model,'sweater_color',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'letter_color'); ?>
        <?php echo $form->textField($model,'letter_color',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'letter_thread_color'); ?>
        <?php echo $form->textField($model,'letter_thread_color',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'letters'); ?>
        <?php echo $form->textField($model,'letters',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'extra_small_count'); ?>
        <?php echo $form->textField($model,'extra_small_count',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'small_count'); ?>
        <?php echo $form->textField($model,'small_count',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'medium_count'); ?>
        <?php echo $form->textField($model,'medium_count',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'large_count'); ?>
        <?php echo $form->textField($model,'large_count',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'extra_large_count'); ?>
        <?php echo $form->textField($model,'extra_large_count',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'extra_extra_large_count'); ?>
        <?php echo $form->textField($model,'extra_extra_large_count',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'isPlaced'); ?>
        <?php echo $form->textField($model,'isPlaced'); ?>
    </div>

    <div class="field">
        <?php echo $form->label($model,'isDelivered'); ?>
        <?php echo $form->textField($model,'isDelivered'); ?>
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