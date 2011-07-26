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

<?php echo $content; ?>

<?php $this->endContent(); ?>