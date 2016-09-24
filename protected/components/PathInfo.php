<?php

class PathInfo extends CComponent {

    static private $instance;
    private $_material;

    private function __construct() {
        
    }

    static function getInstance() {
        if (empty(self::$instance))
            self::$instance = new PathInfo();
        return self::$instance;
    }

    public function getMaterial() {
        return $this->_material;
    }

    public function parseUrl($pathInfo) {
        //echo $pathInfo; Yii::app()->end();
        if (!$pathInfo) {
            $model = Materials::getIndexPage();
        } else {
            $model = Materials::getOneByPage($pathInfo);
        }
        if ($model) {
            $this->_material = $model;
            $_GET['id'] = $model->id;
            return $model->type . '/view';
        }
        return false;
    }

}
