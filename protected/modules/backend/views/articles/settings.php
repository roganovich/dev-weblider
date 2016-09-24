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
<div class="row">
    <div class="col-sm-4">
        <?php echo $form->dropDownListControlGroup($model, 'sortBy', ArticlesSettings::$sortTypes, array('class' => 'sort_by'));?>
    </div>
    <div class="col-sm-4 sort_direction">
        <?php echo $form->dropDownListControlGroup($model, 'sortDirection', ArticlesSettings::$sortDerections);?>
    </div>
</div>
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
    function checkSortBy(){
        if($('.sort_by').val() == 'level'){
            $('.sort_direction').hide();
            $('.sort_direction select option').each(function() { $(this).prop('selected', $(this).text() == 'ASC')});
        } else {
            $('.sort_direction').show();
        }
    }
    $(function(){
        checkUseCrop();
        checkSortBy();
        $('.usecrop').on('change', function(){
            checkUseCrop();
        })
        $('.sort_by').on('change', function(){
            checkSortBy();
        })
    })
</script>
<?php $this->endWidget(); ?>
