<?php
$this->pageTitle = $model->name;
$this->pageMenu = MenuDefinitions::taskMenu($model);

$this->widget('ext.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name' => 'name',
			'visible' => strlen($model->name) > 0 ? true : false,
		),
		array(
			'name' => 'ownerId',
			'visible' => strlen($model->name) > 0 ? true : false,
		),
		array( 
			'name' => 'starts',
			'type' => 'styledtext',
		),
		array( 
			'name' => 'ends',
			'type' => 'styledtext',
		),
	),
));

?>

<section id="users-participating">
	<header>
		<h1><?php echo PHtml::encode($users->totalItemCount) . ' Participating'; ?></h1>
	</header>
	
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$users,
		'itemView'=>'/user/_users',
		'emptyText' => 'No one has signed up to participate yet.',
	)); 
	?>
</section>
<section>
	<header>
		<h1><?php echo 'History'; ?></h1>
	</header>
	<?php 
//	$this->widget('zii.widgets.CListView', array(
//		'dataProvider'=>$logs,
//		'itemView'=>'/feed/_view',
//		'emptyText' => 'Nothing new',
//	)); 

	foreach($logs as $log) {
		$this->renderPartial('_feed',
			array(
				'data' => $log
			) 
		);
	}
	?>
</section>