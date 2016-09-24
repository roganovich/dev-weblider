<div class="logo_block">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <a href="/" class="logo">
                    <div class="topLine"><span class="grey">WEB</span><span class="white">Lider</span></div>
                    <div class="bottomLine"><span class="white">От идеи</span> <span class="grey">до результата</span></div>
                </a>

            </div>
            <div class="col-xs-9 row">
                <div class="col-xs-7">
                    <div class="contacts">
                        <div class="topLine"><span class="white"><?php echo OptionsRegistr::getInstance()->get('contact_phone') ?></span></div>
                    </div>
                </div>
                <div class="col-xs-5 ">
                    <div class="contact-info text-left"><span class="grey"><?php echo OptionsRegistr::getInstance()->get('contact_info') ?></span></div>
                </div>
                <?php echo $this->renderPartial('/site_block/headerBlocks/_top_menu'); ?>
            </div>
        </div>
    </div>
</div>