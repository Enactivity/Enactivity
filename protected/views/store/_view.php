<?php
/**
 * View for individual orders
 * @var Cart $data model
 * @var boolean $showControls
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"task-" . PHtml::encode($data->id),
		'class'=>PHtml::cartClass($data),
	),
)); ?>

	<?php $story->beginStoryContent(); ?>

	    <h1>
	    	<?php echo PHtml::encode($data->letters); ?>
	    	<?php echo PHtml::encode($data->sweater_type); ?>
	    </h1>
	
	    <?php echo PHtml::encode($data->getAttributeLabel('sweater_color')); ?>:
	    <?php echo PHtml::encode($data->sweater_color); ?>
	    <br />
	
	    <?php echo PHtml::encode($data->getAttributeLabel('letter_color')); ?>:
	    <?php echo PHtml::encode($data->letter_color); ?>
	    <br />
	
	    <?php echo PHtml::encode($data->getAttributeLabel('letter_thread_color')); ?>:
	    <?php echo PHtml::encode($data->letter_thread_color); ?>
	    <br />
	
		<?php if($data->extra_small_count > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('extra_small_count')); ?>:
	    <?php echo PHtml::encode($data->extra_small_count); ?>
	    <br />
	    <?php endif; ?>
	
		<?php if($data->small_count > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('small_count')); ?>:
	    <?php echo PHtml::encode($data->small_count); ?>
	    <br />
		<?php endif; ?>
		
		<?php if($data->medium_count > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('medium_count')); ?>:
	    <?php echo PHtml::encode($data->medium_count); ?>
	    <br />
		<?php endif; ?>
		
		<?php if($data->large_count > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('large_count')); ?>:
	    <?php echo PHtml::encode($data->large_count); ?>
	    <br />
	    <?php endif; ?>
	
		<?php if($data->extra_large_count > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('extra_large_count')); ?>:
	    <?php echo PHtml::encode($data->extra_large_count); ?>
	    <br />
	    <?php endif; ?>
	
		<?php if($data->extra_extra_large_count > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('extra_extra_large_count')); ?>:
	    <?php echo PHtml::encode($data->extra_extra_large_count); ?>
	    <br />
	    <?php endif; ?>



    	<?php if(!$data->isPlaced) : ?>
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
					'class'=>'negative cart-delete-menu-item',
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