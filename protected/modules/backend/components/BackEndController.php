<?php

class BackEndController extends Controller {

    public $layout = '//layouts/backend';

    public function init() {
        parent::init();
        if (!Yii::app()->request->getIsAjaxRequest()) {
            Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/backend.css');
        }
    }

    

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'expression' => 'Yii::app()->controller->getAccess()',
                //'deniedCallback' => array($this, 'getRuleRedirect')
            ),
            array(
                'allow',
                'actions' => array('login'),
                'users' => array('?'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function getAccess() {
        return Yii::app()->controller->getIsAdmin();
    }

    public function getRuleRedirect() {
        if ($this->user) {
            $this->redirect('/admin/index?prava=not');
        } else {
            $this->redirect('/backend/login');
        }
    }

}
