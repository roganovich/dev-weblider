<?php 
if(!$page):?>
<div class="view <?php echo $model->type; ?>-view">
    <?php echo $this->renderPartial('//structure/sectionViewBlock', array('model' => $model))?>
</div>
<?php endif; ?>
<?php if(Admin::current()):?>
<p class="clearfix">
    <div class="btn-group" role="group" aria-label="Управление материалами раздела">
    <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('backend/articles/create', array('p_id'=> $model->id, 'return' => 'list'))?>">Добавить</a>
    <?php if($model->settings->sortBy == 'level'):?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('backend/articles/sort', array('id'=> $model->id, 'return' => 'list'))?>">Сортировать</a>
    <?php endif; ?>
    <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('backend/articles/settings', array('id'=> $model->id, 'return' => 'list'))?>">Настройки материалов</a>
    </div>
</p>
<?php endif; ?>
<?php


$this->widget('bootstrap.widgets.BsListView',array(
	'id' => Yii::app()->getController()->id.'-items',
        'ajaxUpdate' => false,
	'dataProvider'=> $model->settings->getDataProviderForMaterials(!Admin::current()),
    'template' => ' {items}{pager}',
    'itemView' => '/articles/_item',

));
?>