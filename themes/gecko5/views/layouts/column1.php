<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<header>
		<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>
	</header>
	<?php echo $content; ?>
</div><!-- end of content -->
<?php $this->endContent(); ?>