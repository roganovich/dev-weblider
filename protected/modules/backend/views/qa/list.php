
<?php
$this->h1Title = "Статистика по отправке письма '" . $model->letter->name . "'";
EYii::getFlash();
?>
<div class="buttons">
    <?php if (!$model->submited) echo BsHtml::link('Удалить не разосланные', array('/backend/letters/deleteAllSubscribers', 'id' => $model->letter_id), array('class' => 'btn btn-danger')); ?>
    <?php echo BsHtml::link('Назад', array('/backend/letters'), array('class' => 'btn btn-danger')); ?>
</div>
<?php
$this->widget('BsGridView', array(
    'id' => 'connections-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'filter' => false,
            'header' => 'Статус',
            'type' => 'raw',
            'value' => 'BsHtml::bsLabel($data->subscriber->statusLabelName, array("color" => $data->subscriber->statusLabelColor))'
        ),
        'subscriber.fio',
        'subscriber.email',
        'subscriber.phone',
        array(
            'name' => 'subscriber.connection.name',
            'filter' => BsHtml::dropDownList(
                    'SubscribersHistory[connection_id]', $model->connection_id, CHtml::listData(
                            Connections::model()->findAll(), 'id', 'name'), array('empty' => 'Все')),
        ),
        'datecreate',
        array(
            'name' => 'datesubmit',
            'visible' => !$model->prepeared
        ),
        array(
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{delete}',
            'visible' => $model->prepeared,
            'buttons' => array(
                'delete' => array(
                    'visible' => '!$data->datesubmit',
                    'url' => 'Yii::app()->createUrl("/backend/letters/deleteSubscriber", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
));
?>