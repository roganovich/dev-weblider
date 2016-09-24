<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"></meta>
        <?php Yii::app()->clientScript->registerCssFile("/bootstrap/css/bootstrap.min.css"); ?>
        <?php Yii::app()->clientScript->registerScriptFile('/bootstrap/js/bootstrap.min.js', CClientScript::POS_HEAD); ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>