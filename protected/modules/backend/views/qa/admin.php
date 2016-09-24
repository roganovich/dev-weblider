
<?php
$this->h1Title = 'Вопросы-Ответы';

/* @var $this ConnectionsController */
/* @var $model Connections */

$this->breadcrumbs = array(
    'Connections' => array('index'),
    'Manage',
);

EYii::getFlash();
?>
<p class="buttons">
    <?php echo BsHtml::link('Добавить вопрос', array('/backend/qa/create'), array('class' => 'btn btn-default')); ?>
</p>
<?php
$this->widget('BsGridView', array(
    'id' => 'qa-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'columns' => array(
        'question',
        array(
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
