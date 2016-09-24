<header>
    <div class='static-bg'></div>
        <?php echo $this->renderPartial('/site_block/headerBlocks/_logo_block');?>
        <?php echo $this->renderPartial('/site_block/headerBlocks/_top_menu');?>
</header>
    <div class="site_block_header">
        Мгновенный розыгрыш приза
    </div>
<div class="container text-center">
<?php echo OptionsRegistr::getInstance()->get('game_description');?>
</div>
<div class="game-wrap">
    <ul class="list-unstyled list-items clearfix">
        <?php foreach($items as $item):?>
        <li class='item' title="Нажмите если считаете, что приз спрятан за этим квадратом">
            <?php if($item > 0):?>
            <img src='/images/item6img.png' />
            <div class="number"><?php echo $item; ?></div>
            <?php endif; ?>
            <div class="wraper"></div>
        </li>
        <?php endforeach ?>
    </ul>
    <div class="msg"></div>
</div>
<p class="text-center">Выделено <span id='countSelected'>0</span> из <?php echo OptionsRegistr::getInstance()->get('squares_count');?> возможных</p>
<p class="text-center"><button class="btn btn-danger btn-lg start-game">Играть</button></p>
<script>
    function showMsg(msg, status){
        $('.game-wrap .msg').html("<span>"+msg+"</span>").fadeIn();
        $.get('<?php echo Yii::app()->createUrl('game/index', array('order' => $model->id, 'code' => $model->code))?>', {game: status});
    }
    $(function(){
        var countSelected;
        $('.list-items .item').bind('click', function(){
            if($('.list-items .item.active').size() < <?php echo OptionsRegistr::getInstance()->get('squares_count');?>){
                $(this).toggleClass('active');
            } else {
                 $(this).removeClass('active');
            }
            countSelected = $('.list-items .item.active').size();
            $('#countSelected').text(countSelected);
            if(countSelected == <?php echo OptionsRegistr::getInstance()->get('squares_count');?>){
                $('.start-game').show();
            } else {
                $('.start-game').hide();
            }
        })
        $('.start-game').on('click', function(){
            $(this).remove();
            $('.list-items .item').unbind('click');
            $('.list-items .item .wraper').fadeOut(1000);
            var founded = 0;
                var msg = 'Неудача';
                var status = 'fail';
                
                $('.list-items .item.active').each(function(){
                    if($(this).find('.number').size()){
                        var num = parseInt($(this).find('.number').text());
                        if(num > founded) founded = num;
                        $(this).css({borderColor: 'red'})
                    }
                })
                if(founded > 0){
                    var countName = 'упаковки';
                    if(founded == 1){
                        countName = 'упаковку';
                    }
                    msg = 'К Вашему заказу Вы получите дополнительно '+founded+' '+countName;
                    status = founded;
                }
                
                showMsg(msg,status)
        })
    })
</script>