<?php

class SiteController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionCalculate() {
        $model = new FuelsCalculator();
        $post = Yii::app()->request->getPost('FuelsCalculator');
        if ($post) {
            $model->attributes = $post;
            $model->validate();
        }

        $this->renderPartial('/site_block/calculator/_bottom', array(
            'fuels' => Fuels::model()->findAll(),
            'model' => $model,
        ));
    }

    public function actionOrder() {
        $model = new Orders();
        $post = Yii::app()->request->getParam('Orders');
        if ($post) {
            $model->attributes = $post;
            $valid = $model->validate();
            if ($valid) {
                $model->save();
                echo CJSON::encode(array(
                    'status' => 'success',
                    'msg' => 'Ваша заявка '.$model->ticket.' отправлена. Для участия в мгновенном розыгрыша приза перейдите по <a href="'.Yii::app()->createUrl('game/index', array('order' => $model->id, 'code' => $model->code)).'">этой ссылке</a>'
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
            }
            Yii::app()->end();
        }
    }
    
    public function actionReserve() {
        $model = new Reserves();
        $post = Yii::app()->request->getParam('Reserves');
        if ($post) {
            $model->attributes = $post;
            $valid = $model->validate();
            if ($valid) {
                $model->save();
                echo CJSON::encode(array(
                    'status' => 'success',
                    'msg' => 'Ваша заявка на резерв '.str_pad($model->id, 7, '0', STR_PAD_LEFT).' добавлена.'
                ));
                Yii::app()->end();
            } else {
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
            }
            Yii::app()->end();
        }
    }

}
