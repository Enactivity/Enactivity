<?php $this->beginContent('//layouts/main'); ?>
<section id="content" class="<?php echo $this->id . " " . $this->action->id;?>">
	<header>
		<h1><?php echo PHtml::link(
			PHtml::encode($this->pageTitle),
			Yii::app()->request->url
		); ?></h1>
	
		<?php if(isset($this->pageMenu) 
			&& !empty($this->pageMenu)
			&& !Yii::app()->user->isGuest
		):?>
		<nav id="tertiaryNavigation">
		<?php 
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->pageMenu,
		));
		?>
		</nav><!-- end of tertiaryNavigation -->
	<?php endif; ?>
	</header>
	
	<div id="contentBody">
	<?php echo $content; ?>
	</div>
</section><!-- end of content -->
<?php $this->endContent(); ?>