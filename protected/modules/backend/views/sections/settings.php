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
<fieldset>
    <legend>Основные настройки</legend>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'thumb', array("class" => "col-xs-2 control-label")); ?>
            <div class="col-xs-10">
                <?php
                if ($model->thumb) {
                    echo CHtml::image($model->thumbLink, $model->thumb, array('name' => "Sections[thumb]", "style" => "max-width: 200px;"));
                    echo CHtml::link('Удалить картинку', array('/#'), array('onclick' => 'deleteImage("#Sections_thumb"); return false;'));
                    echo $form->hiddenField($model, 'thumb');
                } else {
                    echo CHtml::activeFileField($model, 'thumb', array("style" => "padding-top: 7px;"));
                }
                ?>
            </div>
            <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'thumb'); ?></div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'title', array("class" => "col-xs-2 control-label")); ?>
            <div class="col-xs-9">
                <?php echo $form->textField($model, 'title', array("class" => "form-control", "placeholder" => "Заголовок раздела")); ?>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'title'); ?></div>
    </div>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'anons', array("class" => "col-xs-2 control-label")); ?>
            <div class="col-xs-12">
                <?php echo $form->textArea($model, 'anons', array("class" => "form-control text-editor")); ?>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'anons'); ?></div>
    </div>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'text', array("class" => "col-xs-2 control-label")); ?>
            <div class="col-xs-12">
                <?php echo $form->textArea($model, 'text', array("class" => "form-control text-editor")); ?>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'text'); ?></div>
    </div>
</fieldset>
<fieldset>
    <legend>Наследуемые настройки</legend>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'logo', array("class" => "col-xs-2 control-label")); ?>
            <div class="col-xs-10">
                <?php
                if ($model->logo) {
                    echo CHtml::image($model->logoLink, $model->logo, array('name' => "Sections[logo]", "style" => "max-width: 200px;"));
                    echo CHtml::link('Удалить картинку', array('/#'), array('name' => "Sections[logo]",'onclick' => 'deleteImage("#Sections_logo"); return false;'));
                    echo $form->hiddenField($model, 'logo');
                } else {
                    echo CHtml::activeFileField($model, 'logo', array("style" => "padding-top: 7px;"));
                }
                ?>
            </div>
            <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'logo'); ?></div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'img_top', array("class" => "col-xs-2 control-label")); ?>
            <div class="col-xs-10">
                <?php
                if ($model->img_top) {
                    echo CHtml::image($model->imgTopLink, $model->img_top, array('name' => "Sections[img_top]", "style" => "max-width: 200px;"));
                    echo CHtml::link('Удалить картинку', array('/#'), array('name' => "Sections[img_top]",'onclick' => 'deleteImage("#Sections_img_top"); return false;'));
                    echo $form->hiddenField($model, 'img_top');
                } else {
                    echo CHtml::activeFileField($model, 'img_top', array("style" => "padding-top: 7px;"));
                }
                ?>
            </div>
            <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'img_top'); ?></div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <?php echo $form->labelEx($model, 'img_bottom', array("class" => "col-xs-3 control-label")); ?>
            <div class="col-xs-9">
                <?php
                if ($model->img_bottom) {
                    echo CHtml::image($model->imgBottomLink, $model->img_bottom, array('name' => "Sections[img_bottom]", "style" => "max-width: 200px;"));
                    echo CHtml::link('Удалить картинку', array('/#'), array('name' => "Sections[img_bottom]",'onclick' => 'deleteImage("#Sections_img_bottom"); return false;'));
                    echo $form->hiddenField($model, 'img_bottom');
                } else {
                    echo CHtml::activeFileField($model, 'img_bottom', array("style" => "padding-top: 7px;"));
                }
                ?>
            </div>
            <div class="col-xs-9 col-xs-offset-3 text-danger"><?php echo $form->error($model, 'img_bottom'); ?></div>
        </div>
    </div>

</fieldset>
<div class="form-bottom">
    <?php echo CHtml::Link("← Назад", $backUrl, array("class" => "btn btn-danger")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class" => "btn btn-primary")) ?>
</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/ckeditor.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/adapters/adapterjquery.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckfinder/ckfinder.js', CClientScript::POS_HEAD); ?>
<script>
    $(document).ready(function () {
        if ($(".text-editor").length)
            $(".text-editor").ckeditor(function () {
                CKFinder.setupCKEditor(this, '<?php echo Yii::app()->createAbsoluteUrl("/")?>/inc/ckfinder/');
            });
    });</script>
