<?php

class ClubServiceReply extends BaseModel {

    public function tableName() {
        return '{{club_service_reply}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'apply_club_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'reply_project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_code' => '服务编号',
            'service_type' => '服务类型',
            'title' => '服务标题',
            'type_code' => '服务类型',
            'data_id' => '服务人/场地',
            'level_code' => '等级编码',
            'imgUrl' => '缩略图',
            'service_pic_img' => '滚动图',
            'id' => '自增ID',
            'order_detail_code' => '约单编码',
            'apply_club_id' => '申请单位',
            'reply_project_id' => '申请项目',
            'reply_service_id' => '应约单位提供服务ID',    //关联club_service_deta表ID
            'reply_service_name' => '应约单位提供服务说明',
            'reply_service_datailed_id' => '应约单位提供服务时间ID',
            'reply_service_datailed_time' => '应约单位提供服务时间',
            'apply_time' => '申请时间',
            'state' => '状态，关联base_code表STATE类型状态id：371-374',
            'order_num' => '确认后生成的订单号',
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
