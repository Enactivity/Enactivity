<?php 
/**
 * View for task model update scenario
 * 
 */
?>

<article class="email">
	<p>
		<strong><time><?php PHtml::e(Yii::app()->format->formatDateTime(time())); ?></time></strong>
	</p>
	<p>Hey there! Just letting you know:</p>
	<ul>
		
		<?php foreach($changedAttributes as $attributeName => $attributeArray) : ?>
		<li>
			<?php PHtml::e($user->fullName); ?> 

			<?php // user updating a date and time originally not null
			if(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] != '') : ?>		
			updated <?php PHtml::e($data->name); ?> from <?php PHtml::e($attributeArray['old']); ?> to <?php PHtml::e($attributeArray['new']); ?>
			
			<?php // user removing a set date and time
			elseif(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] == '') : ?>
			removed the date and time for <?php PHtml::e($data->name); ?> which used to start at <?php PHtml::e($attributeArray['old']); ?>
			
			<?php // user updating a date and time originally null
			else : ?>
			added a date and time for <?php PHtml::e($data->name); ?> which now starts at <?php PHtml::e($attributeArray['new']); ?>			
			<?php endif; ?>
			.
		</li>
		<?php endforeach; ?>
	</ul>
</article>