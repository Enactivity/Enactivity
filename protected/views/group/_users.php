<?php 
/**
 * Provides simple list of users for use in a zii.widgets.CListView
 * @param IDataProvider $data list of Users 
 */ 
?>
<div class="view">
	<?php 
	echo CHtml::link(
		$data->fullName() != "" ? $data->fullName() : $data->email, 
		$data->getUrl($post), array(
			'class'=>'cid',
			'title'=>'Permalink to this user',
		)
	);
	?>
</div>