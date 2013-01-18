<?php
/* @var $this ActivityController */
/* @var $dataProvider CActiveDataProvider */
?>

<header class="content-header">
	<nav>
		<? $this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>MenuDefinitions::siteMenu()
		));?>
	</nav>
</header>

<section class="activities content">
	<? foreach($activities as $activity): ?>
	<? $this->renderPartial('_view', array('data'=>$activity)); ?>
	<? endforeach; ?>
</section>