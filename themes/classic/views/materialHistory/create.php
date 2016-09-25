<?php
/* @var $this MaterialHistoryController */
/* @var $model MaterialHistory */

$this->breadcrumbs=array(
	'Material Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MaterialHistory', 'url'=>array('index')),
	array('label'=>'Manage MaterialHistory', 'url'=>array('admin')),
);
?>

<h1>Create MaterialHistory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>