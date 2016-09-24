<?php

/**
 * This is the model class for table "News".
 *
 * The followings are the available columns in table 'News':
 * @property integer $id
 * @property integer $material_id
 * @property string $thumb
 * @property string $anons
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 */
class News extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'News';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('material_id', 'numerical', 'integerOnly' => true),
            array('thumb', 'ImageValidator'),
            array('thumb', 'length', 'max' => 255),
            array('anons, text, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, material_id, thumb, anons, text, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'material' => array(self::BELONGS_TO, 'Materials', 'material_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'material_id' => 'Material',
            'thumb' => 'Миниатюра',
            'anons' => 'Анонс',
            'text' => 'Основной текст',
            'created_at' => 'Опубликован',
            'updated_at' => 'Обновлен',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('material_id', $this->material_id);
        $criteria->compare('thumb', $this->thumb, true);
        $criteria->compare('anons', $this->anons, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getThumbLink() {
        if ($this->thumb)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->thumb;
    }

    
    public function searchItems() {
        $criteria = new CDbCriteria;
        $criteria->compare('p_id', $this->material->id);
        $criteria->compare('type', $this->material->content->type);
        return new CActiveDataProvider('Materials', array(
            'criteria' => $criteria,
            'pagination' => array(
                    'pageSize' => $this->material->settings->count_materials,
            ),
//            'sort' => array(
//			'defaultOrder' => 'created_at desc',
//			'attributes' => array(
//                            'created_at' => array(
//                                'asc' => 'created_at ASC',
//                                'desc' => 'created_at DESC',
//                            ),
//			),        
//	  	),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => false,
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
            ),
        );
    }

}
