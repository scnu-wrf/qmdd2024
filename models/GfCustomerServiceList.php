<?php

class GfCustomerServiceList extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_customer_service_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' => 'ID',
			'code' => '服务流水号',
			'problem_type_name' => '业务类型',
			's_gfid' => '发送者GF_ID',
			's_gf_account' => '发送者帐号',
			's_gf_name' => '发起者姓名',
			's_gf_phone' => '发起者联系电话',
			's_gf_mail' => '发起者电子邮箱',
			's_ip_address' => '发起者所在IP地址',
			's_region' => '发起者所在区域',
			'r_adminid' => '接收者管理员ID',
			'r_adminaccount' => '接收者GF_ACCOUNT',
			's_time' => '发送时间',
			'e_time' => '结束时间',
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
