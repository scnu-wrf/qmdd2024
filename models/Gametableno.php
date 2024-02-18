<?php

class Gametableno extends BaseModel {

    public function tableName() {
        return '{{game_table_no}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_date,f_no,f_namea,f_nameb,f_selected', 'safe'),
        );
    }


    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'f_code' => '编码',  // 如台球TA,兵兵球BP
            'f_no' => '台号',
            'f_namea' => '姓名A',
            'f_nameb' => '姓名B',
            'f_selected' => '是否选择',  // 0：未选择 1已选择
            'f_time' => '时间',
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
        $this->f_date=date("Y-m-d");
        return true;
    }
    



}
