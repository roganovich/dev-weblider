<?php

class FuelsCalculator extends CFormModel {

    public $homeArea;
    public $ceilingHeight;
    public $kpd;

    public function rules() {
        return array(
            array('homeArea, ceilingHeight, kpd', 'required'),
            array('homeArea, ceilingHeight', 'numerical'),
            array('kpd', 'numerical', 'integerOnly' => true, 'min'=>0, 'max'=>100),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'homeArea' => 'Отапливаемая площадь',
            'ceilingHeight' => 'Высота потолков',
            'kpd' => 'КПД котла',
        );
    }
}
