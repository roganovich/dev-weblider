<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imageResizer
 *
 * @author andrey
 */
Yii::import('ext.easyimage.EasyImage');
class imageResizer extends CComponent{
    public $image;
    public $width = 300;
    public $height = 200;
    public $position = 'center-center';
    
    public function __construct($params = array()) {
        foreach($params as $prop => $val){
            if(property_exists('imageResizer', $prop)){
                $this->$prop = $val;
            }
        }
    }

    public function run()
    {
        $this->checkAlbumPath();
        if(!file_exists($this->filePath)){
            $image = new EasyImage(Yii::app()->params['imageStorageFolder'].$this->image);
            $image->crop($this->width, $this->height, $this->position);
            $image->resize($this->width, $this->height);
            $image->save($this->filename);
        }
        return DIRECTORY_SEPARATOR.$this->filename;
    }
    
    public function getAlbumPath(){
        return Yii::getPathOfAlias('webroot'). DIRECTORY_SEPARATOR . Yii::app()->params['imageStorageFolder'].$this->width."_".$this->height;
    }
    
    public function getFilename(){
        $file_part = explode(".",array_pop(explode("/", $this->image)));
        $file_extention = array_pop($file_part); 
        $file_name = implode(".", $file_part);
        return Yii::app()->params['imageStorageFolder'].$this->width."_".$this->height . DIRECTORY_SEPARATOR . $file_name.$this->position.".".$file_extention;
    }
    
    public function getFilePath(){
        return Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR .$this->filename;
    }


    private function checkAlbumPath(){
        if(!file_exists($this->albumPath)) {
            mkdir($this->albumPath);
        }
    }
}
