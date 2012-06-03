<?php
/**
 * 
 * @uses $cartItems
 * @uses $cartItemsInProcess
 * @uses $cartItemsCompleted
 */

$this->pageTitle = 'Cart';
?>

<?php echo PHtml::beginContentHeader(); ?>
	<div class="menu toolbox">
		<ul>
			<?php if($cartItems->itemCount > 0): ?>
			<li>
				<?php
				echo PHtml::link(
					PHtml::encode('Proceed to Checkout'), 
					array('store/checkout'),
					array(
						'id'=>'store-checkout-menu-item',
						'class'=>'neutral store-checkout-menu-item',
						'title'=>'Begin the steps to checkout your items',
					)
				);
				?>
			</li>
			<?php endif; ?>
			<li>
				<?php
				echo PHtml::link(
					PHtml::encode('Build Sweaters'), 
					array('store/index'),
					array(
						'id'=>'store-index-menu-item',
						'class'=>'neutral store-index-menu-item',
						'title'=>'Build More Sweaters',
					)
				);
				?>
			</li>
		</ul>
	</div>
	<h1><?php echo PHtml::encode($this->pageTitle);?></h1>
<?php echo PHtml::endContentHeader(); ?>

<div class="novel">
	<section class="cart">
		<h1>Items to Buy</h1>
		<?php $this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$cartItems,
			'emptyText'=>"No orders?  Why not " . 
				PHtml::link(
					'build some sweaters', 
					array('store/index'),
					array(
						'title'=>'Build Some Sweaters',
					)
				) . "?",
		    'itemView'=>'_view',
		)); ?>
	</section>
	<section class="cart">
		<h1>In Progress Orders</h1>
		<?php $this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$cartItemsInProcess,
		    'emptyText'=>"You don't have any outstanding orders.  Once you place an order, you'll see it here.",
		    'itemView'=>'_view',
		)); ?>
	</section>
	<section class="cart">
		<h1>Completed Orders</h1>
		<?php $this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$cartItemsCompleted,
			'emptyText'=>"You haven't bought anything in the past.  What's up with that?  We want your money.",
		    'itemView'=>'_view',
		)); ?>
	</section>
</div>