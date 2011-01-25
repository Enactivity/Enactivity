<div class="item group">
<dl>
	<dd><h2><?php 
		echo PHtml::link(PHtml::encode($data->name), 
			array('view', 'slug'=>$data->slug)); 
	?></h2></dd>
</dl>
</div>