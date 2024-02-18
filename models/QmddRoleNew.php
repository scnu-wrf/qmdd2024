<?php

class QmddRoleNew extends BaseModel {
    public function tableName() {
        return '{{qmdd_role_new}}';
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

    public function getUserRole(){
        return $this->findAll('f_id=276 or f_id=277 or f_id=278');
    }

    protected function beforeSave() {
        parent::beforeSave();
        //$ds = explode(",",$this->f_opter);
       // sort($ds);
       // $this->f_opter=implode(",", $ds);
       // $ds = explode(",",$this->f_opter);
       
        return true;
    }

}