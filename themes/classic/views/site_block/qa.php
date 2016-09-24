<?php $questions = Qa::model()->findAll();
if($questions):?>
<div id="qa" class="qa  site_block">
    <div class="container">
        <?php foreach ($questions as $one): ?>
        <?php echo $this->renderPartial('/site_block/qa/_question', array('model' => $one))?>
        <?php endforeach ?>
    </div>
</div>
<?php endif; ?>