<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div id="sidebar">
	<?php
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
		));
	?>
	</div><!-- end of sidebar -->
	
	<div id="content">
		<?php echo $content; ?>
	</div><!-- end of content -->
</div>
<?php $this->endContent(); ?>