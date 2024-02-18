<?php

class GfIdelUserAllNumber extends BaseModel {

	public $all_num_val = '';
	
	public $not_null = '123';
    public function tableName() {
        return '{{gf_idel_user_all_number}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('all_num_val', 'required', 'message' => '未显示号码'),
			array('not_null', 'required', 'message' => '{attribute} 不能为空'),
            array('id,account,main_number,secondary_number,is_use', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'base_state' => array(self::BELONGS_TO, 'BaseCode', 'state'),
			'f_vip_state' => array(self::BELONGS_TO, 'BaseCode', 'f_vip'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' => 'ID',
			  'account' => '号码',
			  'main_number' => '主号段',
			  'secondary_number' => '次号段',
			  'gf_account_level_id' => '账号等级id',
			  'is_use' => '是否在使用',//'0否，1在用,-1 表示占用',
			  'number_length' => '号码位数',
			  'f_id' => '放号方案ID',
			  'f_vip' => '是否VIP号码',//'0普通号，1是VIP号',
			  'f_vlevel' => 'vip的级别',  //0普通级别，1一级，2二级，主要用来确定收费标准使用',
			  'f_len' => '编码长度',
			  'f_start' => '开始使用用日期',
			  'f_end' => '结束使用日期',
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
