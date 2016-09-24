<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlockHelper
 *
 * @author andrey
 */
class PositionHelper extends CComponent {
    
    private $_blockInPosition;
    private $_blockNotInPosition;
    private $_position;
    private $_parent;
    private $_url;
    private $_disableNotInherit;

    public $inherit = false;

    public function __construct($position, $url = null, $disableNotInherit = false) {
        $this->_position = $position;
        $this->_url = ($url != null) ? $url : self::getUrlRef();
        $this->_disableNotInherit = $disableNotInherit;
//        echo $this->url."<br/>";
    }

    public function getPosition() {
        return $this->_position;
    }
    
    public function getParent() {
        if(!$this->_parent){
            if($this->url == Materials::getIndexPage()->url) return $this->_parent;
            $material = Materials::model()->findByAttributes(array(
                'url' => $this->url
            ));
            if($material){
                if($material->parent){
                    $url = $material->parent->url;
                } else {
                    $url = Materials::getIndexPage()->url;
                }
                $this->_parent = new PositionHelper($this->position, $url, true);
            }
        }
        return $this->_parent;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function getNoneBlock() {
        return BlockNonePosition::model()->findByAttributes(array(
            'position' => $this->position,
            'url' => $this->url,
        ));
    }
    
    public function savePosition($data) {
        $this->clearPosition();
        $errors = false;
        if ($data['none_blocks']) {
                $model = new BlockNonePosition();
                $model->position = $this->position;
                $model->url = $this->url;
                if(!$model->save()) $errors = true;
            } else {
            if ($data['id_array']) {
                foreach ($data['id_array'] as $level => $id) {
                    if ($block = Blocks::model()->findByPk($id)) {
                        $model = new BlocksPosition();
                        $model->block_id = $block->id;
                        $model->notinherit = isset($data['notinherit'][$id]);
                        $model->level = $level + 1;
                        $model->position = $this->position;
                        $model->url = $this->url;
                        if(!$model->save()) $errors = true;
                    }
                }
            }
        }
        return !$errors;
    }

    public function clearPosition() {
        BlocksPosition::model()->deleteAll('position = :position AND url = :url', array(
            ':position' => $this->position,
            ':url' => $this->url
        ));
        BlockNonePosition::model()->deleteAll('position = :position AND url = :url', array(
            ':position' => $this->position,
            ':url' => $this->url
        ));
    }

    public function findBlockInPosition() {
        $return = array();
        $blocks = Blocks::model()->findAll(array(
                    'select' => 't.*, bp.notinherit',
                    'join' => 'JOIN blocks_position bp on block_id = t.id',
                    'condition' => 'bp.position = :position AND bp.url = :url',
                    'order' => 'bp.level',
                    'params' => array(
                        ':position' => $this->position,
                        ':url' => $this->url
                    )
        ));
        if($blocks && $this->_disableNotInherit){
            foreach($blocks as $block){
                if(!$block->notinherit)
                    $return[] = $block;
            }
        } else {
            $return = $blocks;
        }
        return $return;
    }
    
    
    
    public function getBlockInPosition() {
        if(!$this->_blockInPosition && !$this->noneBlock){
            $this->_blockInPosition = $this->findBlockInPosition();
            if(!$this->_blockInPosition && $this->parent){
                $this->inherit = true;
                $this->_blockInPosition = $this->parent->blockInPosition;
            }
        }
        return $this->_blockInPosition;
    }

    public function getBlockNotInPosition() {
        if(!$this->_blockNotInPosition){
            $criteria = new CDbCriteria;
            $idBlocksInPosition = array();
            if($this->blockInPosition){
                foreach($this->blockInPosition as $block){
                    $idBlocksInPosition[] = $block->id;
                }
                $criteria->addNotInCondition('t.id', $idBlocksInPosition);
            }
            $criteria->join = 'JOIN template_position tp ON tp.template_id = t.template_id';
            $criteria->addCondition('tp.position = "'.$this->position.'"');
            $criteria->distinct = true;
            $this->_blockNotInPosition = Blocks::model()->findAll($criteria);
        }
        return $this->_blockNotInPosition;
    }

    public static function getUrlRef() {
        $referrer = Yii::app()->request->urlReferrer;
        if (!strpos($referrer, 'backend')) {
            if ($referrer == Yii::app()->request->hostInfo . "/") {
                $url = Materials::getIndexPage()->url;
            } else {
                $url = str_replace(Yii::app()->request->hostInfo, "", $referrer);
            }
            Yii::app()->session['url_for_blocks_in_position'] = trim($url, '/');
        }
        return Yii::app()->session['url_for_blocks_in_position'];
    }

}
