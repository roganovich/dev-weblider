<h1 class="title">Добавление нового блока</h1>

<?php echo $this->renderPartial('_form', array(
    'position' => $position,
    'model'=>$model,
    'types'=>$types,
)); ?>