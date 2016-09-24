<?php

/**
 * This is the model class for table "Materials".
 *
 * The followings are the available columns in table 'Materials':
 * @property integer $id
 * @property integer $p_id
 * @property string $name
 * @property string $url
 * @property string $page
 * @property string $type
 * @property string $active
 * @property string $level
 */
class Materials extends CActiveRecord {

        
    private $_url;
    private $_content;
    private $_parent;
    private $_settings;
    private $_childs;
    private $_activeChilds;
    private $_materials;
    static $indexPage;

    const ACTIVE = 1;
    const INACTIVE = 0;

    static $types = array(
        'sections' => 'Текст',
        'news' => 'Новости',
        'articles' => 'Статьи',
        'publishes' => 'Публикации',
        'photos' => 'Фотогалерея',
    );

    public function getChilds($type = true) {
        if (!$this->_childs) {
            $criteria = new CDbCriteria;
            $criteria->compare('p_id', $this->id);
            if ($type) {
                $criteria->compare('type', $this->type);
            }
            $criteria->order = "t.level ASC";
            $this->_childs = self::model()->findAll($criteria);
        }
        return $this->_childs;
    }

    public function getMaterials() {
        if (!$this->_materials) {
            $criteria = new CDbCriteria;
            $criteria->compare('p_id', $this->id);
            $criteria->compare('type', $this->content->type);
//            $criteria->order = "t.level ASC";
            $this->_materials = self::model()->findAll($criteria);
        }
        return $this->_materials;
    }

    public function getActiveChilds() {
        if (!$this->_activeChilds) {
            $criteria = new CDbCriteria;
            $criteria->compare('p_id', $this->id);
            $criteria->compare('type', $this->type);
            $criteria->compare('active', self::ACTIVE);
            $criteria->order = "t.level ASC";
            $this->_activeChilds = self::model()->findAll($criteria);
        }
        return $this->_activeChilds;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Materials';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, page, type', 'required'),
            array('page', 'unique'),
            array('p_id, level', 'numerical', 'integerOnly' => true),
            array('active', 'boolean'),
            array('name, page', 'length', 'max' => 255),
            array('type', 'in', 'range' => array_keys(Materials::$types), 'allowEmpty' => false, 'strict' => true,), // The following rule is used by search().
            array('id, p_id, name, url, page, type', 'safe', 'on' => 'search'),
        );
    }

    protected function afterFind() {
        parent::afterFind();
        $this->_url = $this->url;
    }

    public function getTypeName() {
        return Materials::$types[$this->type];
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
//            'parent' => array(self::BELONGS_TO, 'Materials', 'p_id'),
        );
    }

    public function getContent() {
        if (!$this->_content) {
            switch ($this->type) {
                case 'sections':
                    $this->_content = Sections::model()->findByAttributes(array('material_id' => $this->id));
                    if (!$this->_content) {
                        $this->_content = new Sections();
                        $this->_content->material_id = $this->id;
                    }
                    break;
                default :
                    $modelName = ucfirst($this->type);
                    $this->_content = $modelName::model()->findByAttributes(array('material_id' => $this->id));
                    if (!$this->_content) {
                        $this->_content = new $modelName();
                        $this->_content->material_id = $this->id;
                    }
                    break;
            }
        }
        return $this->_content;
    }

    public function afterDelete() {
        if ($this->content && !$this->content->isNewRecord) {
            $this->content->delete();
        }
        if ($this->settings && !$this->settings->isNewRecord) {
            $this->settings->delete();
        }
        BlockNonePosition::model()->deleteAll('url = :url', array(':url' => $this->url));
        BlocksPosition::model()->deleteAll('url = :url', array(':url' => $this->url));
        $childs = $this->getChilds(false);
        if ($childs) {
            foreach ($childs as $one) {
                $one->delete();
            }
        }
        $this->recalculateLevel();
        
        parent::afterDelete();
    }

    public function getParent() {
        if (!$this->_parent && $this->p_id != null) {
            $this->_parent = self::model()->findByPk($this->p_id);
        }
        return $this->_parent;
    }

    public function getSettings() {
        if (!$this->_settings && $this->type == 'sections') {
            switch ($this->content->type) {
                case 'sections':
                    break;
                default :
                    $modelName = ucfirst($this->content->type) . "Settings";
                    $this->_settings = $modelName::model()->findByAttributes(array('material_id' => $this->id));
                    if (!$this->_settings) {
                        $this->_settings = new $modelName();
                    }
                    break;
            }
        }
        return $this->_settings;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->url = $this->page;
            $this->depth = 0;
            if ($this->parent) {
                $this->url = $this->parent->url . '/' . $this->url;
                $this->depth = $this->parent->depth + 1;
            }
            if ($this->isNewRecord) {
                $this->level = $this->findNextLevel();
            }
            return true;
        }
    }

    private function findNextLevel() {
        $criteria = new CDbCriteria;
        $criteria->compare('type', $this->type);
        if (!$this->p_id) {
            $criteria->addCondition('p_id IS NULL');
        } else {
            $criteria->compare('p_id', $this->p_id);
        }
        return count(self::model()->findAll($criteria)) + 1;
    }

    public function recalculateLevel() {
        $criteria = new CDbCriteria;
        $criteria->compare('type', $this->type);
        if (!$this->p_id) {
            $criteria->addCondition('p_id IS NULL');
        } else {
            $criteria->compare('p_id', $this->p_id);
        }
        $criteria->order = "level ASC";
        if ($models = self::model()->findAll($criteria)) {
            foreach ($models as $level => $model) {
                $model->level = $level + 1;
                $model->save();
            }
        }
    }

    public function afterSave() {
        parent::afterSave();
        $this->updateBlocksInfo();
        $childs = $this->getChilds(false);
        if ($childs) {
            foreach ($childs as $child) {
                $child->save();
            }
        }
    }
    
    public function updateBlocksInfo(){
        if($this->_url != $this->url){
            $info = BlockNonePosition::model()->findAllByAttributes(array('url' => $this->_url));
            if($info){
                foreach ($info as $one){
                    $one->url = $this->url;
                    $one->save();
                }
            }
            $info = BlocksPosition::model()->findAllByAttributes(array('url' => $this->_url));
            if($info){
                foreach ($info as $one){
                    $one->url = $this->url;
                    $one->save();
                }
            }
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'p_id' => 'Родитель',
            'name' => 'Заголовок',
            'url' => 'Полный URL материала',
            'page' => 'URL страницы',
            'type' => 'Тип материала',
            'active' => 'Активен',
            'level' => 'Уровень',
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
        $criteria->compare('p_id', $this->p_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('page', $this->page, true);
        $criteria->compare('type', $this->type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Materials the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOneByPage($url) {
        return self::model()->findByAttributes(array('url' => $url));
    }

    public static function findAllGeneral() {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.p_id IS NULL';
        $criteria->order = 't.level';
        return self::model()->findAll($criteria);
    }

    public static function updateTree($vars, $p_id = null) {
        foreach ($vars as $level => $one) {
            $section = self::model()->findByPk($one['id']);
            $section->p_id = $p_id;
            $section->level = $level + 1;
            $section->save();

            if ($one['children']) {
                self::updateTree($one['children'], $one['id']);
            }
        }
        return true;
    }

    public static function getIndexPage() {
        if (!self::$indexPage) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'p_id IS NULL and level = 1';
            self::$indexPage = self::model()->find($criteria);
        }
        return self::$indexPage;
    }

}
