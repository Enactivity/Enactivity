<?
$this->pageTitle = 'Update Password';
$this->menu = MenuDefinitions::settings();
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section>
		<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
			'id'=>'update-password-form',
			'enableAjaxValidation'=>false,
		)); ?>
		
			<?= $form->errorSummary($model); ?>
		
			<div class="field">
				<div class="formlabel"><?= $form->labelEx($model, 'password'); ?></div>
				<div class="forminput"><?= $form->passwordField($model, 'password', 
					array(
						'maxlength'=>User::PASSWORD_MAX_LENGTH,
						'autofocus'=>'autofocus',
					)); ?></div>
				<div class="formerrors"><?= $form->error($model, 'password'); ?></div>
			</div>
			
			<div class="field">
				<div class="formlabel"><?= $form->labelEx($model, 'confirmPassword'); ?></div>
				<div class="forminput"><?= $form->passwordField($model, 'confirmPassword',
					array('maxlength'=>User::PASSWORD_MAX_LENGTH)); ?></div>
				<div class="formerrors"><?= $form->error($model, 'confirmPassword'); ?></div>
			</div>
		
			<div class="field buttons">
				<?= PHtml::submitButton($model->isNewRecord ? 'Create' : 'Update'); ?>
			</div>
		
		<? $this->endWidget(); ?>
	</section>
</div>