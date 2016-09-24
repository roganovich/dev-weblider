<?php

/**
 * This is the model class for table "Fuels".
 *
 * The followings are the available columns in table 'Fuels':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $calorific
 * @property string $units
 * @property string $price
 */
class Fuels extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Fuels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, calorific, units, price', 'required'),
			array('priceFor1000', 'boolean'),
			array('name, priceComment', 'length', 'max'=>255),
			array('calorific, price, translate', 'numerical'),
			array('units', 'length', 'max'=>25),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, calorific, units, price', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'description' => 'Описание',
			'calorific' => 'Средняя теплотворная способность, ',
			'units' => 'Единицы измерения',
			'price' => 'Цена',
			'priceComment' => 'Комментарий к цене',
			'priceFor1000' => 'Цена указана за 1000 единиц (напр. тонна)',
			'translate' => 'Кооф. трансформирования из одной единицы измерения в другую (напр. кг -> куб. м.)',
                    
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('calorific',$this->calorific,true);
		$criteria->compare('units',$this->units,true);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Fuels the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /*
         * Общепринято, для отопления 30 куб. м хорошо утепленного помещения требуется ~ 1 кВт мощности. 
         * 1 кВт * 24 часа * 30 дней = 720 кВт-час.
         * Принимая во внимание то, что котел будет работать примерно 50% = 360 кВт-час.
         * 7 месяцев отопительного сезона
         * 7 * 360 = 2 520 кВт-час
         * переводим в кДж
         * 2 520 * 3600 = 9072000 кДж
         */
        public function calculateAmount($space, $kpd = 100){
            $rez = $space / 30 * 24 *30;
            $rez = $rez / 2 ;
            $rez = $rez * 7 * 3.6;
            $rez = $rez / $this->calorific;
            $rez = $rez + $rez*(100-$kpd)/100;
            if($this->priceFor1000){
                $rez = $rez / 1000;
            }
            if($this->translate){
                $rez = $rez / $this->translate;
            }
            return $rez;
        }
        
        public function calculatePrice($space, $kpd = 100){
            return $this->calculateAmount($space, $kpd) * $this->price;
        }
}
