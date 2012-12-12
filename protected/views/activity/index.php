<?php
/* @var $this ActivityController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Activities';
?>

<section class="activities content">
	<? foreach($activities as $activity): ?>
	<? $this->renderPartial('_view', array('data'=>$activity)); ?>
	<? endforeach; ?>
</section>