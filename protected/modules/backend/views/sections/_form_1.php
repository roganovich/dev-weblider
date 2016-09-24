<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cred-form',
    'htmlOptions' => array(
        'class' => "form-horizontal",
        'role' => "form"
    ),
        ));
?>
<div class="text-danger">
    <?php echo CHtml::errorSummary($model); ?>
</div>
<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model, 'name', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-9">
            <?php echo $form->textField($model, 'name', array("class" => "form-control", "placeholder" => "Название раздела")); ?>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'name'); ?></div>
</div>

<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model, 'alt_name', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-9">
            <?php echo $form->textField($model, 'alt_name', array("class" => "form-control", "placeholder" => "Подпись раздела")); ?>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'alt_name'); ?></div>
</div>

<div class="form-group ">
    <div class="row">
        <?php echo $form->labelEx($model, 'url', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-9">
            <?php echo $form->textField($model, 'url', array("class" => "form-control", "placeholder" => "URL")); ?>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'url'); ?></div>
</div>
<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model, 'page_type', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-3 ">
            <?php
            echo $form->dropDownList($model, 'page_type', $section_types, array("class" => "form-control", "empty" => "Выберите тип раздела"));
            ?>
        </div><div class="col-xs-7 "></div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'page_type'); ?></div>
    </div>
</div>
<div class="form-group">
    <div class="row">
            <?php echo $form->labelEx($model, 'p_id', array("class" => "col-xs-2 control-label")); ?>
            <?php
            unset($listdata);
            $listdata = array();
            $general_sections = Sections::model()->findAllGeneral();

            function findChild($listdata, Sections $section = null, $model_id = null) {
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
            <div class="col-xs-3">
                <?php echo $form->dropDownList($model, 'p_id', $listdata, array('empty' => 'Это корневой раздел', 'class' => 'form-control')); ?> 
            </div><div class="col-xs-7 "></div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'p_id'); ?></div>
    </div>
</div>

<div class="form-bottom">
        <?php echo CHtml::Link("← Назад", array('sections/index'), array("class" => "btn btn-danger")); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class" => "btn btn-primary")) ?>
</div>
<?php if ($model->isNewRecord): ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.synctranslit.min.js', CClientScript::POS_HEAD); ?>
    <script>
        $(document).ready(function () {
            $("#Sections_name").syncTranslit({destination: "Sections_url"});
        });
    </script>
<?php endif; ?>
<?php $this->endWidget(); ?>

