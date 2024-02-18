<?php

class Gfnoset extends BaseModel {

    public function tableName() {
        return '{{gf_idel_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_code', 'required', 'message' => '{attribute} 不能为空'),
            array('f_name', 'required', 'message' => '{attribute} 不能为空'),
            array('f_mode', 'required', 'message' => '{attribute} 不能为空'),
            array('f_start, f_end,f_vip,f_len,f_gfid,f_date', 'safe'),
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
            'f_code' => '代码',
            'f_name' => '名称',
            'f_start' => '开始号码',
            'f_end' => '结束号码',
            'f_len' => '长度',
            'f_gfid' => '操作ID', 
            'f_len' => '名称',
            'f_date' => '修改时间',
            'f_vip' => '生成VIP', 
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
