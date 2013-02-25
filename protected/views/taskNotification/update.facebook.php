<?

/*
 * View used to return a description string
 * for facebook group feed post when updating post
 * @author Harrison Vuong
 */

echo "Hey there! ";

foreach($changedAttributes as $attributeName => $attributeArray) :
	if(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] != '') :
		echo '"' . PHtml::encode($data->name) . '"' . ' was updated from ' . '"' . PHtml::encode($attributeArray['old']) . '"' . ' to ' . '"' . PHtml::encode($attributeArray['new']) . '"' . '. ';
	elseif(isset($attributeArray['old']) && $attributeArray['old'] != '' && $attributeArray['new'] == '') : 
		echo 'A date and time was removed for ' . '"' . PHtml::encode($data->name) . '"' . ' which used to start at ' . PHtml::encode($attributeArray['old']) . '. ';
	else :
		echo 'A date and time was added for ' . '"' . PHtml::encode($data->name) . '"' . ' which now starts at ' . PHtml::encode($attributeArray['new']) . '. ';
	endif;
endforeach;
?>