<?php

class DragonTigerUserlist extends BaseModel {
    public function tableName() {
        return '{{dragon_tiger_userlist}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('order_num,check_number,gf_account,gf_name,if_pass,add_time,end_time,grade,member_type_name,member_type,grade_name,project_id','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(

            'orderNum' => array(self::BELONGS_TO, 'MallSalesOrderInfo', 'order_num'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList','project_id'),
			'useranswer' => array(self::HAS_MANY, 'DragonTigerUserAnswer', array('check_number'=>'check_number')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'order_num' => '订单号',
            'check_number' => '考核编号',
            'gf_account' => '考核人帐号',
            'gf_name' => '用户名',
            'if_pass' => '是否通过',
            'if_pass_name' => '是否通过',
            'add_time' => '考核时间',
            'end_time' => '考核结束时间',
            'member_type' => '会员类型',
            'member_type_name' => '会员类型名称',
            'grade' => '会员等级',
            'grade_name' => '会员等级名称',
            'project_name' => '项目名称',
            'achievement' => '本次考核成绩',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }
}
