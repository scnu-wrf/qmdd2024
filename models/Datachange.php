<?php

class Datachange extends BaseModel {
    public $selectval=array(2);
    public function tableName() {
        return '{{table_update}}';
    }
  /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_table', 'required', 'message' => '{attribute} 不能为空'),
            array($this->safeField(),'safe'), 
        );
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
            'f_data' => '修改数据',
            'f_table' => '表名',
            'f_update' => '删改',
            'f_user' => '操作者',
            'f_time' => '修改时间',
            'f_ip' => '修改ip',
            'f_field' => '主健名',
            'f_value' => '主健',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();      
        return true;
    }

}
