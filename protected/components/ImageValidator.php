<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageValidator
 *
 * @author andrey
 */
class ImageValidator  extends CFileValidator {
    public $types = 'jpg, png';
    public $allowEmpty = true;

    protected function validateAttribute($object, $attribute) {
        $document = CUploadedFile::getInstance($object,$attribute);
        if($document){
            $object->$attribute = $document;
            $this->validateFile($object, $attribute, $document);
            if(!$object->getErrors($attribute)){
                $sourcePath = pathinfo($document->getName());  
                $filename = md5($sourcePath['basename']).time().'.'. $sourcePath['extension'];
                $document->saveAs( Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'].$filename);
                $object->$attribute = $filename;
            }
        }
    }
}