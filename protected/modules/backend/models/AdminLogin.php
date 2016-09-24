<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AdminLogin extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Запомнить меня',
            'username' => 'Логин',
            'password' => 'Пароль',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {  // we only want to authenticate when no input errors
            $identity = new UserIdentity($this->username, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_EMAIL_INVALID:
                    $this->addError("username", "Пользователь с таким логином не найден.");
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError("username", "Пользователь с таким логином не найден.");
                    break;
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError("status", 'Ваш аккаунт не активирован.');
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    $this->addError("status", "Ваш аккаунт заблокирован.");
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError("password", "Неверный пароль.");
                    break;
            }
        }
    }

    public static function encrypting($string = "") {
            return md5($string);
    }

}
