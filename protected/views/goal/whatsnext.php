<?php
	$this->pageTitle = 'What\'s Next';

// "what would you want to do input" box
echo $this->renderPartial('_form', array('model'=>$model));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$ownedGoals,
	'itemView'=>'_view',
));