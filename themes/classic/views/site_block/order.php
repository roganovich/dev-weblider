<div id='order' class="order  site_block">
    <div class="container text-center">
        <div class="site_block_header">
            Сделайте заказ сейчас и участвуйте в мгновенном розыгрыше призов    
        </div>
        <div class="errorMessage" id="orderFormResult"></div>
        <?php
        $model = new Orders();
        $form = $this->beginWidget('BsActiveForm', array(
            'layout' => BsHtml::FORM_LAYOUT_INLINE,
            'action' => Yii::app()->createUrl('site/order'),
            'id' => 'order-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <?php echo $model->getAttributeLabel('name') ?> <?php echo $form->textFieldControlGroup($model, 'name', array('placeholder' => false)); ?> 
        <?php echo $model->getAttributeLabel('phone') ?> <?php echo $form->textFieldControlGroup($model, 'phone', array('placeholder' => false)); ?> 
        <?php echo $model->getAttributeLabel('email') ?> <?php echo $form->textFieldControlGroup($model, 'email', array('placeholder' => false)); ?> 
        <div></div>
        <?php echo $model->getAttributeLabel('amount') ?> <?php echo $form->numberFieldControlGroup($model, 'amount', array('placeholder' => false)); ?> 
        <?php echo $model->getAttributeLabel('address') ?> <?php echo $form->textFieldControlGroup($model, 'address', array('placeholder' => false)); ?> 
        <?php
        echo BsHtml::ajaxSubmitButton('Оформить заказ', CHtml::normalizeUrl(array('site/order', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                        
                        if(data.status=="success"){
                            $("<div class=\'alert alert-success\' role=\'alert\'></div>").html(data.msg).appendTo("#orderFormResult");                                                    
                            $("#order-form")[0].reset();
                        } else{
                            $.each(data, function(key, val) {
                                $("<div class=\'alert alert-danger\' role=\'alert\'></div>").text(val).appendTo("#orderFormResult");                                                    
                            });
                        }       
                        scrollTo(\'#order\');
                    }',
                    'beforeSend' => 'function(){                        
                        $("#orderFormResult").empty();  
                    }'
                ), array('id' => 'order-btn', 'class' => 'btn btn-default'));
        ?>
<?php $this->endWidget(); ?>
    </div>
</div>