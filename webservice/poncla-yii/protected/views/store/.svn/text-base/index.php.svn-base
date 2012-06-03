<?php
/**
 * 
 * @uses CartItem $cart
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
		<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</div>