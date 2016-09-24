
<?php
$this->h1Title = 'Виды топлива';

/* @var $this ConnectionsController */
/* @var $model Connections */

$this->breadcrumbs = array(
    'Connections' => array('index'),
    'Manage',
);

EYii::getFlash();
?>
<p class="buttons">
    <?php echo BsHtml::link('Добавить вид топлива', array('/backend/fuels/create'), array('class' => 'btn btn-default')); ?>
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
