<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseBlockHelper
 *
 * @author andrey
 */
class BaseBlockHelper extends CComponent {
    private $_blockSettings;
    
    public function setBlockSettings($block){
        $this->_blockSettings = $block;
    }

    public function getBlockSettings(){
        return $this->_blockSettings;
    }
}
