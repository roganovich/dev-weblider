<?php
$this->breadcrumbs=array(
        'Cписок разделов'=>array('sections/index'),  
	'Добавление раздела',
);
?>
<h1 class="title">Добавление нового раздела</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'section_types' => $section_types, 'section_styles' => $section_styles)); ?>