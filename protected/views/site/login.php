<?
$this->pageTitle = 'Login';
?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section>
		<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
			'id'=>'login-form',
			'enableAjaxValidation'=>false,
		)); 
		?>
			<div class="field">
				<div class="formlabel"><?= $form->labelEx($model,'email'); ?></div>
				<div class="forminput"><?= $form->emailField($model,'email', 
					array(
						'placeholder'=>'@',
						'autofocus'=>'autofocus',
					)); ?></div>
				<div class="formerrors"><?= $form->error($model,'email'); ?></div>
			</div>
		
			<div class="field">
				<div class="formlabel"><?= $form->labelEx($model,'password'); ?></div>
				<div class="forminput"><?= $form->passwordField($model,'password', 
					array('placeholder'=>'*')); ?></div>
				<div class="formerrors"><?= $form->error($model,'password'); ?></div>
			</div>
		
			<div class="field buttons">
				<?= PHtml::submitButton('Login'); ?>
			</div>
			
			<div class="field">
				<div class="formlink"><p><?= PHtml::link('Forgot my password', array(
					'user/recoverpassword'
				));?></p></div>
			</div>
		
		<? $this->endWidget(); ?>
	</section>
</div>