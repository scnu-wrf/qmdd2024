<?php

class GfCustomerServiceMessage extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_customer_service_message}}';
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
			'code' => '流水号',
			's_gfid' => '发送者GF_ID',
			's_gf_account' => '发送者帐号',
			'r_adminid' => '客服ID',
			'r_adminaccount' => '客服帐号',
			's_time' => '发送时间',
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
