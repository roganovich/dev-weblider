<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.disable.text.select.min.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.mousewheel.min.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.reel.min.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.onitexrotozoom.min.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.onitexzoom.min.js', CClientScript::POS_HEAD); ?>
<div id="product" class="container ruf3d  site_block">
    <div class="row">
        <div class="col-xs-5"><img id="photo1855" src="/images/ruf3d/img/001.jpg" alt=""/></div>
        <div class="col-xs-7">
            <div class="site_block_header">
                <?php echo OptionsRegistr::getInstance()->get('ruf_title');?>
            </div>
            <?php echo OptionsRegistr::getInstance()->get('ruf_description');?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#photo1855').advancedRotate({
            horizontalFrames: 72, speed: -0.20, maxZoom: 1.71, autostart: true, openingSpeed: -0.20, openingDuration: 3.00
        });
    });
</script>