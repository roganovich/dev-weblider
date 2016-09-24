<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlockHelper
 *
 * @author andrey
 */
class DefaultHelper extends BaseBlockHelper {
    
    public function save(){
        $this->clearBlock();
        if($this->blockSettings->ids){
            foreach($this->blockSettings->ids as $material){
                $rec = new BlockMenuMaterials();
                $rec->block_id = $this->blockSettings->id;
                $rec->material_id = $material;
                $rec->save();
            }
        }
    }
    
    public function delete(){
        $this->clearBlock();
    }

    private function clearBlock(){
        BlockMenuMaterials::model()->deleteAll('block_id = '.$this->blockSettings->block_id);
    }
    
}
