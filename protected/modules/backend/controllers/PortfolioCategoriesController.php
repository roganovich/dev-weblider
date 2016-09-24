<?php

class PortfolioCategoriesController extends BackEndController {

    public function actionCreate() {
        $model = new PortfolioCategories;
        if (isset($_POST['PortfolioCategories'])) {
            $model->attributes = $_POST['PortfolioCategories'];
            if ($model->save()) {
                EYii::flash("Категория добавлена");
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['PortfolioCategories'])) {
            $model->attributes = $_POST['PortfolioCategories'];
            if ($model->save()) {
                EYii::flash("Категория обновлена");
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
            EYii::flash("Категория удалена");
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }


    public function actionIndex() {
        $model = new PortfolioCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PortfolioCategories']))
            $model->attributes = $_GET['PortfolioCategories'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = PortfolioCategories::model()->findByPk($id);
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
