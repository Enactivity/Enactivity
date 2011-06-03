<?php
$this->pageTitle = 'Tasks';

// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$newTask));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));