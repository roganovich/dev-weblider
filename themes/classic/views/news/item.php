<div class="item-view <?php echo Yii::app()->getController()->id?>-view-item">
    <h1 class="title"><?php echo $model->title ;?></h1>
    <?php if($model->thumb): ?>
        <?php echo BsHtml::image($model->thumbCrop);?>
    <?php endif?>
    <div><?php echo $model->text ;?></div>
    <div class="clearfix">
        <span class="pull-left small">Добавлено: <?php echo $model->createdAtForView ;?></span>
    </div>
    <?php echo $this->renderPartial('/news/itemEdit', array('model' => $model, 'return' => 'view'))?>
</div>