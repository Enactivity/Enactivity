<?php
/**
 * View for individual orders
 * @var Cart $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"task-" . PHtml::encode($data->id),
		'class'=>PHtml::cartClass($data),
	),
)); ?>

	<?php $story->beginStoryContent(); ?>

	    <h1>
	    	<?php // echo PHtml::encode($data->letters); ?>
	    </h1>
	
		<?php if ($data->productType == CartItem::PRODUCT_TYPE_SWEATER) : ?>
		<b><?php echo CHtml::encode($data->product->getAttributeLabel('style')); ?>:</b>
		<?php echo CHtml::encode($data->product->style); ?>
		<br />

		<b><?php echo CHtml::encode($data->product->getAttributeLabel('clothColor')); ?>:</b>
		<?php echo CHtml::encode($data->product->clothColor); ?>
		<br />

		<b><?php echo CHtml::encode($data->product->getAttributeLabel('letterColor')); ?>:</b>
		<?php echo CHtml::encode($data->product->letterColor); ?>
		<br />

		<b><?php echo CHtml::encode($data->product->getAttributeLabel('stitchingColor')); ?>:</b>
		<?php echo CHtml::encode($data->product->stitchingColor); ?>
		<br />

		<b><?php echo CHtml::encode($data->product->getAttributeLabel('size')); ?>:</b>
		<?php echo CHtml::encode($data->product->size); ?>
		<br />
		<?php endif; ?>

		<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
		<?php echo CHtml::encode($data->quantity); ?>
		<br />

    	<?php if(!$data->purchased) : ?>
    	<?php $story->beginControls(); ?>
    		<?php echo PHtml::openTag('li');
			echo PHtml::link(
				PHtml::encode('Edit'), 
				array('update', 'id'=>$data->id),
				array(
					'id'=>'cart-update-menu-item-' . $data->id,
					'class'=>'neutral cart-update-menu-item',
					'title'=>'Edit this order',
				)
			); 
			echo PHtml::closeTag('li');

			echo PHtml::openTag('li');
			echo PHtml::button(
				PHtml::encode('Delete'), 
				array(
					'submit'=>array('store/delete', 'id'=>$data->id),
					'csrf'=>true,
					'id'=>'cart-delete-menu-item-' . $data->id,
					'class'=>'neutral cart-delete-menu-item',
					'title'=>'Delete this order',
					'confirm'=>'Are you sure?  It will be gone forever.',
				)
			); 
			echo PHtml::closeTag('li');
			?>
		<?php $story->endControls(); ?>
		<?php endif; ?>
		
	<?php $story->endStoryContent(); ?>
<?php $this->endWidget(); ?>