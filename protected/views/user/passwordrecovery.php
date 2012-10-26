<?
$this->pageTitle = 'Recover Password';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
	<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
		'id'=>'password-recovery-form',
		'enableAjaxValidation'=>false,
	)); 
	?>
		<div class="field">
			<div class="formlabel"><?= $form->labelEx($model,'email'); ?></div>
			<div class="forminput"><?= $form->textField($model,'email',
				 array('placeholder'=>'@')); ?></div>
			<div class="formerrors"><?= $form->error($model,'email'); ?></div>
		</div>
	
		<div class="field buttons">
			<?= PHtml::submitButton('Send me a new password'); ?>
		</div>
		
	<? $this->endWidget(); ?>
</section>