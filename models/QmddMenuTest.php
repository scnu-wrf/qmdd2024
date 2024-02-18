<?php

class QmddMenuTest extends BaseModel {
    public function tableName() {
        return '{{qmdd_menu_test}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array();
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }
    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array();
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}