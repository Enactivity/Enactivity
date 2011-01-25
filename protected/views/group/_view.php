<div class="item group">
<dl>
	<dt><h2><?php 
		echo PHtml::link(PHtml::encode($data->name), 
			array('view', 'slug'=>$data->slug)); 
	?></h2></dt>
</dl>
</div>