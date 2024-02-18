<?php

class MallContractPrice extends BaseModel {

    public function tableName() {
        return '{{mall_contract_price}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   //array('event_title', 'required', 'message' => '{attribute} 不能为空'),
		   array('set_id,set_code,set_name,no,product_id,product_code,product_name,json_attr,purchase_quantity,up_quantity,purchase_price,if_dispay,u_date,star_time,end_time,down_time,supplier_id,supplier_name,f_check,f_check_name', 'safe'),
        
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'f_check'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		/*
		    'id' =>'ID',
            'c_code' =>'方案编号',
            'c_title' => '合同标题',
            'c_no' => '合同编号',
			'if_user_state' => '是否使用',
            'user_state_name' => '使用状态',
            'star_time' => '有效起始时间',
			'end_time' => '有效截止时间',
			'supplier_id' =>'供应商',
            'add_adminid' => '添加管理员',
            'update_date' => '添加时间',
            'f_check' => '审核状态',
			'reasons_adminID' => '操作员',
			'reasons_for_failure' => '操作备注',
			'reasons_time' => '审核时间',
			
			'data_sourcer_bz' => '备注说明',
			'down_time' => '下架时间',
			*/

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
            $this->u_date = date('Y-m-d H:i:s');
        }
        return true;
    }

}
