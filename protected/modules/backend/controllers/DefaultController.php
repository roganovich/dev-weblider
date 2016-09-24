<?php

class DefaultController extends BackEndController {

    function actionIndex() {
        $this->render('/backend', array(
        ));
    }

}
