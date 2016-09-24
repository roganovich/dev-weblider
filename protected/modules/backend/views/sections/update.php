<?php
$this->breadcrumbs=array(
        'Cписок разделов'=>array('sections/index'),  
	'Редактирование раздела',
);
?>
<h1 class="title">Редактирование раздела <i><?php echo CHtml::encode($model->name); ?></i></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'section_types' => $section_types, 'section_styles' => $section_styles)); ?>

