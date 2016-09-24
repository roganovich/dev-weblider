<?php

/**
 * Description of ArticlesController
 *
 * @author Rodin Andrey
 */
class TemplatesController extends BackEndController {
    private $_model;

    public function actionIndex() {
        $model = new Templates();
        $this->render('index', array(
            'model' => $model
        ));
    }
    
    public function actionCreate() {
        $model = new Templates();
        $post = Yii::app()->request->getPost('Templates');
        if($post){
            $model->attributes = $post;
            if($model->validate()){
                $model->save();
                Yii::app()->user->setFlash('msg', "Шаблон добавлен");
                $this->redirect(array('/backend/templates'));
            }
        }
        $this->render('create', array(
            'model' => $model
        ));
    }
    public function actionDelete() {
        $this->loadModel()->delete();
        Yii::app()->user->setFlash('msg', "Шаблон удален");
        $this->redirect(array('/backend/templates'));
    }
    
    public function actionUpdate() {
        $model = $this->loadModel();
        $post = Yii::app()->request->getPost('Templates');
        if($post){
            $model->attributes = $post;
            if($model->validate()){
                $model->save();
                Yii::app()->user->setFlash('msg', "Шаблон обновлен");
                //$this->redirect(array('/backend/templates'));
            }
        }
        $this->render('update', array(
            'model' => $model
        ));
    }

    public function loadModel() {
        if ($this->_model === null) {
            $id = Yii::app()->request->getParam('id', false);
            if (isset($id)) {
                $this->_model = Templates::model()->findByPk($id);
            }
            if ($this->_model === null)
                throw new CHttpException(404, 'Запрашиваемой страницы не существует');
        }
        return $this->_model;
    }
}
