<?php
/**
 * 
 * @uses carts DataProvider
 * @uses model CheckoutForm
 */

$this->pageTitle = 'Checkout';
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
	<section class="contact-form">
		<p class="blurb">Once you place your order, Reed will contact you regarding
		delivery and payment.</p>
		<?php echo $this->renderPartial('_checkoutform', array('model' => $model)); ?>
	</section>
	<section class="carts">
		<h1>Your Items For This Order</h1>
		<?php $this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_view',
		)); ?>
	</section>
</div>