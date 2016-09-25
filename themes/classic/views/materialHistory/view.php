<?php
/* @var $this MaterialHistoryController */
/* @var $model MaterialHistory */

$this->breadcrumbs=array(
	'Material Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MaterialHistory', 'url'=>array('index')),
	array('label'=>'Create MaterialHistory', 'url'=>array('create')),
	array('label'=>'Update MaterialHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MaterialHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MaterialHistory', 'url'=>array('admin')),
);
?>

<h1>View MaterialHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'material_type',
		'matarial_id',
		'created_at',
	),
)); ?>
