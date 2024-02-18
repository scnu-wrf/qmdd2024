<?php

class MallSalesOrderInfo extends BaseModel {
	public $order_state = '';
	public $is_pay = '';
	public $logistics_state = '';
	public $content = '';
	public $deliver_num = '';
	public $bean_discount = '';
    public $supplier_name = '';

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{mall_sales_order_info}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'order_record' => array(self::HAS_MANY, 'OrderRecord', array('order_num' => 'order_num')),
			'order_data' => array(self::BELONGS_TO, 'MallSalesOrderData', array('order_num' => 'order_num')),
			'best_time' => array(self::BELONGS_TO, 'BaseCode', 'best_delivery_time'),
	    );
    }
   public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
	    'id' =>'ID',
        'type' =>'类型',
        'order_num' => '订单号',
        'order_type' => '订单类型',
        'product_title' => '产品名称',
		'order_type_name' => '订单类型',
		'rec_name' => '收件人',
        'rec_code' => '收货地区',
        'rec_address' => '收货地址',
		'rec_phone' => '联系电话',
		'zipcode' =>'邮编号码',
        'best_delivery_time' => '送货时间',
        'product_ico' => '商品图片',
        'buyer_type' => '购买人类型',
		'order_gfid' => '预订人',
		'order_gfaccount' => '下单帐号',
		'order_gfname' => '下单人',
        'order_Date' =>'下单时间',
        'isReceipt' => '是否开发票',
        'money' => '商品总费用',
		'post' => '运费小计(元)',
        'post_Insurance' => '运费保险费',
        'beans' => '订单总花体育豆数量',
		'beans_discount' => '体育豆(个)',
		'coupon_discount' =>'券抵扣',
        'order_money' => '订单总金额(元)',
        'wallet_pay' => '钱包余额支付金额',
		'merchant_discount' => '商家优惠',
		'total_money' => '实付金额(元)',
		'leaving_a_message' => '留言备注',
		'return_order_num' => '退货单对应订单号',
        'ret_amount' => '实际退款金额',
		'contact_phone' => '联系电话',
		'confirmation_code' => '确认码',
        'pay_gfcode' => '支付订单号',
        'pay_type' => '支付方式',
		'pay_supplier_type' => '支付方式',
		'payment_code' =>'支付流水号',
        'pay_time' => '支付时间',
        'if_del' => '是否逻辑删除订单',
		'order_state' => '订单状态',
		'is_pay' => '支付状态',
		'logistics_state' => '发货状态',
		'content' => '操作备注',
		'deliver_num' => '此次发货数量',
		'order_title' => '下架标题',//的时候，
		'up_down_id' => '上下架单号',  // mall_price_set-id
		'up_down_code' => '上下架编号',  // mall_price_set-的event_code
        'json_attr' => '规格',
        'buy_count' => '数量',

        'audit_state' => '审核状态',
        'reasons_for_failure' => '备注',
        'ticket_cost' => '门票费用',
        'audited_by' => '审核人',
        'audit_time' => '审核时间',
        );
    }

    
	
	protected function beforeSave() {
        parent::beforeSave();
        // if ($this->isNewRecord) {
		// 	$this->update_date = date('Y-m-d h:i:s');
		// 	$this->add_adminid = Yii::app()->session['admin_id'];
        // }
        //$this->reasons_adminID = Yii::app()->session['admin_id'];
        //$this->reasons_admin_nick = Yii::app()->session['gfnick'];
        //$this->reasons_time = date('Y-m-d h:i:s');
        return true;
    }
	
    //从购物车生产销售单
    public  function saveOrderinfo($data){
       $this->attributes=$data->attributes;
       $this->isNewRecord = true;
       unset($this->id);
       $this->pay_time = date('Y-m-d H:i:s');
       $this->total_money = 0;
       $rs=$this->save();
       $tmp = new OrderRecord();
       $tmp->saveOrderRec($data);
       return $rs;
    }
    

	/**
	 * 商品下架订单号
	 */
    public function get_new_order_num() {
        $num = date('Ymd');
        $num1= '000000';  
        $orderinfo = $this->find("left(order_num,8)='".$num."' order by order_num DESC");
        if(!empty($orderinfo)){
            $num1=$orderinfo->order_num;
        }
        return $num.substr(''.(1000001+substr($num1, -6)),1,6);
    }
    
    
    /**
     * 写入退货／退款订单
     */
    public function addRefundOrder($param){
    	$add_order = new MallSalesOrderInfo();
        $param['order_Date'] = get_date();
        $sv=$add_order->insert($param);
        $id=$sv?$add_order->id:0;
        $order_num=empty($param['order_num'])?'':$param['order_num'];
        if($sv&&empty($order_num)){
        	$order_num=$this->updateRefundOrderNum($id,$add_order['buyer_type'],$add_order['order_gfid']);
        	$sv=$add_order->update(array('order_num'=>$order_num));
        }

        return array('id'=>$id,'order_num'=>$order_num);
    }
	/**
	 * 生产退货／退款订单号
	 */
	function updateRefundOrderNum($car_id,$buyer_type,$order_gfid) {
		if ($car_id <= 0) {
			return "";
		}
		$code_head='';
		$dbnum=getShowUrl('db_num');
		if($dbnum==2){//内测
			$code_head='qmdd';
		}else if($dbnum==3){//公测
			$code_head='qmdd2';
		}
		if($buyer_type==502){
			$array=ClubList::model()->find("id=".$order_gfid);
			$gfaccount=empty($array)?'':$array->club_code;
		}else{
			$array=userlist::model()->find("GF_ID=".$order_gfid);
			$gfaccount=empty($array)?'':$array->GF_ACCOUNT;
		}
		$car_order=BaseNo::model()->get_table_code_base(array('table_name'=>'mall_sales_order_info','code_table_name'=>'mall_shopping_settlement','code_param'=>'order_num','id_param'=>'id','code_length'=>'2','table_id'=>$car_id,'code_year'=>date("Y"),'code_month'=>date("m"),'code_day'=>date("d"),'code_head'=>$code_head,'code_gfaccount'=>$gfaccount,'code_gfaccount_len'=>10));
		return $car_order;
	}
}
