<?php $this->beginContent('//layouts/main'); ?>

<!-- flash notices -->
<?php if(Yii::app()->user->hasFlash('error')):?>
<aside class="flash-error">
<?php echo Yii::app()->user->getFlash('error'); ?>
</aside>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('notice')):?>
<aside class="flash-notice">
<?php echo Yii::app()->user->getFlash('notice'); ?>
</aside>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('success')):?>
<aside class="flash-success">
<?php echo Yii::app()->user->getFlash('success'); ?>
</aside>
<?php endif; ?>

	<header>
		<?php 
		if(isset($this->pageMenu) 
			&& !empty($this->pageMenu)
			&& !Yii::app()->user->isGuest
		):?>
		<menu class="toolbox">
			<?php 
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->pageMenu,
			));
			?>
		</menu><!-- end of toolbox -->
	<?php endif; 
	if(!empty($this->pageTitle)) {
		echo PHtml::openTag('h1');
		echo PHtml::encode($this->pageTitle); 
		echo PHtml::closeTag('h1');
	}
	if(!empty($this->pageByline)) {
		echo PHtml::openTag('h2');
		echo PHtml::encode($this->pageByline); 
		echo PHtml::closeTag('h2');
	}
	?>
	</header>
	<?php echo $content; ?>

<?php $this->endContent(); ?>