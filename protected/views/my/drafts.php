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
	<? $this->renderPartial('/activity/_view', array('data'=>$activity)); ?>
	<? endforeach; ?>
	<? if(!$activities): ?>
		<p class="blurb">You have no drafts at the moment.</p>
	<? endif; ?>
</section>