<?
/**
 *
 **/
?>

<header class="content-header">
	<nav>
		<? $this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>MenuDefinitions::siteMenu()
		));?>
	</nav>
</header>

<section class="feed content">
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</section>