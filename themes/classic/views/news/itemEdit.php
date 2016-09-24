<?php if (Admin::current()): ?>
    <div class="btn-group pull-right admin_edit_func">    
        <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle">    
            <?php if(!$model->active): ?>       не активен    <?php else : ?>     активен    <?php endif ?>   
            <span class="caret"></span></button>    
        <ul class="dropdown-menu">        
            <li><a href="<?php echo Yii::app()->createUrl('backend/news/update', array('id' => $model->id, 'return' => $return)) ?>">Редактировать</a></li>        
            <li><a href="<?php echo Yii::app()->createUrl('backend/news/delete', array('id' => $model->id, 'return' => 'list')) ?>" onClick="return window.confirm('Удалить материал <?php BsHtml::encode($model->title) ?>?')" title="Удалить материал">Удалить</a></li>    
        </ul>
    </div>
<?php endif; ?>