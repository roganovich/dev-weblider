<?php
/* @var $this MaterialHistoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Material Histories',
);

$this->menu=array(
	array('label'=>'Create MaterialHistory', 'url'=>array('create')),
	array('label'=>'Manage MaterialHistory', 'url'=>array('admin')),
);
?>

<h1>Material Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
