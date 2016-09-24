<div class="row">
    <div class="col-xs-6">
        <?php
        echo BsHtml::activeDropDownListControlGroup($model->settings, 'sample', $model->settings->samples(), array(
            'empty' => 'Выберите тип выборки материалов',
            'class' => 'checkSample',
        ));
        ?>
    </div>
</div>
<div id='settingsWrap'>
    <?php if($model->settings->template): ?>
        <?php echo $this->renderPartial($model->settings->template, array(
            'model'=>$model,
        )); ?>
    <?php endif ?>
</div>