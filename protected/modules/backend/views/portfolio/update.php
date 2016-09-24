<?php
/* @var $this ConnectionsController */
/* @var $model Connections */
$this->h1Title = 'Редактирование работы '.$model->name;

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>