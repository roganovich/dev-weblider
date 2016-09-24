<?php
$this->h1Title = 'Настройки';

$this->breadcrumbs = array(
    'Настройки',
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm'); ?>
<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Основные</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-3 control-label">Имя администратора</label>
                    <div class="col-xs-3">
                        <?php echo BsHtml::textField('form[admin_subscribe_name]', OptionsRegistr::getInstance()->get('admin_subscribe_name')); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-3 control-label">Контактный телефон</label>
                    <div class="col-xs-3">
                        <?php echo BsHtml::textField('form[contact_phone]', OptionsRegistr::getInstance()->get('contact_phone')); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Контактная информация</label>
                <div>
                    <?php echo BsHtml::textArea('form[contact_info]', OptionsRegistr::getInstance()->get('contact_info'), array('class' => 'text-editor')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-xs-3 control-label">Email администратора </label>
                    <div class="col-xs-3">
                        <?php echo BsHtml::textField('form[admin_email]', OptionsRegistr::getInstance()->get('admin_email')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>

</div>
<?php echo BsHtml::submitButton('Сохранить', array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/adapters/adapterjquery.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckfinder/ckfinder.js', CClientScript::POS_END); ?>

<script type="text/javascript">
    jQuery(function () {
        if ($(".text-editor").length) {
            $(".text-editor").each(function () {
                $(this).ckeditor(function () {
                    CKFinder.setupCKEditor(this, '/inc/ckfinder/');
                });
            });
        }
    })
</script>