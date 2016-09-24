<?php

/**
 * This is the model class for table "Templates".
 *
 * The followings are the available columns in table 'Templates':
 * @property integer $id
 * @property string $name
 * @property string $thumb
 * @property string $comment
 * @property string $file
 * @property string $class
 */
class Templates extends CActiveRecord {

    public $positions;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Templates';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, file, type', 'required'),
            array('type', 'in', 'range' => array_keys(Blocks::$types), 'allowEmpty' => false, 'strict' => true),
            array('thumb', 'ImageValidator'),
            array('positions', 'required'),
            
            array('name, thumb, file, class', 'length', 'max' => 255),
            array('comment', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, thumb, comment, file, class', 'safe', 'on' => 'search'),
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
            'name' => 'Название',
            'type' => 'Тип материалов',
            'typeName' => 'Тип материалов',
            'thumb' => 'Мигиатюра',
            'comment' => 'Описание',
            'file' => 'Файл',
            'class' => 'CSS класс',
            'positions' => 'Позиции',
        );
    }
    
    public function afterSave() {
        parent::afterSave();
        $this->clearPosition();
        if($this->positions){
            foreach($this->positions as $position){
                $rec = new TemplatePosition();
                $rec->template_id = $this->id;
                $rec->position = $position;
                $rec->save();
            }
        }
    }
    public function afterDelete() {
        $this->clearPosition();
        Blocks::model()->deleteAll('template_id = :template_id', array(
            ':template_id' => $this->id,
        ));
        parent::afterDelete();
    }
    
    private function clearPosition(){
        TemplatePosition::model()->deleteAll('template_id = '.$this->id);
    }
    
    protected function afterFind() {
        parent::afterFind();
        $positions = TemplatePosition::model()->findAll(array(
            'condition' => 'template_id = '.$this->id
        ));
        $this->positions = array();
        if($positions){
            foreach($positions as $position){
                $this->positions[] = $position->position;
            }
        }
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
        $criteria->compare('thumb', $this->thumb, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('class', $this->class, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Templates the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getTypeName() {
        return Blocks::$types[$this->type];
    }
    
    public function getThumbLink() {
        if ($this->thumb)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->thumb;
    }

    static function findTypesInPosition($position){
        $return = array();
        $criteria = new CDbCriteria;
        $criteria->select = 'type, t.id';
        $criteria->distinct = true;
        $criteria->join = 'JOIN template_position tp ON tp.template_id = t.id';
        $criteria->addCondition('tp.position = "'.$position.'"');
        $rez = self::model()->findAll($criteria);
        if($rez){
            $types = array();
            foreach ($rez as $one){
                $types[] = $one->type;
            }
            foreach(Blocks::$types as $type => $one){
                if(in_array($type, $types)){
                    $return[$type] = $one;
                }
            }
        }
        return $return;
    }
    
    static function findInPosition($position, $types = array()){
        $return = array();
        $criteria = new CDbCriteria;
        if($types && !is_array($types)){
            $types = array($types);
        }
        $criteria->distinct = true;
        $criteria->join = 'JOIN template_position tp ON tp.template_id = t.id';
        if($types)
            $criteria->addInCondition('type', $types);
        $criteria->addCondition('tp.position = "'.$position.'"');
        return self::model()->findAll($criteria);
    }
    
}
