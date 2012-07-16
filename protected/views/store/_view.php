<?
/**
 * View for individual orders
 * @var CartItem $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"task-" . PHtml::encode($data->id),
		'class'=>PHtml::cartClass($data),
	),
)); ?>

	<? $story->beginStoryContent(); ?>

	    <h1>
	    	<? // echo PHtml::encode($data->letters); ?>
	    </h1>
	
		<? if ($data->productType == CartItem::PRODUCT_TYPE_SWEATER) : ?>
		<b><?= PHtml::encode($data->product->getAttributeLabel('style')); ?>:</b>
		<?= PHtml::encode($data->product->style); ?>
		<br />

		<b><?= PHtml::encode($data->product->getAttributeLabel('clothColor')); ?>:</b>
		<?= PHtml::encode($data->product->clothColor); ?>
		<br />

		<b><?= PHtml::encode($data->product->getAttributeLabel('letterColor')); ?>:</b>
		<?= PHtml::encode($data->product->letterColor); ?>
		<br />

		<b><?= PHtml::encode($data->product->getAttributeLabel('stitchingColor')); ?>:</b>
		<?= PHtml::encode($data->product->stitchingColor); ?>
		<br />

		<b><?= PHtml::encode($data->product->getAttributeLabel('size')); ?>:</b>
		<?= PHtml::encode($data->product->size); ?>
		<br />

		<b><?= PHtml::encode($data->getAttributeLabel('sweaterLetters')); ?>:</b>
		<?= PHtml::encode($data->sweaterLetters); ?>
		<br />

		<? endif; ?>

		<b><?= PHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
		<?= PHtml::encode($data->quantity); ?>
		<br />

    	<? if(!$data->purchased) : ?>
    	<? $story->beginControls(); ?>
    		<?= PHtml::openTag('li');
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
		<? $story->endControls(); ?>
		<? endif; ?>
		
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>