<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'cred-form',
    'htmlOptions' => array(
        'class' => "form-horizontal",
        'role' => "form",
    ),
        ));
?>
<div class="text-danger">
    <?php echo BsHtml::errorSummary($model); ?>
    <?php if($model->settings) echo BsHtml::errorSummary($model->settings); ?>
</div>
<div class="bs-example bs-example-tabs" data-example-id="togglable-tabs"> 
    <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
        <li role="presentation" class="active">
            <a href="#setup" id="home-tab" role="tab" data-toggle="tab" aria-controls="setup" aria-expanded="true">Настройки</a></li> 
        <li role="presentation">
            <a href="#content" role="tab" id="content-tab" data-toggle="tab" aria-controls="content">Контент</a>
        </li> 


    </ul> 
    <div id="BlockContent" class="tab-content"> 
        <div role="tabpanel" class="tab-pane fade in active" id="setup" aria-labelledby="setup-tab"> 
            <?php echo BsHtml::activeTextFieldControlGroup($model, 'name', array('size' => 255, 'maxlength' => 255)); ?>
            <div class="row">
                <div class="col-xs-6">
                    <?php echo BsHtml::activeDropDownListControlGroup($model, 'type', Templates::findTypesInPosition($position), array('empty' => 'Выберите тип блока')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?php echo BsHtml::activeDropDownListControlGroup($model, 'template_id', $types, array(
                            'empty' => 'Выберите шаблон блока',
                            'onchange' => 'checkSample()',
                            'groupOptions' => array(
                                'class' => 'template_id_wrap', 
                                'style' => ($types)?"display: block":"")
                        ));
                    ?>
                </div>
            </div>
            <div id='settings'>
            <?php if($model->settingsTemplate):?>
                <?php echo $this->renderPartial($model->settingsTemplate, array(
                    'model'=>$model,
                )); ?>
            <?php endif?>
            </div>
        </div> 
        <div role="tabpanel" class="tab-pane fade" id="content" aria-labelledby="content-tab"> 
            <?php echo BsHtml::activeCheckBoxControlGroup($model, 'show_title'); ?>
            <?php echo BsHtml::activeTextFieldControlGroup($model, 'title', array('size' => 255, 'maxlength' => 255)); ?>
            <div class="form-group">
                <div class="row">
                    <?php echo $form->labelEx($model, 'text', array("class" => "col-xs-2 control-label")); ?>
                    <div class="col-xs-12">
                        <?php echo BsHtml::activeTextArea($model, 'text', array("class" => "form-control text-editor")); ?>
                    </div>
                </div>
                <div class="col-xs-10 col-xs-offset-2 text-danger"><?php echo $form->error($model, 'text'); ?></div>
            </div>
            <?php echo BsHtml::activeTextFieldControlGroup($model, 'cssclass', array('size' => 255, 'maxlength' => 255)); ?>
        </div> 
    </div> 
</div>



<div class="form-bottom">
    <?php echo CHtml::Link("← Назад", array('/backend/blocks', 'position' => $position), array("class" => "btn btn-danger")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class" => "btn btn-primary")) ?>
</div>

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/ckeditor.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/adapters/adapterjquery.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckfinder/ckfinder.js', CClientScript::POS_HEAD); ?>
<style>
    .template_id_wrap{
        display: none;
    }
    .list-materials{
        list-style-type: none;
    }
</style>
<script>
    function showTitle() {
        if ($('#Blocks_show_title').prop('checked')) {
            $('#Blocks_title').closest('.form-group').show();
        } else {
            $('#Blocks_title').val(null)
            $('#Blocks_title').closest('.form-group').hide();
        }
    }
    function checkSelectedType() {
        if ($('#Blocks_type').val()) {
            $('#Blocks_template_id option').each(function( index ) {
                if(index > 0) $(this).remove();
            });
            $('#settings').empty();
            $.getJSON('<?php echo Yii::app()->createUrl('/backend/blocks/findtemplates', array('position' => $position))?>', 
            {type: $('#Blocks_type').val()},
            function($json){
                $.each( $json, function( key, val ) {
                    $('#Blocks_template_id').append( "<option value='" + key + "'>" + val + "</option>" );
                });
                 $('.template_id_wrap').show();
            });
        } else {
            $('.template_id_wrap').hide(function(){
                $('#Blocks_template_id option').each( function(index) {
                    if(index != 0) $( this ).remove();
                })
            });
        }
    }
    
    function checkSample() {
        $('#cred-form').ajaxSubmit({
            url: '<?php echo Yii::app()->createUrl('/backend/blocks/loadSettingsTemplate')?>',
            success: function(html) { 
                    $('#settings').html(html);
                }
            });
    }

    $(document).ready(function () {
        showTitle();
        $('#Blocks_show_title').on('change', function () {
            showTitle()
        })
        $('body').on('change', '.checkSample', function () {
            checkSample()
        })
        
        $('#Blocks_type').on('change', function () {
            checkSelectedType()
        })
        if ($(".text-editor").length)
            $(".text-editor").ckeditor(function () {
                CKFinder.setupCKEditor(this, '<?php echo Yii::app()->createAbsoluteUrl("/") ?>/inc/ckfinder/');
            });
    });</script>
