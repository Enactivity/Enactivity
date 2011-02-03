<?php $this->beginContent('//layouts/main'); ?>
<section id="content" class="<?php echo $this->id; ?>">
	<header>
		<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>
	</header>
	<div id="contentBody">
	<?php echo $content; ?>
	</div>
</section><!-- end of content -->
<?php $this->endContent(); ?>