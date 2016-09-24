<?php
/* @var $this ConnectionsController */
/* @var $model Connections */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=> Yii::app()->controller->id . '-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldControlGroup($model,'name',array('size'=>255,'maxlength'=>255)); ?>
        <?php echo $form->textAreaControlGroup($model,'task', array('style'=>'width: 100%;')); ?>
        <?php echo $form->textAreaControlGroup($model,'solution', array('style'=>'width: 100%;')); ?>
        <?php echo $form->textFieldControlGroup($model,'term',array('size'=>255,'maxlength'=>25)); ?>
        <?php echo $form->textAreaControlGroup($model,'result', array('style'=>'width: 100%;')); ?>
        <?php echo $form->textAreaControlGroup($model,'description', array('class'=>'text-editor', 'style'=>'width: 100%;')); ?>

    
</div>
	<div class="buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn btn-primary')); ?>
		<?php echo BsHtml::link('Отмена',array('/backend/fuels'), array('class'=>'btn btn-danger')); ?>
	</div>

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/ckeditor.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckeditor/adapters/adapterjquery.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile('/inc/ckfinder/ckfinder.js', CClientScript::POS_END); ?>

<script type="text/javascript">
    jQuery(function () {
        if ($(".text-editor").length){
            $(".text-editor").each(function(){
                $(this).ckeditor(function () {
                    CKFinder.setupCKEditor(this, '/inc/ckfinder/');
                });
            });
        }
    })
</script>
</div><!-- form -->