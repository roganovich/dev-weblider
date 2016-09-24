<?php $this->beginContent('//layouts/main_backend'); ?>
<div class="middle container">
    <div class="content-wrap clearfix">
        <?php if ($this->h1Title): ?><h3 class="title"><?= $this->h1Title; ?></h3><?php endif; ?>
        <?php // $this->renderPartial('//site/breadcrumbs') ?>
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>