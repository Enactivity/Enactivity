<?
/**
 * 
 * @uses Sweater $sweater
 * @uses array $sweaters
 */

$this->pageTitle = 'Build a Sweater';
?>

<?= PHtml::beginContentHeader(); ?>
	<div class="menu toolbox">
		<ul>
			<li>
				<?
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
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<section>
<? foreach($sweaters as $sweaterKey => $attributes): ?>
	<h2><?= PHtml::encode($sweater->getAttributeLabel($sweaterKey)); ?></h3>
	<? foreach($attributes as $attributeKey => $attributeValue): ?>
	<? 
		$story = $this->beginWidget('application.components.widgets.Story', array(
			'htmlOptions'=>array(
			'id'=>"sweater-" . PHtml::encode($data->id),
			'class'=>PHtml::sweaterClass($data),
		),
	)); ?>

		<? $story->beginStoryContent(); ?>
			<h1 class="story-title">
				<span>
				<? 
				echo PHtml::link(PHtml::encode($attributeKey), $attributeValue); 
				?>
				</span>
			</h1>
		<? $story->endStoryContent(); ?>
	<? $this->endWidget(); ?>
	<? endforeach;?>	
<? endforeach;?>
</section>
<section>
	<h2>Current Selection</h2>
	<? 
	echo $this->renderPartial('_view', array(
		'data'=>$sweater,
	));
	?>

	<? if($sweater->id): ?>
	<h2>Customize It</h2>
	<? 
	echo $this->renderPartial('/cartItem/_form', array(
		'model'=>$cartItem,
	));
	?>
	<? endif; ?>
</section>