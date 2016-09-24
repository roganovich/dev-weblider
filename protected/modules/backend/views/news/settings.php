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
    <?php echo CHtml::errorSummary($model); ?>
</div>
<?php echo $form->textFieldControlGroup($model, 'count_materials', array('size' => 255, 'maxlength' => 255)); ?>
<?php echo $form->checkBoxControlGroup($model, 'usecrop', array('class' => 'usecrop','size' => 255, 'maxlength' => 255)); ?>
<div class="row cropData" style="display: none;">
    <div class="col-sm-4">
        <?php echo $form->textFieldControlGroup($model, 'width', array('size' => 255, 'maxlength' => 255)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldControlGroup($model, 'height', array('size' => 255, 'maxlength' => 255)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListControlGroup($model, 'position', Options::$cropPositions); ?>
    </div>
</div>

<div class="form-bottom">
    <?php echo CHtml::Link("← Назад", $backUrl, array("class" => "btn btn-danger")); ?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array("class" => "btn btn-primary")) ?>
</div>
<script>
    function checkUseCrop(){
        if($('.usecrop').prop('checked')){
            $('.cropData').show();
        } else {
            $('.cropData').hide();
            $('.cropData input').each(function(){
                $(this).val(null);
            });
        }
    }
    $(function(){
        checkUseCrop();
        $('.usecrop').on('change', function(){
            checkUseCrop();
        })
    })
</script>
<?php $this->endWidget(); ?>
