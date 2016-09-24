<?php

class GameController extends Controller {

    public function actionIndex() {
        $model = $this->loadOrder(Yii::app()->request->getParam('order'),Yii::app()->request->getParam('code'));
        $gamestatus = Yii::app()->request->getParam('game');
        if(isset($gamestatus)){
            $model->gamestatus = Yii::app()->request->getParam('game');
            $model->save();
            Yii::app()->end();
        }
        $items = array(1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,3,3,3,0,0,0,0,0);
        shuffle($items);
//        $winitems = $this->random($items, OptionsRegistr::getInstance()->get('game_level'));
        $this->render('index', array(
            'model' => $model,
            'items' => $items,
//            'winitems' => $winitems
        ));
    }
    
//    private function random($items, $length){
//        $random = array();
//        shuffle($items);
//        for($i = 0; $i < ($length - 1); $i++)
//           $random[] = $items[$i];
//        return $random;
//    }

    public function loadOrder($id, $code) {
        $model = Orders::model()->findByPk($id);
        if ($model === null || $model->code != $code)
            throw new CHttpException(404, 'Вам необходимо оформить заказ.');
        return $model;
    }
    
}
