<?php

class ReturnGoods extends BaseModel {
	public $order_state = '';
	public $is_pay = '';
	public $logistics_state = '';
	public $content = '';
	public $deliver_num = '';
	public $goods_num = '';

    public function tableName() {
        return '{{return_goods}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('return_club_tel', 'numerical', 'integerOnly' => true),
            array('return_club_mail_code', 'numerical', 'integerOnly' => true),
            array('desc,sale_money,ret_count,ret_money,state,ret_no,ret_date,ren_name,take_over,take_date,take_name,after_sale_state,change_no,change_logistics_id,change_logistics_name,change_date, return_club_address,return_sale__address,return_club_name,return_club_tel,return_club_mail_code,supplier_id,order_type,good_sent,act_ret_money,ret_pay_supplier_type,ret_payment_code,ret_message,change_post,state_user_gfaccount,ren_gfaccount', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'order_record' => array(self::HAS_MANY, 'OrderRecord', array('order_num' => 'order_num')),
			'orderdata' => array(self::BELONGS_TO, 'MallSalesOrderData', 'order_data_id'),
			'orderdata_return' => array(self::BELONGS_TO, 'MallSalesOrderData','buy_order_data_id'),
			'orderinfo' => array(self::BELONGS_TO, 'MallSalesOrderInfo', array('order_num' => 'order_num')),
			'change_base' => array(self::BELONGS_TO, 'BaseCode', 'change_type'),
			'ret_number' => array(self::BELONGS_TO, 'OrderInfoLogistics', array('ret_logistics'=>'logistics_number')),
            'logistics' => array(self::BELONGS_TO, 'MallLogistic', 'change_logistics_id'),
			'base_good_sent' => array(self::BELONGS_TO, 'BaseCode', 'good_sent'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
            'product' => array(self::BELONGS_TO, 'MallProducts', 'ret_product_id'),
            'buy_orderdata' => array(self::BELONGS_TO, 'MallSalesOrderData', 'buy_order_data_id'),
            'ret_pay' => array(self::BELONGS_TO, 'BaseCode', 'ret_pay_supplier_type'),
            'refund_amount' => array(self::BELONGS_TO, 'MallSalesOrderData', array('order_info_id'=>'info_id')),
            'ordertype' => array(self::BELONGS_TO, 'BaseCode', 'order_type'),
            'mall_sales_order_data1' => array(self::BELONGS_TO, 'MallSalesOrderData', array('return_order_num' => 'order_num')),
            'reasonid' => array(self::BELONGS_TO, 'MallReturnSet', 'return_id'),
        );
    }
    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'order_num' => '售后单号',  // 关联mall_sales_order_data表order_num,退货/换货单号
            'return_order_num' => '订单编号',
            'order_data_id' => '退货商品明细表ID',  // 关联mall_sales_order_data表id',
            'order_gfid' => '申请人', // gfid
            'order_account' => '申请人账号',
            'gf_name' => '申请人名称',
            'desc' => '审核备注',
            'return_id' => '售后原因',  // ,关联mall_return_set表ID
            'return_reason' => '售后原因',  // 取BASECODE退货原因ID,关联mall_return_set表name
            'reason' => '售后说明',  // 退货者说明的描述',
            'sale_money' => '销售金额',
            'ret_count' => '退换数量',
            'ret_money' => '退款金额',
            'change_type' => '售后类型',
            'img' => '售后相关图片',  // |为分隔符',
            'state_user_id' => '操作员',
            'state_user_name' => '审核操作员',
            'uDate' => '确认时间',
            'state' => '退款状态',  // 关联base_code表ORDERTYPE类型ID为465已确认,466退款单，467已分单,468交易关闭,469交易完成,,470待审核
            'state_name' => '状态名称',
            'order_date' => '申请时间',
            'ret_no' => '财务退款凭证号',
            'ret_date' => '操作时间',
            'ren_name' => '操作员',//财务退款人
            'ret_desc' => '退款备注',//财务退款备注
            'ret_logistics_id' => '物流ID',
            'ret_logistics' => '退货物流单号',
            'ret_logistics_name' => '退货物流公司',
            'ret_time' => '提交时间',
            'change_logistics_id' => '换货物流公司',
            'change_logistics_name' => '换货物流公司',
            'change_no' => '换货物流单号',
            'change_date' => '退货时间',
            'change_post' => '邮费',
            'cancel' => '申请取消状态',  // 1145正常，1146取消
            'cancel_name' => '申请取消状态名称',  // 1145正常，1146取消
            'take_over' => '收货说明',
            'take_date' => '收货日期',
            'take_name' => '收货人',
            'after_sale_state' => '售后状态',  // 关联表base_code中AFTERSALESTATE对应状态',
            'after_sale_state_name' => '售后状态名称',
            'return_club_address' => '退货地址',
            'return_sale__address' => '换货地址',
            'return_club_name' => '收货人',
            'return_club_tel' => '联系电话',
            'return_club_mail_code' => '邮政编码',
            'ret_product_id' => '换货商品ID',
            'ret_product_title' => '换货商品标题',
            'ret_product_ico' => '换货商品图片',
            'ret_json_attr' => '换货属性名称',
            'consignee_id' => '收货人',  // qmdd_administrators表id',
            'consignee_name' => '收货人名称',
            'supplier_id' => '销售商家',
            'order_type' => '订单类型',  // 表示是否是商品还是赛事分类',
            'order_type_name' => '订单类型',
            'good_sent' => '是否发货',  // 是：649，否：648

            'refunds_num' => '退款单号',
            'ret_money' => '应退款(元)',
            'ref_conf' => '退货确认',
            
            'type' =>'类型',
			'rec_name' => '收货人',
            'rec_code' => '收货地区',
            'rec_address' => '收货地址',
			'rec_phone' => '联系电话',
			'zipcode' =>'邮编号码',
            'best_delivery_time' => '最佳送货时间',
            'product_ico' => '商品图片',
            'buyer_type' => '购买人类型',
			'order_gfaccount' => '申请帐号',
			'order_gfname' => '申请人',
            'isReceipt' => '是否开发票',
            'money' => '商品总费用',
			'post' => '运费',
            'post_Insurance' => '运费保险费',
            'beans' => '订单总花体育豆数量',
			'beans_discount' => '体育豆抵扣',
			'coupon_discount' =>'优惠券抵扣',
            'order_money' => '商品金额',
            'wallet_pay' => '钱包余额支付金额',
			'merchant_discount' => '商家优惠',
			'total_money' => '实付金额',
            'leaving_a_message' => '留言备注',
            'revi_state' => '审核状态',
            'product_code' => '商品编码',
            'product_title' => '退换商品',
            'buy_count' => '退/换数量',
            'json_attr' => '型号/规格',
			
			'contact_phone' => '联系电话',
			'confirmation_code' => '确认码',
            'pay_gfcode' => '支付订单号',
            'pay_type' => '支付端',
			'pay_supplier_type' => '支付方式',
			'payment_code' =>'交易流水号',
            'pay_time' => '支付时间',
            'if_del' => '是否逻辑删除订单',
			'order_state' => '订单状态',
			'is_pay' => '支付状态',
			'logistics_state' => '商品状态',
			'content' => '操作备注',
			'deliver_num' => '此次发货数量',

            'act_ret_money' => '实退金额(元)',
            'ret_pay_supplier_type' => '退款方式',
            'ret_payment_code' => '退款交易码',
            'ret_message' => '退款备注',
            'ret_no' => '财务退款凭证号',
            'gf_name' => '下单人',
            /* index_service_pass页面自定义属性 */
            'gf_service_order_num' => '订单号/约单号',
            'service_type' => '服务类别',
            'service_title' => '服务资源',
            'service_time' => '预定服务时段',
            'service_money' => '订单总额（元）',
            'service_order_date' => '退订时间',
            'service_return_reason' => '退订原因',
            'service_return_cond' => '退订适用条件',
            'service_total_money' => '实付金额',
            'return_float_Percentage' => '扣除手续费(元)',
            'pay_id' => '支付方式',
        );
    }

    public function labelsOfList() {
        return array(
            'id',
            'order_num',
            'desc',
            'return_id',
            'reason',
            'uDate',
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

			//$this->update_date = date('Y-m-d h:i:s');
			//$this->add_adminid = Yii::app()->session['admin_id'];
        }
        //$this->reasons_adminID = Yii::app()->session['admin_id'];
        //$this->reasons_admin_nick = Yii::app()->session['gfnick'];
        //$this->reasons_time = date('Y-m-d h:i:s');
        return true;
    }

}
