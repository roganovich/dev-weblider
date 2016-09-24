<?php

class OptionsController extends BackEndController {

    function actionIndex() {
        if (Yii::app()->request->getParam('form')) {
            foreach (Yii::app()->request->getParam('form') as $key => $val) {
                OptionsRegistr::getInstance()->set($key, $val);
            }
            Yii::app()->user->setFlash('msg', 'Настройки сохранены');
            $this->pageRefresh();
        }
        $this->render('options');
    }

}
