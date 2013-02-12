<?
/**
 *
 **/
?>

<header class="content-header">
	<nav class="content-header-nav">
		<? $this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>MenuDefinitions::siteMenu()
		));?>
	</nav>
</header>

<section class="feed content">
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'/feed/_view',
		'emptyText'=>'',
	)); ?>
	<? if(!$dataProvider->data): ?>
		<p class="blurb">Nothing new has happened, once you start creating and participating in activities, things will be here.</p>
	<? endif; ?>
</section>