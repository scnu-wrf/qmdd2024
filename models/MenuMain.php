<?php

class MenuMain extends BaseModel {
    public $role_code='';
    public function tableName() {
        return '{{qmdd_menu_main}}';//_copy
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
        array('f_name,f_code,f_image', 'safe'),
        );
    }

    /**
     * 模型关联规则 
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }
}
 

