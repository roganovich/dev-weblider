
<?php
$this->h1Title = 'Работы';

EYii::getFlash();
?>
<p class="buttons">
    <?php echo BsHtml::link('Добавить работу', array('create'), array('class' => 'btn btn-default')); ?>
</p>
<?php
$this->widget('BsGridView', array(
    'id' => 'fuels-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'columns' => array(
        'name',
        array(
            'name' => 'description',
            'type' => 'raw',
        ),
        'calorific',
        'units',
        'price',
        array(
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
