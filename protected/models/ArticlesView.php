<?php

/**
 * This is the model class for table "ArticlesView".
 *
 * The followings are the available columns in table 'ArticlesView':
 * @property integer $id
 * @property integer $p_id
 * @property string $title
 * @property string $url
 * @property string $thumb
 * @property string $anons
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class ArticlesView extends CActiveRecord {

    private $_parent;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ArticlesView';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, url', 'required'),
            array('id, p_id, created_at, updated_at', 'numerical', 'integerOnly' => true),
            array('title, thumb', 'length', 'max' => 255),
            array('anons, text', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, p_id, title, url, thumb, anons, text, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'material' => array(self::BELONGS_TO, 'Materials', 'id'),
        );
    }
    
    public function getParent(){
        if(!$this->_parent){
            $this->_parent = SectionsView::model()->findByAttributes(array('id' => $ths->p_id));
        }
        return $this->_parent;
    }
    
    public function getSettings(){
        return $this->parent->settings;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'p_id' => 'P',
            'title' => 'Title',
            'url' => 'Url',
            'thumb' => 'Thumb',
            'anons' => 'Anons',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('thumb', $this->thumb, true);
        $criteria->compare('anons', $this->anons, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getLink() {
        return "/" . $this->url;
    }
    
    public function getThumbLink() {
        if ($this->thumb)
            return DIRECTORY_SEPARATOR.Yii::app()->params['imageStorageFolder'] . $this->thumb;
    }
        
    public function getThumbCrop(){
        if(!$this->settings->usecrop) return $this->thumbLink;
        $helper = new imageResizer(array(
            'image' => $this->thumb,
            'width' => $this->settings->width,
            'height' => $this->settings->height,
            'position' => $this->settings->position,
        ));
        return $helper->run();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ArticlesView the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getCreatedAtForView(){
        return date('Y-m-d H:i:s', $this->created_at);
    }

}
