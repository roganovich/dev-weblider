<?php

/**
 * This is the model class for table "SectionsView".
 *
 * The followings are the available columns in table 'SectionsView':
 * @property integer $id
 * @property integer $active
 * @property integer $p_id
 * @property string $title
 * @property string $url
 * @property integer $depth
 * @property integer $level
 * @property string $type
 * @property string $thumb
 * @property string $anons
 * @property string $text
 */
class SectionsView extends CActiveRecord {

    private $_childs;
    private $_allMaterials;
    private $_parent;

   
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'SectionsView';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, url', 'required'),
            array('id, active, p_id, depth, level', 'numerical', 'integerOnly' => true),
            array('title, thumb', 'length', 'max' => 255),
            array('type', 'length', 'max' => 50),
            array('anons, text', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, active, p_id, title, url, depth, level, type, thumb, anons, text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'SectionsView', 'p_id'),
            'material' => array(self::BELONGS_TO, 'Materials', 'id'),
        );
    }
    
    public function getParent(){
        if(!$this->_parent){
            $this->_parent = self::model()->findByAttributes(array('id' => $ths->p_id));
        }
        return $this->_parent;
    }
    
    public function getSettings(){
        return $this->material->settings;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'active' => 'Active',
            'p_id' => 'P',
            'title' => 'Title',
            'url' => 'Url',
            'depth' => 'Depth',
            'level' => 'Level',
            'type' => 'Type',
            'thumb' => 'Thumb',
            'anons' => 'Anons',
            'text' => 'Text',
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
        $criteria->compare('active', $this->active);
        $criteria->compare('p_id', $this->p_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('depth', $this->depth);
        $criteria->compare('level', $this->level);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('thumb', $this->thumb, true);
        $criteria->compare('anons', $this->anons, true);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SectionsView the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function findAllGeneral() {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.p_id IS NULL';
        $criteria->order = 't.level';
        return self::model()->findAll($criteria);
    }
    
    public function getTypeName() {
        return Materials::$types[$this->type];
    }
    
    public function getChilds(){
        if(!$this->_childs){
            $criteria = new CDbCriteria;
            $criteria->compare('p_id', $this->id);
            $criteria->order = "t.level ASC";
            $this->_childs = self::model()->findAll($criteria);
        }
        return $this->_childs;
    }
    
    public function getAllMaterials(){
        if(!$this->_allMaterials){
            $this->_allMaterials = $this->getMaterials();
        }
        return $this->_allMaterials;
    }
    
    public function getMaterials($onlyactive = false){
        $return = array();
        $viewModel = ucfirst($this->type)."View";
        if (class_exists($viewModel) && $viewModel != 'SectionsView'){
            $criteria = new CDbCriteria;
            $criteria->compare('p_id', $this->id);
            if($onlyactive){
                $criteria->compare('active', true);
            }
            
            if(isset($this->settings->attributes['sortBy']) && isset($this->settings->attributes['sortDirection'])){
                $criteria->order = $this->settings->sortBy." ".$this->settings->sortDirection;
            }
            $return = $viewModel::model()->findAll($criteria);
        }
        return $return;
    }
}
