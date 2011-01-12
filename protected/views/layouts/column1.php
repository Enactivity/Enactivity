<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<?php
	if(isset($this->menu) 
		&& !empty($this->menu)
		&& !Yii::app()->user->isGuest
		):?>
		<div id="sidebar">
		<?php 
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
		));
		?>
		</div><!-- end of sidebar -->
	<?php endif; ?>
	
	
	<!-- flash notices -->
		<?php if(Yii::app()->user->hasFlash('error')):?>
		    <div class="flash-error">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php endif; ?>
		<?php if(Yii::app()->user->hasFlash('notice')):?>
		    <div class="flash-notice">
		        <?php echo Yii::app()->user->getFlash('notice'); ?>
		    </div>
		<?php endif; ?>
		<?php if(Yii::app()->user->hasFlash('success')):?>
		    <div class="flash-success">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php endif; ?>
	
	<div id="content">
		<?php echo $content; ?>
	</div><!-- end of content -->
</div>
<?php $this->endContent(); ?>