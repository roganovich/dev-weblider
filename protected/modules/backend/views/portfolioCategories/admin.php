
<?php
$this->h1Title = 'Категории портфолио';

EYii::getFlash();
?>
<p class="buttons">
    <?php echo BsHtml::link('Добавить категорию', array('create'), array('class' => 'btn btn-default')); ?>
</p>
<?php
$this->widget('BsGridView', array(
    'id' => 'fuels-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'columns' => array(
        'name',
        'count',
        array(
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
