<?php

/**
 * Description of CategoryLinker
 *
 * @author andrey
 */
class CategoryLinker extends CActiveRecordBehavior{
    public $newCategoryArray = '';
    
    public function updateCategoryLinks(){
        if($this->owner->{$this->newCategoryArray}){
            
        }
    }
}
