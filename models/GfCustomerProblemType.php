<?php

class GfCustomerProblemType extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_customer_problem_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('name', 'required', 'message' => '{attribute} 不能为空'),
            array('id,name,fater_id', 'safe'),
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
			'name' => '业务类型名称',
			'fater_id' => '父级业务类型',
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
