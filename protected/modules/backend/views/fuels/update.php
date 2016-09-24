<?php
/* @var $this ConnectionsController */
/* @var $model Connections */
$this->h1Title = 'Редактирование вида топлива '.$model->name;

$this->breadcrumbs=array(
	'Connections'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>