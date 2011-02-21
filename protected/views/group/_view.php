<div class="item group">
<dl>
	<dt><h1><?php 
		echo PHtml::link(PHtml::encode($data->name), 
			array('view', 'slug'=>$data->slug)); 
	?></h1></dt>
</dl>
</div>