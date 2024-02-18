<?php

class OrderInfoLogistics extends BaseModel {
	//public $order_state = '';
	public $orderdata = '';
	//public $content = '';

    public function tableName() {
        return '{{order_info_logistics}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   array('logistics_id', 'required', 'message' => '{attribute} 不能为空'),
		   array('logistics_number', 'required', 'message' => '{attribute} 不能为空'),
           array('orderdata', 'required', 'message' => '{attribute} 不能为空'),
		   //array('supplier_id', 'required', 'message' => '{attribute} 不能为空'),
		   array('order_num,logistics_xh,logistica_price,supplier,logistics_number,logistics_id,logistics_CODE,logistics_USERNAME,logistics_order_xh,logistics_price,buy_count,return_num,logistics_state,logistics_date,USERNAME_DATE,logistics_number,rec_name,rec_address,rec_phone,sign_date,adminID,admin_nick,reasons_for_failure', 'safe'),
        
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'mall_sales_order_data' => array(self::HAS_MANY, 'MallSalesOrderData', 'logistics_id'),
			'logistics' => array(self::BELONGS_TO, 'MallLogistic', 'logistics_id'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier'),
        );
    }
    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'logistics_xh' => '发货单号',
			'logistica_price' => '实际运费',
			'supplier' => '发货单位',
			'logistics_number' => '物流单号',
			'logistics_id' => '物流公司',
			'logistics_CODE' => '物流类型',
			'logistics_USERNAME' => '派单操作员',
			'logistics_order_xh' => '商品序号',
			'buy_count' => '此次发货数量',
			'logistics_state' => '状态',
			'logistics_date' => '发货时间',
			'USERNAME_DATE' => '操作时间',
            'reasons_for_failure' => '操作备注',
			'supplier' => '发货单位',
			'rec_name' => '收货人',
			'rec_address' => '收货地址',
			'rec_phone' => '联系电话',
            'orderdata' => '发货商品',
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
        $this->adminID = Yii::app()->session['admin_id'];
        $this->admin_nick = Yii::app()->session['gfnick'];
        $this->USERNAME_DATE = date('Y-m-d H:i:s');
		$this->logistics_USERNAME = get_session('admin_name');
        return true;
    }

}
