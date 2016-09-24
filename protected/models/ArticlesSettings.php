<?php

/**
 * This is the model class for table "ArticlesSettings".
 *
 * The followings are the available columns in table 'ArticlesSettings':
 * @property integer $id
 * @property integer $material_id
 * @property integer $count_materials
 */
class ArticlesSettings extends CActiveRecord {

    static $sortTypes = array(
        'level' => 'Ручная сортировка',
        'created_at' => 'По дате добавления',
    );
    
    static $sortDerections = array(
        'ASC' => 'по возрастанию',
        'DESC' => 'по убыванию',
    );
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ArticlesSettings';
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
            array('sortDirection', 'in', 'range' => array_keys(self::$sortDerections), 'allowEmpty' => false, 'strict' => true),
            array('sortBy', 'in', 'range' => array_keys(self::$sortTypes), 'allowEmpty' => false, 'strict' => true),
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
            'sortBy' => 'Метод сортировки',
            'sortDirection' => 'Направление сортировки',
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
    
    public function getDataProviderForMaterials($onlyActive = true){
        return new CActiveDataProvider('ArticlesView', array(
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
        if($this->sortBy && $this->sortDirection){
            $criteria->order = $this->sortBy." ".$this->sortDirection;
        }
        return $criteria;
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
    
    public function fillDefaultSettings(){
        $this->count_materials = 10;
        $this->usecrop = true;
        $this->width = Yii::app()->params['defaultCropImageWidth'];
        $this->height = Yii::app()->params['defaultCropImageHeight'];
        $this->position = 'center-center';
        $this->sortBy = 'level';
        $this->sortDirection = 'ASC';
    }

}
