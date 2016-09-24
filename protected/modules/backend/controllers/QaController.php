<?php

class QaController extends BackEndController {

    public function actionView($id) {
        $model = new Qa();
        $model->letter_id = $id;
        if(Yii::app()->request->getPost('Qa')){
            $model->attributes = Yii::app()->request->getPost('Qa');
            if($model->validate()){
                $count = $model->submit();
                EYii::flash("Вопрос ".$model->letter->name." добавлено в рассылку по группе ".$model->group->name." ".$count." подписчикам");
                $this->redirect(array('index'));
            }
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }
    
    public function actionDeleteSubscriber($id){
        $model = SubscribersHistory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->delete();
    }

    public function actionCreate() {
        $model = new Qa;
        if (isset($_POST['Qa'])) {
            $model->attributes = $_POST['Qa'];
            if ($model->save()) {
                EYii::flash("Вопрос добавлен");
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Qa'])) {
            $model->attributes = $_POST['Qa'];
            if ($model->save()) {
                EYii::flash("Вопрос обновлен");
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax'])) {
            EYii::flash("Вопрос удален");
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }


    public function actionIndex() {
        $model = new Qa('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Qa']))
            $model->attributes = $_GET['Qa'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Qa::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'letters-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
