<?php

?>

<h1>Event Banters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText' => 'No one has commented on this event yet.',
)); ?>
