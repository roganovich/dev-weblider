<?php 
if($materials):?>
    <?php foreach ($materials as $material):?>
        <li>
        <div class="checkbox">
            <label>
                <input value='<?php echo $material->id?>' type="checkbox" value='<?php echo $material->id?>' name='<?php echo $model->settings->tableName()?>[ids][]' <?php if($model->settings->ids && in_array($material->id, $model->settings->ids)):?>checked<?php endif ?>> 
                <span style="padding-left: <?php echo $step * 20?>px"><i><small>(материал)</small></i> <?php echo $material->title?></span>
            </label>
        </div>
        </li>
    <?php endforeach ?>
<?php endif; ?>
