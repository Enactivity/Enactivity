<?php $this->beginContent('//layouts/main'); ?>
<article id="content">
	<header>
		<h1><?php echo $this->pageTitle; ?></h1>
	</header>
	<?php echo $content; ?>
</article><!-- end of content -->
<?php $this->endContent(); ?>