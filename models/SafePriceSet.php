<?php

class SafePriceSet extends BaseModel {
	public $product = '';

    public function tableName() {
        return '{{safe_price_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   array('event_title', 'required', 'message' => '{attribute} 不能为空'),
		   //array('pricing_type', 'required', 'message' => '{attribute} 不能为空'),
		   array('supplier_id', 'required', 'message' => '{attribute} 不能为空'),
		   array('mall_member_price_id', 'required', 'message' => '{attribute} 不能为空'),
		  // array('salesperson_profit_id', 'required', 'message' => '{attribute} 不能为空'),
		  array('star_time', 'required', 'message' => '{attribute} 不能为空'),
		  array('end_time', 'required', 'message' => '{attribute} 不能为空'),
		  array('down_time', 'required', 'message' => '{attribute} 不能为空'),
		   array('event_title,pricing_type,if_user_state,star_time,end_time,supplier_id,add_adminid,update_date,f_check,reasons_adminID,reasons_for_failure,reasons_time,product,pricing,post_list,mall_member_price_id,salesperson_profit_id,flash_sale,down_time', 'safe'),
        
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'safe_price_set_details' => array(self::HAS_MANY, 'SafePriceSetDetails', array('id' => 'set_id')),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'f_check'),
			'pricingtype' => array(self::BELONGS_TO, 'BaseCode', 'pricing_type'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
			'member_price' => array(self::BELONGS_TO, 'MallMemberPriceInfo', 'mall_member_price_id'),
			'salesperson_profit' => array(self::BELONGS_TO, 'GfSalespersonInfo', 'salesperson_profit_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'event_code' =>'方案编号',
            'event_title' => '方案标题',
            'pricing_type' => '订单类型',
			'pricing_type_name' => '订单类型',
			'if_user_state' => '上下线状态',
            'user_state_name' => '上下线状态',
            'star_time' => '上线时间',
			'end_time' => '下线时间',
			'supplier_id' =>'供应商',
            'add_adminid' => '添加管理员',
            'update_date' => '添加时间',
            'f_check' => '审核状态',
			'reasons_adminID' => '操作员',
			'reasons_for_failure' => '操作备注',
			'reasons_time' => '审核时间',
			
			'mall_member_price_id' => '定价方案',
			'salesperson_profit_id' => '毛利分配方案',
			'flash_sale' => '是否显示限时抢购设置',
			'down_time' => '下架时间',

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
            $this->pricing_type=361;
        }
        $this->reasons_adminID = Yii::app()->session['admin_id'];
        $this->reasons_admin_nick = Yii::app()->session['gfnick'];
        $this->reasons_time = date('Y-m-d H:i:s');
        return true;
    }

}
