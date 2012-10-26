<?
/**
 * 
 * @uses carts DataProvider
 * @uses model CheckoutForm
 */

$this->pageTitle = 'Checkout';
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

<section class="contact-form">
	<p class="blurb">Once you place your order, Reed will contact you regarding
	delivery and payment.</p>
	<?= $this->renderPartial('_checkoutform', array('model' => $model)); ?>
</section>
<section class="carts">
	<h1>Your Items For This Order</h1>
	<? $this->widget('zii.widgets.CListView', array(
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view',
	)); ?>
</section>