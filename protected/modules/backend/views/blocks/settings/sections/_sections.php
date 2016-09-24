<?php 
if($sections):?>
    <ul class="list-materials">
    <?php foreach ($sections as $section):?>
        <li>
        <div class="checkbox">
            <label>
                <input onchange="checkMaterialsForBlock($(this).closest('li'))" type="checkbox" value='<?php echo $section->id?>' name='<?php echo $model->settings->tableName()?>[ids][]' <?php if($model->settings->ids && in_array($section->id, $model->settings->ids)):?>checked<?php endif ?>> <?php echo $section->title?>
            </label>
        </div>
        
        <?php $this->renderPartial('/blocks/settings/sections/_sections', array(
            'sections' => $section->childs,
            'model' => $model,
        ));?>
        </li>
    <?php endforeach ?>
    </ul>
<?php endif; ?>
