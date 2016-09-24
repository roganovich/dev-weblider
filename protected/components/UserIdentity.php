<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    const ERROR_EMAIL_INVALID = 3;
    const ERROR_STATUS_NOTACTIV = 4;
    const ERROR_STATUS_BAN = 5;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $user = Admin::model()->findByAttributes(array('login' => $this->username));

        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (AdminLogin::encrypting($this->password) !== $user->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else if ($user->status == -1)
            $this->errorCode = self::ERROR_STATUS_BAN;
        else {
            $this->_id = $user->id;
            $this->username = $user->login;
            $this->errorCode = self::ERROR_NONE;
            $this->setState('isClient', false);
            $this->setState('isAdmin', true);
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        $this->errorCode = self::ERROR_NONE;
    }

}
