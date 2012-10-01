<?

/*
 * View used to return a description string
 * for facebook group feed post when updating post
 * @author Harrison Vuong
 */

<? foreach($changedAttributes as $attributeName => $attributeArray) : ?>
	<? PHtml::e($user->fullName); ?> 

	<? // user updating a date and time originally not null
	if(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] != '') : ?>		
	updated <?= PHtml::link(PHtml::encode($data->name), PHtml::taskURL($data)); ?> from <? PHtml::e($attributeArray['old']); ?> to <? PHtml::e($attributeArray['new']); ?>
	
	<? // user removing a set date and time
	elseif(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] == '') : ?>
	removed the date and time for <?= PHtml::link(PHtml::encode($data->name), PHtml::taskURL($data->task)); ?> which used to start at <? PHtml::e($attributeArray['old']); ?>
	
	<? // user updating a date and time originally null
	else : ?>
	added a date and time for <?= PHtml::link(PHtml::encode($data->name), PHtml::taskURL($data)); ?> which now starts at <? PHtml::e($attributeArray['new']); ?>			
	<? endif; ?>
	.
</li>
<? endforeach; ?>

?>