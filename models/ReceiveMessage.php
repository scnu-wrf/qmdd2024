<?php

class ReceiveMessage extends BaseModel {

    public function tableName() {
        return '{{qmdd_administrators_receive_message}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='msg_id,s_adminid,s_club_code,s_admin_gfaccount,r_adminid,r_club_code,r_admin_gfaccount,r_admin_level,s_time,m_message,m_title,m_type,read_time,is_del,s_type';
        return [
            array($s2,'safe',), 
        ];
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'admin' => array(self::BELONGS_TO,'QmddAdministrators','s_adminid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=> 'ID',
            'msg_id' => 'qmdd_administrators_send_message的id',
            's_adminid' => '发送者',
            's_club_code' => '发送者',
            's_admin_gfaccount' => '发送者',
            'r_adminid' => '接收者',
            'r_club_code' => '接收者',
            'r_admin_gfaccount' => '接收者',
            'r_admin_level' => '接收者',
            's_time' => '发送时间',
            'm_title' => '标题',
            'm_message' => '消息内容',
            'm_type' => '消息类型',
            'read_time' => '状态',
            'is_del' => '是否删除记录,648=否，649是',
            's_type' => '1前端（gf会员） 2后台（管理员，服务机构）',
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
		if ($this->isNewRecord) {

        }
        return true;
    }

}
