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
<?php echo $form->checkBoxControlGroup($model, 'active'); ?>
<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model->content, 'thumb', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-10">
            <?php
            if ($model->content->thumb) {
                echo CHtml::image($model->content->thumbLink, $model->content->thumb, array('name' => "News[thumb]", "style" => "max-width: 200px;"));
                echo CHtml::link('Удалить картинку', array('/#'), array('onclick' => 'deleteImage("#News_thumb"); return false;'));
                echo $form->hiddenField($model->content, 'thumb');
            } else {
                echo CHtml::activeFileField($model->content, 'thumb', array("style" => "padding-top: 7px;"));
            }
            ?>
        </div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model->content, 'thumb'); ?></div>
    </div>
</div>
<?php echo $form->textFieldControlGroup($model, 'name', array('size' => 255, 'maxlength' => 255)); ?>
<?php echo $form->textFieldControlGroup($model, 'page', array('size' => 255, 'maxlength' => 255)); ?>
<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model->content, 'anons', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-12">
            <?php echo $form->textArea($model->content, 'anons', array("class" => "form-control text-editor")); ?>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model->content, 'anons'); ?></div>
</div>
<div class="form-group">
    <div class="row">
        <?php echo $form->labelEx($model->content, 'text', array("class" => "col-xs-2 control-label")); ?>
        <div class="col-xs-12">
            <?php echo $form->textArea($model->content, 'text', array("class" => "form-control text-editor")); ?>
        </div>
    </div>
    <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model->content, 'text'); ?></div>
</div>
<?php echo $form->hiddenField($model, 'p_id'); ?>

<div class="form-bottom">
    <?php echo CHtml::Link("← Назад", $BackUrl, array("class" => "btn btn-danger")); ?>
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
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/ckeditor.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/adapters/adapterjquery.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckfinder/ckfinder.js', CClientScript::POS_HEAD); ?>
<script>
    $(document).ready(function () {
        if ($(".text-editor").length)
            $(".text-editor").ckeditor(function () {
                CKFinder.setupCKEditor(this, '<?php echo Yii::app()->createAbsoluteUrl("/") ?>/inc/ckfinder/');
            });
    });</script>
