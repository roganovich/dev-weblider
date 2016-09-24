
<?php
$this->h1Title = 'Шаблоны блоков';
?>
<p class="buttons">
    <?php echo BsHtml::link('Добавить шаблон блока', array('/backend/templates/create'), array('class' => 'btn btn-default')); ?>
</p>
<?php
$this->widget('BsGridView', array(
    'id' => 'templates-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'columns' => array(
        'name',
        'file',
        'typeName',
        array(
            'name' => 'positions',
            'type' => 'raw',
            'value' => function($data){
                if($data->positions){
                    foreach ($data->positions as $position){
                        $str[] = Yii::app()->params['positions'][$position];
                    }
                    return implode("<br />", $str);
                }
            }
        ),
        'comment',
        array(
            'class' => 'bootstrap.widgets.BsButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
