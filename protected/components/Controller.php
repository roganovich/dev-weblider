<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/client_main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $h1Title;
    public $pageDescription;
    public $pageKeywords;

    function getIsAdmin() {
        return AuthUser::current()->isAdmin;
    }
    
    function getIsUser() {
        return AuthUser::current()->isUser;
    }

    public function init() {
        parent::init();
        if (Yii::app()->request->getIsAjaxRequest()) {
            $this->layout = '//layouts/bootstrap_modal';
        }
    }
    
    public function pageRefresh() {
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function thisPage() {
        
    }

    public function getUser(){
        return AuthUser::current()->user;
    }
}
