<?php
$model = new FuelsCalculator();
$model->homeArea = 100;
$model->ceilingHeight = 3;
$model->kpd = 85;
$fuels = Fuels::model()->findAll();
if ($fuels):
    ?>
    <div id='calculator' class="calculator  site_block">
        <div class="container">
            <?php echo $this->renderPartial('/site_block/calculator/_top', 
                    array('model' => $model)); 
            ?>
            <div class="tabs">
            <?php echo $this->renderPartial('/site_block/calculator/_bottom', 
                    array('fuels' => $fuels,'model' => $model)); 
            ?>
            </div>
        </div>
    </div>
    <?php
 endif?>