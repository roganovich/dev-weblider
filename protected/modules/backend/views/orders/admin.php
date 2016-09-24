
<?php
$this->h1Title = 'Заявки';

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
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{delete}',
        ),
    ),
));
?>
