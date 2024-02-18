<?php

class Carinfo extends BaseModel {
	public $content = '';

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{shopping_car_info}}';
    }

    /**  * 模型关联规则 */
    public function relations() {
        return array( );
    }
    /*** 模型验证规则*/
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
        'product_title' => '产品名称',
        'order_num' => '订单号',
        'buy_count' => '数量',
        'order_type' => '订单类型',
		'rec_name' => '收件人',
        'rec_code' => '收货地区',
        'rec_address' => '收货地址',
		'rec_phone' => '收件人电话',
		'zipcode' =>'邮编号码',
        'best_delivery_time' => '送货时间',
        'product_ico' => '商品图片',
        'buyer_type' => '购买人类型',
		'order_gfid' => '下单人',
        'order_Date' =>'下单时间',
        'isReceipt' => '是否开票',
        'money' => '商品总金额',
		'post' => '总运费',
        'post_Insurance' => '运费保险费',
        'beans' => '豆数量',
		'beans_discount' => '豆抵扣',
		'coupon_discount' =>'优惠券抵扣',
        'order_money' => '订单总金额',
        'wallet_pay' => '钱包支付额',
		'merchant_discount' => '商家优惠金额',
		'total_money' => '实付金额',
		'leaving_a_message' => '留言备注',
		'contact_phone' => '下单人电话',
        'if_del' => '逻辑删除',
		'content' => '操作备注',
        'fee_data_list' => '缴费明细表',  //club_membership_fee_data_list的ID',
        'effective_time' => '支付倒计时',
        'json_attr' => '规格',
        'buy_count' => '数量',
        );
    }
	protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
	/**
	 * 生成待支付订单号
	 */
    public function get_order_num($account) {
        return getAutoNo('Carinfo',$account);
    }
    /**
     * 写入待支付订单
     */
    public function addOrder($param){
        $param['order_Date'] = get_date();
        $param['order_num']='';
        unset($param['id']);
    	$add_order = new Carinfo();
        $sv=$add_order->insert($param);
        if(!empty($add_order->id)){
	        $id=$sv?$add_order->id:0;
	        $order_num=empty($param['order_num'])?'':$param['order_num'];
	        
	        if($sv&&empty($order_num)){
	        	$order_num=$this->updateCarOrderNum($id,$add_order['buyer_type'],$add_order['order_gfid']);
	        	$sv=$add_order->update(array('order_num'=>$order_num));
	        }
	        if($sv){
	        	return array('id'=>$id,'order_num'=>$order_num);
	        }
        }
        return array('id'=>$id,'order_num'=>$order_num);
    }
	/**
	 * 生产待支付订单号
	 */
	function updateCarOrderNum($car_id,$buyer_type,$order_gfid) {
		return $car_order;
	}

}
