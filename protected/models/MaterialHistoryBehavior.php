<?php
class MaterialHistory extends CActiveRecordBehavior 
{
   public $actionsTrack = array();
   public $actionsNotTrack = array();
   public $attributesTrack = array();
   public $attributesNotTrack = array();
   
     public function beforeSave($event){
       $owner = $this->owner; //material class 
       $className = get_class($owner);//material class name
       $classAttributes = $owner['attributes']; //new material attributes
       $matarial_id = $classAttributes['id']; // changed material id
       
        //create new history params
       $add_history['matarial_id']=$matarial_id;
       $add_history['matarial_type']=$className;
       
        //find old model before change
       $old_model = $owner->findByPk($matarial_id);
       $oldModelAttributes = $old_model['attributes'];//old material attributes
     
       //check changed
       foreach ($classAttributes as $nameAttr=>$valueAttr)
            if(in_array($nameAttr, $this->attributesTrack) && !in_array($nameAttr, $this->attributesNotTrack) && $oldModelAttributes[$nameAttr]<>$valueAttr)
                $add_history['attributes'][$nameAttr]=$valueAttr;
       
        //save the new changes to history  
        if($add_history['attributes'])
            $addToHistory($add_history);
      
    }
    
    //save the new changes to history  function
    public function addToHistory($param){
        
    }
    //if you want to kill the material
    public function beforeDelete($event){
        $owner = $this->owner;
        echo '<pre>';
        print_r($owner);
        echo '</pre>';
        die();
    }
}