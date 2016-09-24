<?php if($model->errors):?>
	<?php echo BsHtml::errorSummary($model); ?>
<?php else:?>
<div class="description">
    <p>Рассмотрим затраты на отопление дома, общей площадью <span id='homeAreaVal'><?= $model->homeArea ?></span> кв.м. и высотой потолков <span id='ceilingHeightVal'><?= $model->ceilingHeight ?></span></p>
    <p>При сравнении затрат на отопление будем исходить и   з условия что котел находится в работе примерно 50% общего времени, а отопительный сезон длится 7 месяцев.</p>
</div>
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($fuels as $index => $fuel): ?>
            <li style="width: <?php echo floor(100 / count($fuels)) ?>%" role="presentation" class="<?php if ($index == 0): ?>active<?php endif ?>"><a href="#fuel<?php echo $fuel->id ?>" aria-controls="fuel<?php echo $fuel->name ?>" role="tab" data-toggle="tab"><?php echo $fuel->name ?><br/>
                    <b><?php echo number_format($fuel->calculatePrice($model->homeArea * $model->ceilingHeight, $model->kpd), 0, ".", " ") ?></b>&nbsp;руб
                </a></li>
        <?php endforeach ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php foreach ($fuels as $index => $fuel): ?>
            <div role="tabpanel" class="tab-pane <?php if ($index == 0): ?>active<?php endif ?>" id="fuel<?php echo $fuel->id ?>">
                <div class="clearfix">
                    <div class="col-xs-5 left-panel">
                        <p>
                            <?php echo $fuel->getAttributeLabel('calorific') ?>: <?php echo $fuel->calorific ?> МДж/<?php echo $fuel->units ?>
                        </p>
                        <p>
                            <?php echo $fuel->getAttributeLabel('price') ?>: <?php echo $fuel->price ?>
                            руб/<?php
                            if ($fuel->units == 'кг' && $fuel->priceFor1000) {
                                echo 'тонна';
                            } else if ($fuel->units != 'кг' && $fuel->priceFor1000) {
                                echo '1000' . $fuel->units;
                            } else {
                                echo $fuel->units;
                            }
                            ?>
                            <?php echo $fuel->priceComment ?>
                        </p>
                        <p> Годовой рассход топлива: 
                            <?php echo number_format($fuel->calculateAmount($model->homeArea * $model->ceilingHeight, $model->kpd), 3, ".", " ") ?> <?php
                            if ($fuel->units == 'кг' && $fuel->priceFor1000) {
                                echo 'тонн';
                            } else if ($fuel->units == 'кг' && $fuel->translate) {
                                echo 'куб. м.';
                            } else {
                                echo $fuel->units;
                            }
                            ?>
                        </p>
                        <p> Затраты на отопительный сезон: 
                            <?php echo number_format($fuel->calculatePrice($model->homeArea * $model->ceilingHeight, $model->kpd), 0, ".", " ") ?></b>&nbsp;руб
                        </p>
                    </div>
                    <div class="col-xs-7">
                        <?php echo $fuel->description;?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?php endif?>