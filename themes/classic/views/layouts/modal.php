<?php /* @var $this Controller */ ?><!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <meta charset="utf-8" />        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        <meta name="viewport" content="width=device-width, initial-scale=1.0" />        <meta name="robots" content="noindex, nofollow" />        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->        <!--[if lt IE 9]>          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>        <![endif]-->        <?php Yii::app()->clientScript->registerCssFile("/bootstrap/css/bootstrap.min.css"); ?>        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/ui.css"); ?>        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/style.css"); ?>        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'); ?>                <title><?php echo CHtml::encode($this->pageTitle); ?></title>    </head>    <body>        <div class="modal-body">            <?php echo $content; ?>         </div>        <?php Yii::app()->clientScript->registerScriptFile('/bootstrap/js/bootstrap.min.js', CClientScript::POS_HEAD); ?>        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_HEAD); ?>        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/func.js', CClientScript::POS_HEAD); ?>        <?php if (!Admin::current()):            Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/block.js', CClientScript::POS_HEAD);            Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/func_admin.js', CClientScript::POS_HEAD);        endif ?>        <div id="msg-box"></div>    </body></html>