<div class="form">
    <?php
    $this->h1Title = 'Подготовка к рассылке письма "' . $model->letter->name . '"';
    $form = $this->beginWidget('BsActiveForm', array(
        'id' => Yii::app()->controller->id . '-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-3">
            <?php
            echo $form->dropDownListControlGroup($model, 'group_id', CHtml::listData(
                            GroupSubscribers::model()->findAll(), 'id', 'name'), array('empty' => 'Выберите группу подписчиков'));
            ?>        </div>
        <div class="col-md-3">
            <?php
            echo $form->dropDownListControlGroup($model, 'mailer_id', CHtml::listData(
                            Mailers::model()->findAll(), 'id', 'name'), array('empty' => 'Выберите отправителя'));
            ?>         </div>
        <div class="col-md-3 buttons" style="padding-top: 25px;">
            <?php echo BsHtml::submitButton('Добавить в рассылку', array('class' => 'btn btn-primary')); ?>
            <?php echo BsHtml::link('Отмена', array('/backend/letters'), array('class' => 'btn btn-danger')); ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->
