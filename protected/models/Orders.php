<?php

/**
 * This is the model class for table "Orders".
 *
 * The followings are the available columns in table 'Orders':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $datecreate
 */
class Orders extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, email, datecreate, amount, address', 'required'),
            array('name, email', 'length', 'max' => 255),
            array('email', 'email'),
            array('phone', 'length', 'max' => 50),
            array('amount', 'numerical', 'min' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, phone, email, datecreate', 'safe', 'on' => 'search'),
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
            'name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'amount' => 'Количество, тонн',
            'address' => 'Адрес доставки',
            'datecreate' => 'Дата заявки',
        );
    }
    
    protected function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            Yii::import('application.extensions.phpmailer.JPhpMailer');
            $mail = new JPhpMailer;
            $mail->AddAddress(OptionsRegistr::getInstance()->get('admin_email'));
            $mail->From = $this->email;
            $mail->FromName = $this->name;
            $mail->Subject = "Новая заявка ".$this->ticket." на сайте ".$_SERVER['SERVER_NAME'];
            $text = "";
            foreach ($this->attributes as $key => $value){
                if(in_array($key, array('id', 'gamestatus')))                    
                        continue;
                $text .= "<p>".$this->getAttributeLabel($key).": ".$value."</p>";
            }
            $mail->MsgHTML($text);
            $mail->send();
        }
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('datecreate', $this->datecreate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            if($this->scenario == 'insert'){
                $this->datecreate = date('Y-m-d H:i:s');
            }
            return true;
        }
    }
    
    public function getCode(){
        return md5($this->name.$this->phone.$this->email);
    }

    public function getTicket(){
        return str_pad($this->id, 7, '0', STR_PAD_LEFT);
    }
}
