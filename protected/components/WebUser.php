<?php

class WebUser extends CWebUser {

    function getRole() {
        return AuthUser::current()->role;
    }
    
    function isAdmin(){
        return (!$this->isClient() && isset($this->isAdmin) && $this->isAdmin == 1);
    }
    
    function isClient(){
        return (!$this->isGuest && isset($this->isClient) && $this->isClient == 1);
    }
    
    public function init() {
        parent::init();
        if (preg_match("/^backend/", Yii::app()->controller->module->id)) {
            $this->loginUrl = '/backend/login';
        } else if (preg_match("/^cabinet/", Yii::app()->controller->module->id)) {
            $this->loginUrl = '/cabinet/login';
        }
    }
    
}