<?php
/* @var $this ConnectionsController */
/* @var $model Connections */
$this->h1Title = 'Добавление вида топлива';

$this->breadcrumbs=array(
	'Connections'=>array('index'),
	'Create',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>