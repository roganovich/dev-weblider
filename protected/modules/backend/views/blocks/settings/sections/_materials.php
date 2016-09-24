<?php 
if($sections):?>
    <ul class="list-materials">
    <?php foreach ($sections as $section):?>
        <li>
        <div class="checkbox">
            <label>
                <input value='<?php echo $section->id?>' onchange="checkMaterialsForBlock($(this).closest('li'))" type="checkbox" name='<?php echo $model->settings->tableName()?>[ids][]' <?php if($model->settings->ids && in_array($section->id, $model->settings->ids)):?>checked<?php endif ?>> <?php echo $section->title?>
            </label>
        </div>
        <?php $this->renderPartial('/blocks/settings/sections/_materials', array(
            'sections' => $section->childs,
            'model' => $model,
        ));?>
        <?php $this->renderPartial('/blocks/settings/sections/_materialList', array(
            'materials' => $section->allMaterials,
            'model' => $model,
        ));?>
        </li>
    <?php endforeach ?>
    </ul>
<?php endif; ?>
