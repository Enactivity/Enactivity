<div class="view">

	<b><?= CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?= CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?= CHtml::encode($data->userId); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('productType')); ?>:</b>
	<?= CHtml::encode($data->productType); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('productId')); ?>:</b>
	<?= CHtml::encode($data->productId); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?= CHtml::encode($data->quantity); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('purchased')); ?>:</b>
	<?= CHtml::encode($data->purchased); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('delivered')); ?>:</b>
	<?= CHtml::encode($data->delivered); ?>
	<br />

	<? /*
	<b><?= CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?= CHtml::encode($data->created); ?>
	<br />

	<b><?= CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?= CHtml::encode($data->modified); ?>
	<br />

	*/ ?>

</div>