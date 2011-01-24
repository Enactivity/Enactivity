<?php $this->beginContent('//layouts/main'); ?>
<section id="content" class="<?php echo $this->id; ?>">
	<header>
		<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>
	</header>
	<?php echo $content; ?>
</section><!-- end of content -->
<?php $this->endContent(); ?>