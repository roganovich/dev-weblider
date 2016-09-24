<div id='reserve' class="reserve  site_block">
    <div class="container text-center">
        <div class="site_block_header">
            Оформление резерва    
        </div>
        <div class="errorMessage" id="reserveFormResult"></div>
        <?php
        $model = new Reserves();
        $form = $this->beginWidget('BsActiveForm', array(
            'layout' => BsHtml::FORM_LAYOUT_INLINE,
            'action' => Yii::app()->createUrl('site/reserve'),
            'id' => 'reserve-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <div>
        <?php echo $form->textFieldControlGroup($model, 'name'); ?>
        <?php echo $form->textFieldControlGroup($model, 'phone'); ?>
        <?php echo $form->textFieldControlGroup($model, 'email'); ?>
        </div>
        <div>Резервировать на дату
        <?php echo $form->dateFieldControlGroup($model, 'datereserve'); ?>
        <?php echo $form->textFieldControlGroup($model, 'amount'); ?>
        </div>
        <?php
        echo BsHtml::ajaxSubmitButton('Оформить резерв', CHtml::normalizeUrl(array('site/reserve', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                        
                        if(data.status=="success"){
                            $("<div class=\'alert alert-success\' role=\'alert\'></div>").html(data.msg).appendTo("#reserveFormResult");                                                    
                            $("#reserve-form")[0].reset();
                        } else{
                            $.each(data, function(key, val) {
                                $("<div class=\'alert alert-danger\' role=\'alert\'></div>").text(val).appendTo("#reserveFormResult");                                                    
                            });
                        }       
                    }',
                    'beforeSend' => 'function(){                        
                        $("#reserveFormResult").empty();  
                    }'
                ), array('id' => 'reserve-btn', 'class' => 'btn btn-default'));
        ?>
<?php $this->endWidget(); ?>
    </div>
</div>