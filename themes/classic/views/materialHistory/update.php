<?php
/* @var $this MaterialHistoryController */
/* @var $model MaterialHistory */

$this->breadcrumbs=array(
	'Material Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MaterialHistory', 'url'=>array('index')),
	array('label'=>'Create MaterialHistory', 'url'=>array('create')),
	array('label'=>'View MaterialHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MaterialHistory', 'url'=>array('admin')),
);
?>

<h1>Update MaterialHistory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>