<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PositionWidget
 *
 * @author andrey
 */
class PositionWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $name;
    public $cssclass;
    public $skipclear = false;
 
    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('index', array(
            'name' => $this->name,
            'cssclass' => $this->cssclass,
            'skipclear' => $this->skipclear,
        ));
    }
}
