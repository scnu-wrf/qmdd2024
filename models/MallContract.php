<?php

class MallContract extends BaseModel {
	public $product = '';

    public function tableName() {
        return '{{mall_contract}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   array('c_title', 'required', 'message' => '{attribute} 不能为空'),
		   array('supplier_id', 'required', 'message' => '{attribute} 不能为空'),
		  array('star_time', 'required', 'message' => '{attribute} 不能为空'),
		  array('end_time', 'required', 'message' => '{attribute} 不能为空'),
		   array('c_title,c_no,supplier_id,supplier_name,if_user_state,user_state_name,star_time,end_time,down_time,add_adminid,update_date,f_check,f_check_name,reasons_adminID,reasons_admin_nick,reasons_for_failure,reasons_time,data_sourcer_bzif_del,down_up,service_id', 'safe'),
        
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_contract_price' => array(self::HAS_MANY, 'MallContractPrice', array('id' => 'set_id')),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'f_check'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'c_code' =>'编码',
            'c_title' => '合同标题',
            'c_no' => '合同编号',
			'if_user_state' => '是否使用',
            'user_state_name' => '使用状态',
            'star_time' => '起始时间',
			'end_time' => '截止时间',
			'supplier_id' =>'供应商',
            'add_adminid' => '添加管理员',
            'update_date' => '添加时间',
            'f_check' => '审核状态',
			'reasons_adminID' => '操作员',
			'reasons_for_failure' => '操作备注',
			'reasons_time' => '审核时间',
			'data_sourcer_bz' => '备注说明',

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
            $this->update_date = date('Y-m-d H:i:s');
            $this->add_adminid = Yii::app()->session['admin_id'];
        }
        $this->reasons_adminID = Yii::app()->session['admin_id'];
        $this->reasons_admin_nick = Yii::app()->session['gfnick'];
        $this->reasons_time = date('Y-m-d H:i:s');
        return true;
    }

}
