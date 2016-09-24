<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('ext.position.PositionWidget', array('name' => 'position1')); ?>
<div class="container">
    <?php $this->widget('ext.position.PositionWidget', array('name' => 'position2')); ?>
    <?php echo $content; ?>
    <?php $this->widget('ext.position.PositionWidget', array('name' => 'position3')); ?>
</div>
<?php $this->widget('ext.position.PositionWidget', array('name' => 'position6')); ?>
<?php $this->endContent(); ?>