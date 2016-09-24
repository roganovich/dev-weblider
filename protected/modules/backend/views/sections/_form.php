<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'cred-form',
    'htmlOptions' => array(
        'class' => "form-horizontal",
        'role' => "form"
    ),
        ));
?>
<div class="text-danger">
    <?php echo CHtml::errorSummary($model); ?>
    <?php echo CHtml::errorSummary($model->content); ?>
</div>
<?php echo $form->checkBoxControlGroup($model, 'active'); ?>
<?php echo $form->textFieldControlGroup($model, 'name', array('size' => 255, 'maxlength' => 255)); ?>
<?php echo $form->textFieldControlGroup($model, 'page', array('size' => 255, 'maxlength' => 255)); ?>
<?php
unset($listdata);
$listdata = array();
$general_sections = Materials::model()->findAllGeneral();

function findChild($listdata, Materials $section = null, $model_id = null) {
    if (!$model_id || $model_id != $section->id) {
        $listdata[$section->id] = str_repeat("--", $section->depth) . " " . $section->name;
        if ($section->childs) {
            foreach ($section->childs as $child) {
                $listdata = findChild($listdata, $child, $model_id);
            }
        }
    }
    return $listdata;
}

;

if ($general_sections) {
    foreach ($general_sections as $general_section) {
        $listdata = findChild($listdata, $general_section, $model->id);
    }
}
?>
<?php echo $form->dropDownListControlGroup($model, 'p_id', $listdata, array('empty' => 'Это корневой раздел') );?>
<?php echo $form->dropDownListControlGroup($model->content, 'type', Materials::$types, array('empty' => 'Выберите тип раздела') );?>

<div class="form-bottom">
    <?php echo CHtml::Link("← Назад", array('sections/index'), array("class" => "btn btn-danger")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class" => "btn btn-primary")) ?>
</div>
<?php if ($model->isNewRecord): ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/jquery.synctranslit.min.js', CClientScript::POS_HEAD); ?>
    <script>
        $(document).ready(function () {
            $("#Materials_name").syncTranslit({destination: "Materials_page"});
        });
    </script>
<?php endif; ?>
<?php $this->endWidget(); ?>

