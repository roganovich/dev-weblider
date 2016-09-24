<div class="content-view">
    <?php if(Admin::current()):?>
    <a class="edit-settings btn btn-danger" href="<?php echo Yii::app()->createUrl('backend/sections/content', array('id'=> $model->id, 'return' => 'view'))?>">Редактировать раздел</a>
    <?php endif; ?>
    <?php if($model->content->title):?>
    <h1 class="title"><?php echo $model->content->title?></h1>
    <?php endif; ?>
    <?php if($model->content->text):?>
    <div class="content-text"><?php echo $model->content->text?></div>
    <?php endif; ?>
</div>