<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'cred-form',
    'htmlOptions' => array(
        'class' => "form-horizontal",
        'role' => "form",
        "enctype" => "multipart/form-data"
    ),
        ));
?>
<div class="text-danger">
    <?php echo CHtml::errorSummary($model); ?>
</div>
<?php echo $form->textFieldControlGroup($model, 'name', array('size' => 255, 'maxlength' => 255)); ?>
<?php echo $form->textFieldControlGroup($model, 'file', array('size' => 255, 'maxlength' => 255)); ?>
<?php echo $form->dropDownListControlGroup($model, 'type', Blocks::$types, array('empty' => 'Выберите тип материалов для шаблона') );?>
<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model, 'thumb', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-10">
            <?php
            if ($model->thumb) {
                echo CHtml::image($model->thumbLink, $model->thumb, array('name' => "Templates[thumb]", "style" => "max-width: 200px;"));
                echo CHtml::link('Удалить картинку', array('/#'), array('onclick' => 'deleteImage("#Templates_thumb"); return false;'));
                echo $form->hiddenField($model, 'thumb');
            } else {
                echo CHtml::activeFileField($model, 'thumb', array("style" => "padding-top: 7px;"));
            }
            ?>
        </div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'thumb'); ?></div>
    </div>
</div>
<?php echo $form->textAreaControlGroup($model, 'comment', array('style' => 'width: 100%')); ?>
<?php echo $form->checkBoxListControlGroup($model, 'positions', Yii::app()->params['positions']); ?>

<div class="form-bottom">
    <?php echo CHtml::Link("← Назад", array('/backend/templates'), array("class" => "btn btn-danger")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class" => "btn btn-primary")) ?>
</div>

<?php $this->endWidget(); ?>
