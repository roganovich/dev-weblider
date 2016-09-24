<?php

/**
 * This is the model class for table "Reserves".
 *
 * The followings are the available columns in table 'Reserves':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $datereserve
 * @property string $datecreate
 * @property integer $amount
 */
class Reserves extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Reserves';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, email, datereserve, datecreate, amount', 'required'),
            array('amount', 'numerical', 'integerOnly' => true),
            array('name, email', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, phone, email, datereserve, datecreate, amount', 'safe', 'on' => 'search'),
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
            'datereserve' => 'Дата резерва',
            'datecreate' => 'Дата заявки',
            'amount' => 'Количество',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('datereserve', $this->datereserve, true);
        $criteria->compare('datecreate', $this->datecreate, true);
        $criteria->compare('amount', $this->amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Reserves the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->scenario == 'insert') {
                $this->datecreate = date('Y-m-d H:i:s');
            }
            return true;
        }
    }

}
