<?php

/**
 * This is the model class for table "MaterialHistoryChanged".
 *
 * The followings are the available columns in table 'MaterialHistoryChanged':
 * @property integer $id
 * @property integer $matarial_history_id
 * @property string $name
 * @property string $value
 * @property string $old_value
 */
class MaterialHistoryChanged extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'MaterialHistoryChanged';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('matarial_history_id', 'required'),
			array('matarial_history_id', 'numerical', 'integerOnly'=>true),
			array('name, value, old_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, matarial_history_id, name, value, old_value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'matarial_history_id' => array(self::BELONGS_TO, 'MaterialHistory', 'id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'matarial_history_id' => 'Matarial History',
			'name' => 'Name',
			'value' => 'Value',
			'old_value' => 'Old Value',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('matarial_history_id',$this->matarial_history_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('old_value',$this->old_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MaterialHistoryChanged the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
