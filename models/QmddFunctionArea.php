<?php

class QmddFunctionArea extends BaseModel {

    public function tableName() {
        return '{{qmdd_function_area}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(array($this->safeField(), 'safe'));
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
        return array(
            'id' => 'ID',
            'area_name' => '区域名称',
        );
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
