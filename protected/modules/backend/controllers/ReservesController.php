<?php

class ReservesController extends BackEndController {

    
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax'])) {
            EYii::flash("Резерв удален");
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }


    public function actionIndex() {
        $model = new Reserves('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Reserves']))
            $model->attributes = $_GET['Reserves'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Reserves::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
