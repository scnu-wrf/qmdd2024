<?php

class ThirdPartyLogin extends BaseModel {
	public $show=0;
    public function tableName() {
        return '{{third_party_login}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='third_type,third_name,openid,third_user_id,gf_id,gf_account,logout';
        return [
            array($s2,'safe',), 
        ];
	}
	public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			
		);
    }

    /**
     * 属性标签  该官方账号已注销（已注销可以重新注册），关联base_code表yes_no类型id 648=否，649是',
     * 用户统一标识。微信unionid，支付宝user_id
        );
     */
    public function attributeLabels() {
        return array(
            'id' => '自增ID',
            'third_type' => '第三方登录',//，1-qq，2-微信，3-新浪微博，4-支付宝',
            'third_name' => '第三方名称',
            'openid' => '用户标识',//微信普通用户的标识，对当前开发者帐号唯一
            'third_user_id' => '统一标识',
            'gf_id' => 'gf_id',//userlist的
            'gf_account' => 'gf_account',//userlist的
            'logout' => '注销' //0 否 1 是
           
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
