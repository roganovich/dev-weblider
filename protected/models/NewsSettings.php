<?php

/**
 * This is the model class for table "NewsSettings".
 *
 * The followings are the available columns in table 'NewsSettings':
 * @property integer $id
 * @property integer $material_id
 * @property integer $count_materials
 */
class NewsSettings extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'NewsSettings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('material_id', 'required'),
            array('position', 'safe'),
            array('usecrop', 'boolean'),
            array('position, width, height', 'required', 'on' => 'usecrop'),
            array('material_id, count_materials, width, height', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, material_id, count_materials', 'safe', 'on' => 'search'),
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
            'usecrop' => 'Использовать обрезку миниатюр',
            'width' => 'Ширина миниатюры, px.',
            'height' => 'Высота миниатюры, px.',
            'position' => 'Обрезка миниатюры',
            'count_materials' => 'Материалов на странице',
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
        $criteria->compare('count_materials', $this->count_materials);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NewsSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDataProviderForMaterials($onlyActive = true){
        return new CActiveDataProvider('NewsView', array(
            'criteria' => $this->getCtiteriaForMaterialsDataProvider($onlyActive),
            'pagination' => array(
                    'pageSize' => $this->count_materials,
            ),
        ));
    }
    
    public function getCtiteriaForMaterialsDataProvider($onlyActive = true){
        $criteria = new CDbCriteria;
        $criteria->compare('p_id', $this->material_id);
        if($onlyActive){
            $criteria->compare('active', Materials::ACTIVE);
        }
        return $criteria;
    }
    
    public function fillDefaultSettings(){
        $this->count_materials = 10;
        $this->usecrop = true;
        $this->width = Yii::app()->params['defaultCropImageWidth'];
        $this->height = Yii::app()->params['defaultCropImageHeight'];
        $this->position = 'center-center';
    }

}
