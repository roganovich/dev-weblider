<?php
$cs=Yii::app()->clientScript;
$cs->scriptMap=array(
    'jquery.js'=>false,
    'jquery.ui.js' => false,
);
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Закрыть</span></button>
            <h4 class="modal-title" id="mySmallModalLabel"><?php echo $this->pageTitle ?></h4>
        </div>
        <div class="modal-body">
            <div class="clearfix">
                <?php echo $content; ?> 
            </div>
        </div>
    </div>
</div>

