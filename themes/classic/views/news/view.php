<?php 
if(!$page):?>
<div class="view <?php echo $model->type; ?>-view">
    <?php echo $this->renderPartial('//structure/sectionViewBlock', array('model' => $model))?>
</div>
<?php endif; ?>
<?php if(Admin::current()):?>
<p class="clearfix">
    <a class="btn btn-primary pull-left" href="<?php echo Yii::app()->createUrl('backend/news/create', array('p_id'=> $model->id, 'return' => 'list'))?>">Добавить</a>
    <a class="btn btn-danger pull-right" href="<?php echo Yii::app()->createUrl('backend/news/settings', array('id'=> $model->id, 'return' => 'list'))?>">Настройки материалов</a>
</p>
<?php endif; ?>
<?php
$this->widget('bootstrap.widgets.BsListView',array(
	'id' => Yii::app()->getController()->id.'-items',
        'ajaxUpdate' => false,
    	'dataProvider'=> $model->settings->getDataProviderForMaterials(!Admin::current()),
    'template' => ' {items}{pager}',
    'itemView' => '/news/_item',

));
?>