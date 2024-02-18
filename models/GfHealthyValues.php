<?php

class GfHealthyValues extends BaseModel {


    public function tableName() {
        return '{{gf_healthy_values}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('gf_name', 'required', 'message' => '{attribute} 不能为空'),
            // array('health_date', 'required', 'message' => '{attribute} 不能为空'),
            // array('health_state', 'required', 'message' => '{attribute} 不能为空'),
            // array('gf_account', 'required', 'message' => '{attribute} 不能为空'), 
            //array('gf_id,gf_name,health_date,health_state,club_id,club_name,add_time,gf_account','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gf_healthy_list' => array(self::BELONGS_TO, 'GfHealthyList', 'h_id'),
            'gf_healthy_model' => array(self::BELONGS_TO, 'GfHealthyModel', array('model_id'=>'id')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'h_id' => '体检表ID', // 关联gf_healthy_list表id',
            'model_id' => '体检模版表ID',  // 关联gf_healthy_model表ID',
            'attr_name' => '项目名称',
            'attr_values' => '报告值',  // model_id的attr_input_type=683，为文件存放相对路径，相关查base_parh表',
            'attr_unit' => '属性名单位',

        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
}
