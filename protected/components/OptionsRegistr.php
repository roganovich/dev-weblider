<?php

/**
 * Created by JetBrains PhpStorm.
 * User: mihailmatornik
 * Date: 03.04.14
 * Time: 15:40
 * To change this template use File | Settings | File Templates.
 */
class OptionsRegistr {

    static private $instance;
    private $_options = null;

    static function getInstance() {
        if (empty(self::$instance)) {
            $begin = new self();
            $rez = Options::model()->findAll();
            if ($rez) {
                foreach ($rez as $one) {
                    $begin->_options[$one->name] = $one;
                }
                self::$instance = $begin;
            }
        }
        return self::$instance;
    }

    function get($name = null) {
        if ($name == null || !isset($this->_options[$name]))
            return false;
        return $this->_options[$name]->value;
    }

    private function find($name = null) {
        if ($name == null || !isset($this->_options[$name]))
            return false;
        return $this->_options[$name];
    }

    function set($name = null, $value = 0) {
        if ($name == null)
            return false;
        if ($this->find($name)) {
            $this->find($name)->value = $value;
        } else {
            $this->_options[$name] = new Options();
            $this->find($name)->name = $name;
            $this->find($name)->value = $value;
        }
        $this->find($name)->save();
    }

}
