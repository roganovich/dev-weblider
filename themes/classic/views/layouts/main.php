<!DOCTYPE html>
<html class="html">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php Yii::app()->clientScript->registerCssFile("/bootstrap/css/bootstrap.min.css"); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/ui.css"); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/style.css"); ?>
        <?php Yii::app()->clientScript->registerScriptFile('/bootstrap/js/bootstrap.min.js', CClientScript::POS_HEAD); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_HEAD); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/func.js', CClientScript::POS_HEAD); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/site.js', CClientScript::POS_HEAD); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'); ?>

    </head>
    <body>


        <?php echo $content; ?> 

        <div id="modal" class="modal fade"></div>
        <div id="msg-box">
            <?php $msg = Yii::app()->user->getFlash('msg'); ?>
            <?php
            $msgColor = 'alert-success';
            if (Yii::app()->user->getFlash('status') == "error")
                $msgColor = 'alert-danger';
            ?>
            <?php if ($msg): ?>
                <div class='alert <?= $msgColor ?>'><?php echo $msg; ?></div> 
            <?php endif; ?>
        </div>
        <?php if(Admin::current()):?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/admin.js', CClientScript::POS_HEAD); ?>
            <?php echo $this->renderPartial('//backend/_adminmenu');?>
        <?php endif; ?>
    </body>
</html>