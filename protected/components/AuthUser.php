<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthUser
 *
 * @author Валера
 */
class AuthUser extends CComponent {

    private $_user = null;
    private static $_current = null;

    public function getUser() {
        if (!$this->_user && !Yii::app()->user->isGuest) {
            if (Yii::app()->user->isAdmin()) {
                $this->_user = Admin::model()->findByPk(Yii::app()->user->id);
            }else if (Yii::app()->user->isClient()) {
                $this->_user = Clients::model()->findByPk(Yii::app()->user->id);
            }
        }
        return $this->_user;
    }

    public function getRole() {
        if (!$this->user) {
            return 'guest';
        } else {
            if ($this->isAdmin) {
                return 'administrator';
            } else if ($this->isUser) {
                return 'user';
            }
        }
    }

    public static function current() {
        if (!self::$_current) {
            self::$_current = new AuthUser();
        }
        return self::$_current;
    }

    public function getIsAdmin() {
        if ($this->user && is_a($this->user, "Admin"))
            return true;
        return false;
    }

    public function getIsUser() {
        if ($this->user && is_a($this->user, "Clients"))
            return true;
        return false;
    }

    static function checkAccessMenu($lnk){
        if (AuthUser::current()->isAdmin && AuthUser::current()->user->access == 3) {
            return true;
        } else if (AuthUser::current()->isAdmin && AuthUser::current()->user->access != 1) {
           if(strpos($lnk, 'admin/')){
                $lnk = str_replace('/admin/', '', $lnk);
                $lnk = substr($lnk, 0, -1);
                if( $lnk == 'perevods'){
                    $lnk = 'zayzvka_ob';
                } else{
                    $lnk .= "_ob";
                }
                
            }
            return in_array($lnk, AuthUser::current()->user->role);
        }
    }

}
