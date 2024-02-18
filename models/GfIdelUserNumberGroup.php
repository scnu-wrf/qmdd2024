<?php

class GfIdelUserNumberGroup extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_idel_user_number_group}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('not_null', 'required', 'message' => '{attribute} 不能为空'),
            array('id,number_length,number_range_start,number_range_end,is_category,create_time,total_count,nomal_count,vip_count', 'safe'),
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
			'number_length' => '号码位数',
			'number_range_start' => '号码范围起始',
			'number_range_end' => '号码范围结束',
			'is_category' => '是否分类',//648否，649是
			'create_time' => '创建时间',
			'total_count' => '号码数量',
			'nomal_count' => '普通号码数量',
			'vip_count' => 'VIP号码数量',
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
