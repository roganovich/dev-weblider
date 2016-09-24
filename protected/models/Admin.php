<?php

/**
 * This is the model class for table "h_admin".
 *
 * The followings are the available columns in table 'h_admin':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $last_visit
 * @property string $role
 * @property string $access
 * @property string $fio
 * @property string $status
 * @property integer $prava
 * @property integer $kurs_operator
 * @property string $service
 */
class Admin extends CActiveRecord {
    public $sms;
    static private $currentAuthUser = null;

    static $menu = array(
        '/admin/setup/' => 'Общие настройки',
        '/admin/operators/' => 'Операторы и права',
        '/admin/clients/' => 'Клиенты',
        '/admin/perevods/' => 'Заявки на подтверждение',
        '/admin/add_bill/' => 'Заявки на пополнение счета',
//        '/backend/ewallet/' => 'Заявки на пополнение через ePayment',
        '/admin/new_bill/' => 'Заявки на изменение контракта',
        '/admin/fin_perevods/' => 'Финансовые заявки',
        '/admin/mc/' => 'Заявки MasterCard',
        '/admin/mc_viplata/' => 'Финансовые заявки Master Card',
//        '/admin/qr_tecket/' => 'Билеты',
        '/backend/qrticket/' => 'Билеты',
        '/admin/s_page/' => 'Статические страницы',
        '/admin/new/' => 'Новости',
        '/admin/shablon/' => 'Шаблоны писем',
        '/admin/statistics/' => 'Общая статистика',
        '/admin/mon/' => 'Мониторинг',
        '/admin/doxod_clients/' => 'Доход клиентов',
        '/admin/response/' => 'Рассылка',
        '/admin/kurs/' => 'Курсы валют',
        '/admin/translate/' => 'Управление переводчиком',
        '/backend/personalinfo/' => 'Запросы на смену перс. данных',
        '/backend/confirmdocs/' => 'Подтверждение документов',
    );
    
    static $services = array(
        'service_fin' => 'Финансовая служба',
        'service_check' => 'Служба проверки',
         
   );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Admin';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('login, password, email, phone, last_visit, access, fio, status, prava, kurs_operator', 'required'),
            array('prava, kurs_operator', 'numerical', 'integerOnly' => true),
            array('login, password, email, phone, fio, status', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('sms', 'SmsValidator', 'on' => 'checkSms'),
            array('role, service, sms', 'safe'),
            array('id, login, password, email, phone, last_visit, role, access, fio, status, prava, kurs_operator, service', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email',
            'phone' => 'Телефон',
            'last_visit' => 'Последний визит',
            'role' => 'Роль',
            'access' => 'Доступ',
            'fio' => 'ФИО',
            'status' => 'Статус',
            'prava' => 'Права',
            'kurs_operator' => 'Подтверждает курс валют',
            'service' => 'Service',
            'sms' => 'Код СМС-подтверждения',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('last_visit', $this->last_visit, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('access', $this->access, true);
        $criteria->compare('fio', $this->fio, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('prava', $this->prava);
        $criteria->compare('kurs_operator', $this->kurs_operator);
        $criteria->compare('service', $this->service, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Admin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function findServiceOperators() {
        return self::model()->findAll(array(
                    'condition' => 'service LIKE "%service_check%"'
        ));
    }

    static function menu() {
        $return = array();
        foreach (self::$menu as $url => $label) {
            $return[] = array('label'=>$label, 'url'=>array($url), 'visible' => AuthUser::checkAccessMenu($url));
        }
        return $return;
    }
    
   public function getRoleArray(){
       return explode(',', $this->role);
   }
   
   public function getServiceArray(){
       explode(',', $this->service);
   }
    
    protected function beforeValidate()
    {
        if(parent::beforeValidate()){
            $this->role = implode(',', $this->role);
            $this->service = implode(',', $this->service);
            return true;
        }
    }
    
    static public function current() {
        if (is_null(self::$currentAuthUser) && Yii::app()->user->isAdmin()) {
            self::$currentAuthUser = self::model()->findByPk(
                    Yii::app()->user->getId()
            );
        }
        return self::$currentAuthUser;
    }
}
