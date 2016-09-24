<ul id="listForBlock" class=" list-unstyled">
<?php $this->renderPartial('/blocks/settings/sections/_line', array(
    'sections' => SectionsView::findAllGeneral(),
    'model' => $model,
    'step' => 0,
));?>
</ul>
<script>
    $(document).ready(function () {
        $("#listForBlock").sortable();
    })
</script>