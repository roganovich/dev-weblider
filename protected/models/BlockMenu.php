<?php

/**
 * This is the model class for table "BlockMenu".
 *
 * The followings are the available columns in table 'BlockMenu':
 * @property integer $id
 * @property integer $block_id
 * @property string $sample
 */
Yii::import('application.helpers.MenuBlockHelpers.*');
class BlockMenu extends CActiveRecord {
    
    public $materials = array();
    public $ids = array();
    
    static $samples = array(
        'sections' => 'Разделы',
        'materials' => 'Разделы и материалы',
        'line' => 'Линейный набор с произвольной сортировкой',
        'constructor' => 'Конструктор',
    );
    
    private $_block;
    private $_helper;


    public function samples(){
        return self::$samples;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'BlockMenu';
    }
    
    public function setBlock(Blocks $block){
        $this->_block = $block;
        $this->block_id = $this->_block->id;
    }
    
    public function getBlock(){
        if(!$this->_block){
            $this->_block = Blocks::model()->findByPk($this->block_id);
        }
        return $this->_block;
    }
    
    public function getHelper(){
        if(!$this->_helper && $this->sample){
            switch ($this->sample){
                case 'line': $helperName = "LineHelper";
                    break;
                default : $helperName = "DefaultHelper";
                    break;
            }
            $this->_helper = new $helperName();
            $this->_helper->blockSettings = $this;
        }
        return $this->_helper;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('block_id, sample', 'required'),
            array('block_id', 'numerical', 'integerOnly' => true),
            array('sample', 'in', 'range' => array_keys(self::$samples), 'allowEmpty' => false, 'strict' => true,), // The following rule is used by search().
            array('ids', 'checkMaterials'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, block_id, sample', 'safe', 'on' => 'search'),
        );
    }
    
    public function checkMaterials($attribute,$params)
    {
            if(!$this->ids){
                    $this->addError('sample','Не выбраны материалы для блока.');
            }
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
            'block_id' => 'Block',
            'sample' => 'Тип выборки',
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
        $criteria->compare('block_id', $this->block_id);
        $criteria->compare('sample', $this->sample, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlockMenu the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTemplate(){
        if($this->sample){
            return "/blocks/settings/".$this->block->type."/".$this->sample;
        }
    }
    
    public function afterFind() {
        parent::afterFind();
        $links = BlockMenuMaterials::model()->findAllByAttributes(array('block_id'  => $this->block_id));
        if($links){
            foreach($links as $one){
                $this->ids[] = $one->material_id;
            }
        }
    }
    
    public function afterSave() {
        parent::afterSave();
        $this->helper->save();
    }

    public function afterDelete() {
        $this->helper->delete();
        parent::afterDelete();
    }
    
    public function getData(){
        
    }

}
