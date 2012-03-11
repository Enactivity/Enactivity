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
	    	<?php echo PHtml::encode($data->sweaterType); ?>
	    </h1>
	
	    <?php echo PHtml::encode($data->getAttributeLabel('sweaterColor')); ?>:
	    <?php echo PHtml::encode($data->sweaterColor); ?>
	    <br />
	
	    <?php echo PHtml::encode($data->getAttributeLabel('letterColor')); ?>:
	    <?php echo PHtml::encode($data->letterColor); ?>
	    <br />
	
	    <?php echo PHtml::encode($data->getAttributeLabel('letterThreadColor')); ?>:
	    <?php echo PHtml::encode($data->letterThreadColor); ?>
	    <br />
	
		<?php if($data->extraSmallCount > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('extraSmallCount')); ?>:
	    <?php echo PHtml::encode($data->extraSmallCount); ?>
	    <br />
	    <?php endif; ?>
	
		<?php if($data->smallCount > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('smallCount')); ?>:
	    <?php echo PHtml::encode($data->smallCount); ?>
	    <br />
		<?php endif; ?>
		
		<?php if($data->mediumCount > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('mediumCount')); ?>:
	    <?php echo PHtml::encode($data->mediumCount); ?>
	    <br />
		<?php endif; ?>
		
		<?php if($data->largeCount > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('largeCount')); ?>:
	    <?php echo PHtml::encode($data->largeCount); ?>
	    <br />
	    <?php endif; ?>
	
		<?php if($data->extraLargeCount > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('extraLargeCount')); ?>:
	    <?php echo PHtml::encode($data->extraLargeCount); ?>
	    <br />
	    <?php endif; ?>
	
		<?php if($data->extraExtraLargeCount > 0): ?>
	    <?php echo PHtml::encode($data->getAttributeLabel('extraExtraLargeCount')); ?>:
	    <?php echo PHtml::encode($data->extraExtraLargeCount); ?>
	    <br />
	    <?php endif; ?>



    	<?php if(!$data->placed) : ?>
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