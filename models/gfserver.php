<?php

class gfserver extends BaseModel {

    public function tableName() {
        return '{{gf_server}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('server_code', 'required', 'message' => '{attribute} 不能为空'),
            array('server_adminid', 'required', 'message' => '{attribute} 不能为空'),
            array('server_type', 'required', 'message' => '{attribute} 不能为空'),
            //array('server_type_name', 'required', 'message' => '{attribute} 不能为空'),
            array('server_item', 'required', 'message' => '{attribute} 不能为空'),
            //array('server_item_name', 'required', 'message' => '{attribute} 不能为空'),
            array('server_name', 'required', 'message' => '{attribute} 不能为空'),
            array('server_ip_address', 'required', 'message' => '{attribute} 不能为空'),
            array('server_area', 'required', 'message' => '{attribute} 不能为空'),
            //array('longitude', 'required', 'message' => '{attribute} 不能为空'),
            //array('latitude', 'required', 'message' => '{attribute} 不能为空'),
            //array('if_user', 'required', 'message' => '{attribute} 不能为空'),
            //array('if_del', 'required', 'message' => '{attribute} 不能为空'),
            //array('add_time', 'required', 'message' => '{attribute} 不能为空'),
            
           // array('type,type_id,relation_type,relation_id', 'numerical', 'integerOnly' => true),
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
            'server_code' => '服务器代码',
            'server_adminid' => '管理员ID',
            'server_type' => '服务器类型',
            'server_type_name' => '类型名称',
            'server_item' => '项目',
            'server_item_name' => '项目名称',
            'server_name' => '服务器名称',
            'server_ip_address' => 'ip地址',
            'server_area' => '服务器区域',
            'longitude' => '经度',
            'latitude' => '纬度',
            'if_user' => '是否在用',
            'if_del' => '是否删除',
            'add_time' => '加入时间',
            //'support' => '',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
