<?php

class gfserverarea extends BaseModel {

    public function tableName() {
        return '{{gf_server_area}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('server_id', 'required', 'message' => '{attribute} 不能为空'),
            array('server_country_code', 'required', 'message' => '{attribute} 不能为空'),
            array('server_country_name', 'required', 'message' => '{attribute} 不能为空'),
            array('server_region_code', 'required', 'message' => '{attribute} 不能为空'),
            array('server_region_name', 'required', 'message' => '{attribute} 不能为空'),

            //array('type,type_id,relation_type,relation_id', 'numerical', 'integerOnly' => true),
            //array('relation_ico, relation_name, relation_json_attr, relation_num', 'safe'),
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
            'server_id' => '服务器ID',
            'server_country_code' => '所在国家代码',
            'server_country_name' => '所在国家名称',
            'server_region_code' => '所在地区代码',
            'server_region_name' => '所在地区名称',
            
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
