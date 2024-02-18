<?php

class MallLowerSet extends BaseModel {
	public $product = '';
	public $pricing = '';
	public $post_list = '';

    public function tableName() {
        return '{{mall_price_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('event_title', 'required', 'message' => '{attribute} 不能为空'),
            array('event_title,pricing_type,if_user_state,star_time,end_time,supplier_id,add_adminid,update_date,f_check,reasons_adminID,reasons_for_failure,reasons_time,product,pricing,post_list,mall_member_price_id,salesperson_profit_id,flash_sale,down_time,down_up,apply_time', 'safe'),
        
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_price_set_details' => array(self::HAS_MANY, 'MallPriceSetDetails', array('id' => 'set_id')),
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
            'event_code' =>'下架编号',
            'event_title' => '下架标题',
            'pricing_type' => '订单类型',
			'pricing_type_name' => '订单类型',
			'if_user_state' => '上下线状态',
            'user_state_name' => '上下线状态名',
            'star_time' => '上线时间',
			'end_time' => '下线时间',
			'supplier_id' =>'商家名称',
			'supplier_name' =>'供应商名',
            'add_adminid' => '添加管理员',
            'update_date' => '操作时间',
            'apply_time' => '申请时间',
            'f_check' => '审核状态',
            'f_check_name' => '审核状态名',
			'reasons_adminID' => '操作员',
			'reasons_admin_nick' => '审核操作员昵称',
			'reasons_for_failure' => '操作备注',
			'reasons_time' => '审核时间',
			'mall_member_price_id' => '定价方案',
			'mall_member_price_name' => '销售成员价格方案名',
			'salesperson_profit_id' => '毛利分配方案',
			'salesperson_profit_name' => '商品毛利分配方案名',
			'flash_sale' => '是否用于限时抢',
			'down_time' => '下架时间',
			'data_sourcer_table' => '上架关联数据表',
			'data_sourcer_id' => '数据来源表',
			'data_sourcer_name' => '数据来源名称',  // 例如比赛名称等
			'data_sourcer_bz' => '备注说明',
			'if_del' => '是否逻辑删除',
			'down_up' => '上下架类型',  // 1上架，-1下架
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
			$this->update_date = date('Y-m-d h:i:s');
			$this->add_adminid = get_session('admin_id');
        }
        $this->reasons_adminID = get_session('admin_id');
        $this->reasons_admin_nick = get_session('admin_name');
        $this->reasons_time = date('Y-m-d h:i:s');
        return true;
    }

}
