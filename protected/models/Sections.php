<?php
class Sections extends CActiveRecord {
    private $_materialModel;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Sections';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type', 'required'),
            array('material_id', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 50),
            array('alt_name, title, logo, img_top, img_bottom, thumb', 'length', 'max' => 255),
            array('text_top, text_bottom, text, anons', 'safe'),
            array('img_top, img_bottom, logo, thumb', 'ImageValidator'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, material_id, type, alt_name, title, logo, text_top, text_bottom, img_top, img_bottom', 'safe', 'on' => 'search'),
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
            'material_id' => 'Material',
            'anons' => 'Анонс',
            'text' => 'Основной контент',
            'type' => 'Тип раздела',
            'thumb' => 'Миниатюра раздела',
            'alt_name' => 'Alt Name',
            'title' => 'Заголовок',
            'logo' => 'Логотип',
            'text_top' => 'Text Top',
            'text_bottom' => 'Text Bottom',
            'img_top' => 'Изображение в шапку (слайдер)',
            'img_bottom' => 'Изображение в подвал (альтернативное изображение)',
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
        $criteria->compare('material_id', $this->material_id);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('alt_name', $this->alt_name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('text_top', $this->text_top, true);
        $criteria->compare('text_bottom', $this->text_bottom, true);
        $criteria->compare('img_top', $this->img_top, true);
        $criteria->compare('img_bottom', $this->img_bottom, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTypeName() {
        return Materials::$types[$this->type];
    }

    public function getThumbLink() {
        if ($this->thumb)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->thumb;
    }

    public function getLogoLink() {
        if ($this->logo)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->logo;
    }

    public function getImgTopLink() {
        if ($this->img_top)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->img_top;
    }

    public function getImgBottomLink() {
        if ($this->img_bottom)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->img_bottom;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sections the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function putDefaultSetting() {
        
    }
    
    public function getMaterialModel(){
        if(!$this->_materialModel){
            switch ($this->type){
                case 'sections':
                    break;
                default :
                    $modelName = ucfirst($this->type);
                    $this->_materialModel = new $modelName();
                    break;
            }
            
        }
        return $this->_materialModel;
    }
    
}
