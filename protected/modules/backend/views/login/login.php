<?php $this->pageTitle = "Страница для Входа"; ?>
<div class="clearfix">
    <div class="col-xs-4 col-xs-offset-4">
        <div class="bordered-form">
            <?php if (Yii::app()->user->hasFlash('loginMessage')): ?>
                <div class="success">
                    <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                </div>
            <?php endif; ?>
            <?php
            $UserLoginForm = $this->beginWidget('BsActiveForm', array(
                'id' => 'admin-login',
                'action' => Yii::app()->createUrl('/backend/login'),
                'htmlOptions' => array(
                    'class' => "myform",
                    'role' => "form",
                ),
            ));
            echo $UserLoginForm->textFieldControlGroup($UserLogin, 'username', array(
                'labelOptions' => array('style' => 'display: none;'),
            ));
            echo $UserLoginForm->passwordFieldControlGroup($UserLogin, 'password', array(
                'labelOptions' => array('style' => 'display: none;'),
            ));
            ?>	
            <div class="checkbox">
                <label><?php echo CHtml::activeCheckBox($UserLogin, 'rememberMe'); ?><span>Запомнить меня</span></label>
            </div>
            <p>
                <?php echo CHtml::SubmitButton('Войти', array('type' => 'POST', 'class' => 'btn btn-store btn-block',)); ?>
            </p>
            <?php $this->endWidget(); ?>
        </div>	
    </div>	
</div>