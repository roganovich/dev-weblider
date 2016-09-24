<?php

/**
 * This is the model class for table "portfolio".
 *
 * The followings are the available columns in table 'portfolio':
 * @property integer $id
 * @property string $name
 * @property string $task
 * @property string $solution
 * @property string $term
 * @property string $result
 * @property string $description
 * @property string $datecreate
 */
class Portfolio extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'portfolio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, datecreate', 'required'),
            array('name, term', 'length', 'max' => 255),
            array('task, solution, result, description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, task, solution, term, result, description, datecreate', 'safe', 'on' => 'search'),
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
            'name' => 'Название проекта',
            'task' => 'Задача проекта',
            'solution' => 'Выбранное решение',
            'term' => 'Срок реализации',
            'result' => 'Результат',
            'description' => 'Описание',
            'datecreate' => 'Datecreate',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('task', $this->task, true);
        $criteria->compare('solution', $this->solution, true);
        $criteria->compare('term', $this->term, true);
        $criteria->compare('result', $this->result, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('datecreate', $this->datecreate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Portfolio the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

//    public function behaviors() {
//        return array(
//            'CategoryLinker' => array(
//                'class' => 'zii.helper.CategoryLinker',
//                'relatedTableThrught' => 'portfolio-categories',
//            ),
//        );
//    }

}
