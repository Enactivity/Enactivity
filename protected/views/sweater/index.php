<?php
/**
 * 
 * @uses Sweater $sweater
 * @uses array $sweaters
 */

$this->pageTitle = 'Build a Sweater';
?>

<?php echo PHtml::beginContentHeader(); ?>
	<div class="menu toolbox">
		<ul>
			<li>
				<?php
				echo PHtml::link(
					PHtml::encode('View Cart'), 
					array('store/cart'),
					array(
						'id'=>'store-cart-menu-item',
						'class'=>'neutral store-cart-menu-item',
						'title'=>'View Your Cart',
					)
				);
				?>
			</li>
		</ul>
	</div>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section>
	<?php foreach($sweaters as $sweaterKey => $attributes): ?>
		<h2><?php echo PHtml::encode($sweater->getAttributeLabel($sweaterKey)); ?></h3>
		<?php foreach($attributes as $attributeKey => $attributeValue): ?>
		<?php 
			$story = $this->beginWidget('application.components.widgets.Story', array(
				'htmlOptions'=>array(
				'id'=>"sweater-" . PHtml::encode($data->id),
				'class'=>PHtml::sweaterClass($data),
			),
		)); ?>

			<?php $story->beginStoryContent(); ?>
				<h1 class="story-title">
					<span>
					<?php 
					echo PHtml::link(PHtml::encode($attributeKey), $attributeValue); 
					?>
					</span>
				</h1>
			<?php $story->endStoryContent(); ?>
		<?php $this->endWidget(); ?>
		<?php endforeach;?>	
	<?php endforeach;?>
	</section>
</div>
<div class="novel">
	<section>
		<h2>Current Selection</h2>
		<?php 
		echo $this->renderPartial('_view', array(
			'data'=>$sweater,
		));
		?>

		<h2>Buy It</h2>
		<?php 
		echo $this->renderPartial('/cartItem/_form', array(
			'model'=>$cartItem,
		));
		?>
	</section>
</div>