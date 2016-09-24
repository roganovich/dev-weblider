<?php

class ArticlesController  extends Controller{
    protected $_model;
    
    public function actionView() {
        $this->render('item', array(
            'model' => $this->loadModel(),
        ));
    }

    public function loadModel(){
        if(!$this->_model){
            $this->_model = ArticlesView::model()->findByAttributes(array('id' => PathInfo::getInstance()->material->id));
            if ($this->_model === null)
                throw new CHttpException(404, 'Запрашиваемой страницы не существует');
        }
        return $this->_model;
    }
    
}
