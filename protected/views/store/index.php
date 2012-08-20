<?
/**
 * 
 * @uses CartItem $cart
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

<div class="novel">
	<section>
		<?= $this->renderPartial('_form', array('model'=>$model)); ?>
	</section>
</div>