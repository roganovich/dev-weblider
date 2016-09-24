<div class="sectionsForBlock">
<?php $this->renderPartial('/blocks/settings/sections/_sections', array(
    'sections' => SectionsView::findAllGeneral(),
    'model' => $model,
));?>
</div>
<script>
    $(function(){
        checkMaterialsForBlock($('.sectionsForBlock'));
    })
</script>
