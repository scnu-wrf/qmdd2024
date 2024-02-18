<?php

class GfCustomerTypeSet extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_customer_type_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('type_1', 'required', 'message' => '{attribute} 不能为空'),
			array('type_2', 'required', 'message' => '{attribute} 不能为空'),
			array('problem_type', 'required', 'message' => '{attribute} 不能为空'),
			array('customer_service_type', 'required', 'message' => '{attribute} 不能为空'),
            array('id,type_1,type_name_1,type_2,type_name_2,problem_type,customer_service_type', 'safe'),
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
			'type_1' => '会员类型（一级）',
			'type_name_1' => '会员类型名称（一级）',
			'type_2' => '会员类型（二级）',
			'type_name_2' => '会员类型名称（二级）',
			'problem_type' => '业务类型',
			'customer_service_type' => '客服类型',
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
