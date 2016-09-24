<div class="list-view-item <?php echo Yii::app()->getController()->id?>-list-view-item">
    <div><a href="<?php echo $data->link ;?>"><?php echo $data->title ;?></a></div>
    <div class="row">
    <?php if($data->thumb): ?>
        <div class="col-xs-6 col-md-3">
            <a href="<?php echo $data->link ;?>" class="thumbnail">
                <?php echo BsHtml::image($data->thumbCrop, BsHtml::encode($data->title));?>
            </a>
        </div>
    <?php endif?>
        <div class="<?php if($data->thumb): ?>col-xs-6 col-md-9<?php else:?>col-xs-12<?php endif?>">
            <?php echo $data->anons ;?>
            <div class="clearfix">
                <span class="pull-left small">Добавлено: <?php echo $data->createdAtForView ;?></span>
                <a class="pull-right" href="<?php echo $data->link ;?>">Подробнее</a>
            </div>
        </div>
    </div>
    
    <?php echo $this->renderPartial('/news/itemEdit', array('model' => $data, 'return' => 'list'))?>
</div>