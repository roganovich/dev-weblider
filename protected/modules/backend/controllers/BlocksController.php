<?php

/**
 * Description of ArticlesController
 *
 * @author Rodin Andrey
 */
class BlocksController extends BackEndController {
    private $_model;
    public $layout = '//layouts/modal';

    public function loadModel() {
        if ($this->_model === null) {
            $id = Yii::app()->request->getParam('id', false);
            if (isset($id)) {
                $this->_model = Blocks::model()->findByPk($id);
            }
            if ($this->_model === null)
                throw new CHttpException(404, 'Запрашиваемой страницы не существует');
        }
        return $this->_model;
    }
    
    public function actionIndex() {
        $this->render('index', array(
            'positionHelper' => new PositionHelper(Yii::app()->request->getParam('position')),
        ));
    }
    
    public function actionLoadSettingsTemplate(){
        $this->_model = new Blocks();
        $this->fillParams();
        if($this->_model->settings){
            $this->renderPartial($this->_model->settingsTemplate, array(
                'model' => $this->_model,
            ));
        }
    }
    
    private function fillParams(){
        $post = Yii::app()->request->getPost('Blocks');
        if($post){
            if($post){
                $this->_model->attributes = $post;
                if($this->_model->show_title){
                    $this->_model->scenario = 'showTitle';
                }
                if($this->_model->settings){
                    $postSettings = Yii::app()->request->getPost($this->_model->settings->tableName());
                    $this->_model->settings->attributes = $postSettings;
                }
            }
            return true;
        }
    }
    
    private function saveModel(){
        if(!$this->fillParams()) return false;
        $errors = false;
        if(!$this->_model->validate()) $errors = true;
        if($this->_model->settings && !$this->_model->settings->validate()) $errors = true;
        if(!$errors){
            $this->_model->save();
            if($this->_model->settings) $this->_model->settings->save();
            return true;
        }
    }
    
    public function actionCreate() {
        $this->_model = new Blocks();
        $position = Yii::app()->request->getParam('position');
        if($this->saveModel()){
            Yii::app()->user->setFlash('msg', "Блок добавлен");
            $this->redirect(array('/backend/blocks', 'position' => $position));
        }
        if($this->_model->type){
            $types = BsHtml::listData(Templates::findInPosition($position, $this->_model->type), 'id', 'name');
        }
        $this->render('create', array(
            'model' => $this->_model,
            'position' => $position,
            'types' => $types,
        ));
    }
    
    public function actionUpdate() {
        $this->loadModel();
        $position = Yii::app()->request->getParam('position');
        if($this->saveModel()){
            Yii::app()->user->setFlash('msg', "Блок обновлен");
            $this->redirect(array('/backend/blocks/reload', 'position' => $position));
        }
        
        if($this->_model->type){
            $types = BsHtml::listData(Templates::findInPosition($position, $this->_model->type), 'id', 'name');
        }
        $this->render('update', array(
            'model' => $this->_model,
            'position' => $position,
            'types' => $types,
        ));
    }
    
    public function actionReload() {
        $this->render('reload');
    }
    
    public function actionDelete() {
        $this->loadModel()->delete();
        Yii::app()->user->setFlash('msg', "Блок удален");
        $this->redirect(array('/backend/blocks', 'position' => Yii::app()->request->getParam('position')));
    }
    
    
    public function actionSavePosition() {
        $helper = new PositionHelper(Yii::app()->request->getParam('position'));
        $helper->savePosition(Yii::app()->request->getPost('Blocks'));
    }
    
    
    
    public function actionFindtemplates() {
        $json = array();
        $data = Templates::findInPosition(Yii::app()->request->getParam('position'), Yii::app()->request->getParam('type'));
        if($data){
            $json = BsHtml::listData($data, 'id', 'name');
        }
        EYii::endJson($json);
    }
}
