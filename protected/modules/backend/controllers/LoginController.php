<?php

class LoginController extends Controller {

    public $layout = '//layouts/main';
    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            if (Yii::app()->user->id) {
                $this->redirect(Yii::app()->controller->module->profileUrl);
            } 
            $model = new AdminLogin;
            if (isset($_POST['AdminLogin'])) {
                $model->attributes = $_POST['AdminLogin'];
                if ($model->validate()) {
                    $this->redirect('/backend/sections');
                }
            }
            $this->render('login', array(
                'UserLogin' => $model));
        } else
            $this->redirect('/backend');
    }

    private function lastViset() {
        $lastVisit = Admin::current();
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

}
