<?php 
if($sections):?>
    <?php foreach ($sections as $section):?>
        <li>
        <div class="checkbox">
            <label>
                <input value='<?php echo $section->id?>' onchange="checkMaterialsForBlock($(this).closest('li'))" type="checkbox" name='<?php echo $model->settings->tableName()?>[ids][]' <?php if($model->settings->ids && in_array($section->id, $model->settings->ids)):?>checked<?php endif ?>> 
                <span style="padding-left: <?php echo $step * 20?>px"><?php echo $section->title?></span>
            </label>
        </div>
        <?php $this->renderPartial('/blocks/settings/sections/_line', array(
            'sections' => $section->childs,
            'model' => $model,
            'step' => $step+1,
        ));?>
        <?php $this->renderPartial('/blocks/settings/sections/_lineList', array(
            'materials' => $section->allMaterials,
            'model' => $model,
            'step' => $step+1,
        ));?>
        </li>
    <?php endforeach ?>
<?php endif; ?>
