<?php

class MaterialsController extends Controller {
    protected $_model;
   
    public function actionView() {
        $this->render($this->getTemplate('view'), array(
            'model' => $this->loadModel(),
            'page' => $this->getPage()
        ));
    }
    
    protected function getPage(){
        if(!$_GET) return false;
        $pattern = "/(_page)$/";
        foreach($_GET as $index => $val){
            if(preg_match($pattern, $index)) return $val;
        }
    }

    public function getTemplate($template = 'index'){
        $model = $this->loadModel();
        $path = Yii::app()->theme->basePath."/views/".$model->content->type."/".$template.".php";
        if (!file_exists($path)){
            return "/materials/".$template;
        } else {
            return "/".$model->content->type."/".$template;
        }
    }
    
    public function loadModel(){
        if(!$this->_model){
            $this->_model = PathInfo::getInstance()->material;
            if ($this->_model === null)
                throw new CHttpException(404, 'Запрашиваемой страницы не существует');
        }
        return $this->_model;
    }
}
