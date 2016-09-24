<h1 class="title">Редактирование блока <i><?php echo CHtml::encode($model->name); ?></i></h1>

<?php echo $this->renderPartial('_form', array(
    'position' => $position,
    'model'=>$model,
    'types'=>$types,
)); ?>
