<nav id="adminmenu" class="navbar navbar-fixed-bottom inactive" role="navigation">
    <ul class="nav navbar-nav">
        <li><a href="<?php echo Yii::app()->createUrl('/backend/logout') ?>"> Выход </a></li>
        <li><a href="<?php echo Yii::app()->createUrl('/backend/sections') ?>">Разделы</a></li>
        <li><a href="<?php echo Yii::app()->createUrl('/backend/options') ?>">Настройки</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right show_position">
        <li class="dropdown">
            <button id="show_position" class="btn primary" onclick="show_hidePosition($(this))">Показать/Скрыть позиции</button>
            <button class="btn primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu pull-right">
                <li><a href="<?php echo Yii::app()->createUrl('/backend/templates') ?>" >Шаблоны</a></li>
            </ul>
        </li>
    </ul>
    <div class="layer">Админменю</div>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/block.js', CClientScript::POS_HEAD); ?>
</nav>