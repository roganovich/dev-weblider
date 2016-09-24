<?php

class PortfolioController extends BackEndController {

    public function actionCreate() {
        $model = new Portfolio;
        if (isset($_POST['Portfolio'])) {
            $model->attributes = $_POST['Portfolio'];
            if ($model->save()) {
                EYii::flash("Работа добавлена");
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Portfolio'])) {
            $model->attributes = $_POST['Portfolio'];
            if ($model->save()) {
                EYii::flash("Работа обновлена");
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
            EYii::flash("Работа удалена");
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }


    public function actionIndex() {
        $model = new Portfolio('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Portfolio']))
            $model->attributes = $_GET['Portfolio'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Portfolio::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'portfolio-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
