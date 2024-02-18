<?php

class ClubReportRecord extends BaseModel {
    public function tableName() {
        return '{{club_report_record}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,report_id,connect_id,connect_code,connect_title,content,add_time,dispose_time', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'report_content' => array(self::BELONGS_TO, 'ClubReport', 'report_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '内部自增id',
            'report_id' => '举报信息id，club_report表id',
            'report_content'=>'举报内容',
            'connect_id'  =>  '操作人id(举报会员gfid／客服id)',
            'connect_code'  =>  '操作人帐号或编码(举报会员gf账号／客服账号)',
            'connect_title'  =>  '操作人名称',
            'content'  =>  '操作内容',
            'add_time'  =>  '指派时间',
            'club2_id'  =>  '部门id',
            'club2_name'  =>  '指派处理部门',
            'state'  =>  '处理状态',
            'state_name'  =>  '处理状态',
            'deal_state'  =>  '处理意见',
            'deal_state_name'  =>  '处理意见',
            'dispose_time' => '处理时间'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
