<h1 class="title">Редактирование статьи <i><?php echo CHtml::encode($model->name); ?></i></h1>

<?php echo $this->renderPartial('_form', array('BackUrl' => $BackUrl, 'model'=>$model)); ?>

