<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'FuelsCalculator-form',
    'action' => Yii::app()->createUrl('/site/calculate'),
    'enableAjaxValidation' => false,
        ));
?>
<div class="site_block_header">
    Сравнительный расчет затрат на отопитеьный сезон дома различными видами топлива
</div>
<div class="site_block_header calculator_header">
    Отапливаемая площадь <input id='FuelsCalculator_homeArea' name="FuelsCalculator[homeArea]" value="<?= $model->homeArea ?>">кв.м.
    <div class="helper homeArea_helper">Укажите отапливаемую площадь</div>
    <span>Высота потолков <input id='FuelsCalculator_ceilingHeight' name="FuelsCalculator[ceilingHeight]" value="<?= $model->ceilingHeight ?>">м</span>
    <div class="helper ceilingHeight_helper">Укажите высоту потолков</div>
    КПД котла <input id='FuelsCalculator_kpd' name="FuelsCalculator[kpd]" value="<?= $model->kpd ?>">%
    <div class="helper kpd_helper">Укажите КПД котла</div>

</div>
<div class="examples text-center">
    Пример рассчета для:<br/>
    <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-default" data-kpd="97">Конденсационный котел (КПД до 97%)</button>
        <button type="button" class="btn btn-default" data-kpd="93">Специальный котел (КПД до 93%)</button>
        <button type="button" class="btn btn-default" data-kpd="85">Котел с газификацией (КПД 85%)</button>
        <button type="button" class="btn btn-default" data-kpd="65">Классический котел (камин или дровяная печь КПД 65%)</button>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    $("#FuelsCalculator_homeArea, #FuelsCalculator_ceilingHeight, #FuelsCalculator_kpd").on('change, keyup', function () {
        submitCalculatorForm();
    })
    $(".calculator .examples button").on('click', function () {
        $('#FuelsCalculator_kpd').val($(this).data('kpd'));
        submitCalculatorForm();
    })
</script>