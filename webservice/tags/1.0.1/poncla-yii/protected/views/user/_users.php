<?php 
/**
 * Provides simple list of users for use in a zii.widgets.CListView
 * @param IDataProvider $data list of Users 
 */ 
?>
<div class="item user"><span><?php 
	echo PHtml::link(
		$data->fullName != "" ? $data->fullName : $data->email, 
		$data->permalink, array(
			'class'=>'permalink',
		)
	);
	?></span>
</div>