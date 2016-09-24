<div id="<?php echo $name?>" class="site_position <?php echo $cssclass?> <?php if(!$skipclear):?>clearfix<?php endif?>">
    <?php $helper = new PositionHelper($name)?>
    <?php if($helper->blockInPosition):?>
        <?php foreach($helper->blockInPosition as $block):?>
                    <div class="site_block_item <?php echo $block->cssclass?>">
                        <?php if(Admin::current()):?>
                            <div data-toggle="tooltip" class="show_block_info" title="Панель редактирования блока сайта '<?php echo BsHtml::encode($block->name)?>'">
                                <span class="glyphicon glyphicon-move"></span>
                            </div>
                        <?php endif?> 
                        <?php if($block->show_title && $block->title):?>
                            <div class="block-title">
                                <?php if($block->material_id):?>
                                    <a href="<?php echo $block->materialLink?>"><?php echo $block->title?></a>
                                <?php else:?>
                                    <?php echo $block->title?>
                                <?php endif?>
                            </div>
                        <?php endif?>
                        <?php if($block->text):?>
                            <div class="block-text">
                                <?php echo $block->text?>
                            </div>
                        <?php endif?>
                    <?php if($block->template):  
//                        $this->renderPartial('//patterns/'.$block->template, array(
//                            'block' => $block,
//                        ));
                    endif?>
                </div>

            <?php endforeach?>
    <?php endif?>
    <?php if(Admin::current()):?>
        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/blocksEdit.css"); ?>
        <div class="show_admin_position_panel" title="Панель создания, редактирования блоков внутри позиции <?php echo $name?>" onclick="showPositionIndex($(this))"><span class="glyphicon glyphicon-align-left"></span></div>
    <?php endif?>
</div>