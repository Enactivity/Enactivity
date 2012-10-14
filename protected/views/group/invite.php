<? 
$this->pageTitle = 'Invite People';

?>

<?= PHtml::beginContentHeader(); ?>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>

	<? $form=$this->beginWidget('application.components.widgets.ActiveForm', array(
		'id'=>'invite-form-invite-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<?= $form->errorSummary($model); ?>
	
		<? 
		$this->widget('application.components.widgets.inputs.GroupInputRow', array(
			'form' => $form,
			'model' => $model,
			'groups' => Yii::app()->user->model->groups,
			'showAllGroupsOnAdmin' => true,
		));
		?>
	
		<div class="field">
			<div class="formlabel"><?= $form->labelEx($model,'emails'); ?></div>
			<div class="forminput">
				<?= $form->textArea($model,'emails', 
					array(
						'placeholder'=>'@, @, @...'
					)
				); ?>
			</div>
		</div>
	
	
		<div class="field buttons">
			<?= PHtml::submitButton('Invite'); ?>
		</div>
	
	<? $this->endWidget(); ?>
</section>