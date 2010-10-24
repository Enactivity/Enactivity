<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create')),
	array('label'=>'Update Group', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Group', 'url'=>array('admin')),
);
?>

<h1>View Group: <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'slug',
		'created',
		'modified',
		'groupUsersActiveCount',
	),
)); ?>

<!-- List of users in group -->
<div id="users">
    <?php
    //TODO: only show for registered users 
    if($model->groupUsersActiveCount >= 1): ?>
        <h3>
            <?php echo $model->groupUsersActiveCount . ' Active User(s)'; ?>
        </h3>
 
        <?php $this->renderPartial('_groupusers', array(
            'group'=>$model,
            'groupUsers'=>$model->groupUsersActive,
        )); ?>
    <?php //better to swap contents instead of headers, but this is an example 
    else: ?>
    	<h3>
            <?php echo 'No Pending Users'; ?>
        </h3>
    <?php endif; ?>
     <?php
    //TODO: only show for registered users 
    if($model->groupUsersPendingCount >= 1): ?>
        <h3>
            <?php echo $model->groupUsersPendingCount . ' Invites Pending'; ?>
        </h3>
 
        <?php $this->renderPartial('_groupusers', array(
            'group'=>$model,
            'groupUsers'=>$model->groupUsersPending,
        )); ?>
    <?php //better to swap contents instead of headers, but this is an example 
    else: ?>
    	<h3>
            <?php echo 'No Users'; ?>
        </h3>
    <?php endif; ?>
</div>