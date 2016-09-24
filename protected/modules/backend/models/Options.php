<?php

class Options extends CActiveRecord {

    static $cropPositions = array(
        "top-left" => "верх-левый угол",
        "top-center" => "верх-центр",
        "top-right" => "верх-правый угол",
        "center-left" => "центр-лево",
        "center-center" => "центр-центр",
        "center-right" => "центр-право",
        "bottom-left" => "низ-левый угол",
        "bottom-center" => "низ-центр",
        "bottom-right" => "низ-правый угол",
    );

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Options';
    }

}
