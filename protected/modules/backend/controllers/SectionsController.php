<?php

/**
 * Description of SectionsController
 *
 * @author Rodin Andrey
 */
class SectionsController extends BackEndController {
    private $_model;

    public function actionIndex() {
        $sections = SectionsView::findAllGeneral();
        $this->render('index', array(
            'sections' => $sections,
        ));
    }

    public function actionCreate($id = 0) {
        $model = new Materials();
        $model->type = 'sections';
        $p_id = (int)Yii::app()->request->getParam('p_id');
        if($p_id){
            $model->p_id = $p_id;
        }
        $post = Yii::app()->request->getPost('Materials');
        if (isset($post)) {
            $model->attributes = $post;
            $model->content->attributes = Yii::app()->request->getPost('Sections');
            if ($model->validate() && $model->content->validate()) {
                $model->save(); 
                $model->content->material_id = $model->id;
                $model->content->save();
                if($model->settings){
                    $model->settings->material_id = $model->id;
                    $model->settings->fillDefaultSettings();
                    $model->settings->save();
                }
                Yii::app()->user->setFlash('msg', "Новый раздел создан");
                $this->redirect(array('/backend/sections'));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'section_types' => Materials::$types
        ));
    }

    public function actionUpdate() {
        $model = $this->loadModel();
        $type = $model->content->type;
        $post = Yii::app()->request->getPost('Materials');
        if (isset($post)) {
            if(!$post['p_id'] || $post['p_id'] != $model->p_id){
                $model->level = 999999;
            }
            $model->attributes = $post;
            $model->content->attributes = Yii::app()->request->getPost('Sections');
            if ($model->validate() && $model->content->validate()) {
                $model->save(); 
                if($type != $model->content->type) {
                    if($model->settings){
                        $model->settings->fillDefaultSettings();
                        $model->settings->material_id = $model->id;
                        $model->settings->save();
                    }
                }
                $model->content->save();
                $model->recalculateLevel();
                Yii::app()->user->setFlash('msg', "Раздел обновлен");
                $this->redirect(array('/backend/sections'));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'section_types' => Materials::$types
        ));
    }

    public function loadModel() {
        if ($this->_model === null) {
            $id = Yii::app()->request->getParam('id', false);
            if (isset($id)) {
                $this->_model = Materials::model()->findByPk($id);
            }
            if ($this->_model === null)
                throw new CHttpException(404, 'Запрашиваемой страницы не существует');
        }
        return $this->_model;
    }

    public function actionDelete() {
        $this->loadModel()->delete();
        Yii::app()->user->setFlash('msg', "Раздел удален");
        $this->redirect(array('/backend/sections/index'));
    }

    public function actionSavestructure() {
        $vars = unserialize(Yii::app()->request->getParam('sections'));
        $rez = array('status' => "error", "msg" => "Ошибка при сохранении порядка разделов");
        if ($vars) {
            if (Materials::updateTree($vars))
                $rez = array('status' => "success", "msg" => "Порядок разделов сохранен");
        }
        echo json_encode($rez);
    }
    public function actionContent(){
        $images = array();
        $section = $this->loadModel();
        $model = $section->content;
        $post = Yii::app()->request->getPost('Sections');
        $backUrl = $this->getBackUrl();
        if (isset($post)) {
            $model->attributes = $post;
            if ($model->save()) {
                Yii::app()->user->setFlash('msg', "Настройки раздела сохранены");
                $this->redirect($backUrl);
            }
        }
        $this->render('settings', array(
            'model' => $model,
            'backUrl' => $backUrl
        ));
    }
    
    public function getBackUrl(){
        $BackUrl = Yii::app()->createUrl('/backend/sections');
        if(Yii::app()->request->getParam('return')){
            switch (Yii::app()->request->getParam('return')){
                case 'view':
                    $model = $this->loadModel();
                    $BackUrl = Yii::app()->createUrl("/sections/view", array("id" => $model->id));
                    break;
            }
        }
        return $BackUrl;
    }
}
