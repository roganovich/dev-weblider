
<?php
$this->h1Title = 'Резервы';

/* @var $this ConnectionsController */
/* @var $model Connections */

$this->breadcrumbs = array(
    'Connections' => array('index'),
    'Manage',
);

EYii::getFlash();
?>

<?php
$this->widget('BsGridView', array(
    'id' => 'qa-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'columns' => array(
        'name',
        'phone',
        'email',
        'datecreate',
        
        array(
            'name' => 'datereserve',
            'value' => 'date("Y-m-d", strtotime($data->datereserve))'
        ),
        'amount',
        array(
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{delete}',
        ),
    ),
));
?>
