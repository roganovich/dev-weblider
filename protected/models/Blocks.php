<?php

/**
 * This is the model class for table "Blocks".
 *
 * The followings are the available columns in table 'Blocks':
 * @property integer $id
 * @property string $show_title
 * @property string $title
 * @property string $name
 * @property string $text
 * @property string $type
 * @property integer $template_id
 * @property integer $material_id
 * @property string $link
 */
class Blocks extends CActiveRecord {
    public $notinherit;
    private $_settings;
    
    static $types = array(
        'custom' => 'Произвольный',
        'sections' => 'Меню',
        'articles' => 'Статейный',
        'news' => 'Новостной',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Blocks';
    }
    
    public function getNotinherit(){
        
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, name, template_id', 'required'),
            array('title', 'required', 'on' => 'showTitle'),
            array('type', 'in', 'range' => array_keys(Blocks::$types), 'allowEmpty' => false, 'strict' => true),
            array('template_id, material_id', 'numerical', 'integerOnly' => true),
            array('show_title', 'boolean'),
            array('title, cssclass, name, type', 'length', 'max' => 255),
            array('text, link', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, show_title, title, name, text, type, template_id, material_id, link', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'template' => array(self::BELONGS_TO, 'Templates', 'template_id'),
        );
    }

    public function getTypeName() {
        return Blocks::$types[$this->type];
    }
    
    public function getSettings() {
        if(!$this->_settings && $this->type && $this->type != 'custom'){
            switch ($this->type){
                case 'sections':
                    $classSettingsName = 'BlockMenu';
                break;
                default :
                    $classSettingsName = 'Block'.  ucfirst($this->type);
                break;
            }
            $this->_settings = $classSettingsName::model()->findByAttributes(array('block_id' => $this->id));
            if(!$this->_settings){
                $this->_settings = new $classSettingsName();
                $this->_settings->block = $this;
            }
        }
        return $this->_settings;
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'show_title' => 'Показывать заголовок',
            'title' => 'Заголовок блока',
            'name' => 'Название в системе блоков',
            'text' => 'Текст',
            'type' => 'Тип',
            'template_id' => 'Шаблон',
            'material_id' => 'Material',
            'link' => 'Link',
            'cssclass' => 'Дополнительный CSS класс блока'
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
        $criteria->compare('show_title', $this->show_title, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('template_id', $this->template_id);
        $criteria->compare('material_id', $this->material_id);
        $criteria->compare('link', $this->link, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Blocks the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function afterDelete() {
        BlocksPosition::model()->deleteAll('block_id = :block_id', array(
            ':block_id' => $this->id,
        ));
        if($this->settings)$this->settings->delete();
        parent::afterDelete();
    }
    
    public function getSettingsTemplate(){
        if($this->type){
            return "/blocks/settings/".$this->type;
        }
    }
    

}
