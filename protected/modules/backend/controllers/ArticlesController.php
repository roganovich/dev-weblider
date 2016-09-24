<?php

/**
 * Description of ArticlesController
 *
 * @author Rodin Andrey
 */
class ArticlesController extends BackEndController {
    private $_model;

    public function actionCreate($id = 0) {
        $BackUrl = $this->getBackUrl();
        $model = new Materials();
        $model->type = 'articles';
        $p_id = (int)Yii::app()->request->getParam('p_id');
        if($p_id){
            $model->p_id = $p_id;
        }
        $post = Yii::app()->request->getPost('Materials');
        if (isset($post)) {
            $model->attributes = $post;
            $model->content->attributes = Yii::app()->request->getPost('Articles');
            if ($model->validate() && $model->content->validate()) {
                $model->save(); 
                $model->content->material_id = $model->id;
                $model->content->save();
                Yii::app()->user->setFlash('msg', "Статья добавлена");
                $this->redirect($BackUrl);
            }
        }
        $this->render('create', array(
            'model' => $model,
            'BackUrl' => $BackUrl,
        ));
    }

    public function actionUpdate() {
        $BackUrl = $this->getBackUrl();
        $model = $this->loadModel();
        $post = Yii::app()->request->getPost('Materials');
        if (isset($post)) {
            $model->attributes = $post;
            $model->content->attributes = Yii::app()->request->getPost('Articles');
            if($data){
                $model->level = $data['level'];
            }
            if ($model->validate() && $model->content->validate()) {
                $model->save(); 
                $model->content->save();
                if($data){
                    Articles::recalculateLevel($old_p_id);
                }
                Yii::app()->user->setFlash('msg', "Статья обновлена");
                $this->redirect($BackUrl);
            }
        }
        $this->render('update', array(
            'model' => $model,
            'BackUrl' => $BackUrl,
        ));
    }

    public function findLevel($id = null) {
        $criteria = new CDbCriteria;
        if ($id) {
            $criteria->condition = 'p_id = :p_id';
            $criteria->params = array(':p_id' => $id);
        } else {
            $criteria->condition = 'p_id IS NULL';
        }
        $criteria->order = 't.level DESC';
        $section = Articles::model()->find($criteria);
        if ($section) {
            $return = array('level' => $section->level + 1, 'depth' => $section['depth'] + 1);
        } else {
            if ($id) {
                $parent = Articles::model()->findByPk($id);
                $return = array('level' => 1, 'depth' => $parent->depth + 1);
            } else {
                $return = array('level' => 1, 'depth' => 0);
            }
        }
        return $return;
    }

    public function actionSettings(){
        $section = $this->loadModel();
        $backUrl = Yii::app()->createUrl("/sections/view", array("id" => $section->id));
        $model = $section->settings;
        $post = Yii::app()->request->getPost('ArticlesSettings');
        if (isset($post)) {
            $model->attributes = $post;
            if($model->usecrop) $model->scenario = 'usecrop';
            if ($model->save()) {
                Yii::app()->user->setFlash('msg', "Настройки материалов сохранены");
                $this->redirect($backUrl);
            }
        }
        $this->render('settings', array(
            'model' => $model,
            'backUrl' => $backUrl
        ));
    }
    
    public function actionSort($id){
        $model = SectionsView::model()->findByAttributes(array('id' => $id));
        $backUrl = Yii::app()->createUrl("/sections/view", array("id" => $model->id));
        $post = Yii::app()->request->getPost('Sort');
        if (isset($post)) {
            foreach($post as $level => $id){
                $item = Materials::model()->findByPk($id);
                $item->level = $level+1;
                $item->save();
            }
            Yii::app()->user->setFlash('msg', "Материалы успешно отсортированы");
            $this->redirect($backUrl);
        }
        $this->render('sort', array(
            'models' => $model->getMaterials(),
            'BackUrl' => $backUrl
        ));
    }
    
    public function actionDelete($id) {
        $backUrl = $this->getBackUrl();
        $section = $this->loadModel();
        $section->delete();
        Yii::app()->user->setFlash('msg', "Статья удалена");
        $this->redirect($backUrl);
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

    public function getBackUrl(){
        if(Yii::app()->request->getParam('return')){
            switch (Yii::app()->request->getParam('return')){
                case 'list':
                    if(Yii::app()->request->getParam('id')){
                        $model = $this->loadModel();
                        $BackUrl = Yii::app()->createUrl("/sections/view", array("id" => $model->p_id));
                    } else {
                        $BackUrl = Yii::app()->createUrl("/sections/view", array("id" => Yii::app()->request->getParam('p_id')));
                    }
                    break;
                case 'view':
                    if(Yii::app()->request->getParam('id')){
                        $model = $this->loadModel();
                        $BackUrl = Yii::app()->createUrl("/articles/view", array("id" => $model->id));
                    }
                    break;
            }
        }
        return $BackUrl;
    }
}
