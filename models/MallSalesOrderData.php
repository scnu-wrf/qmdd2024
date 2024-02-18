<?php

class MallSalesOrderData extends BaseModel {
	public $pay_supplier_type_name='';
	public $club_name='';
	public $order_gfaccount='';
    
    
	
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{mall_sales_order_data}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		//'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'product_id'),
		'purpose_B' => array(self::BELONGS_TO, 'BaseCode', 'purpose'),
		'store_check' => array(self::BELONGS_TO, 'BaseCode', 'storecheck'),
		'order_info' => array(self::BELONGS_TO, 'MallSalesOrderInfo', 'info_id'),
		'detail' => array(self::BELONGS_TO, 'MallPriceSetDetails', 'set_detail_id'),
		'logistics' => array(self::BELONGS_TO, 'OrderInfoLogistics', 'logistics_id'),
        'lowerset' => array(self::BELONGS_TO, 'MallPriceSet', 'down_set_id'),
        'type' => array(self::BELONGS_TO, 'BaseCode', 'change_type'),
        'gfService' => array(self::BELONGS_TO, 'GfServiceData', 'gf_service_id'),


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
        'change_type' =>'明细内容',
        'order_num' => '订单号/售后单号',
        'order_type' => '订单类型',
		'order_type_name' => '订单类型',
		'orter_item' => '订单项目',
        'product_id' => '具体商品/服务ID',
        'product_ico' => '商品图片',
		'product_title' => '商品名称',
        'json_attr' => '型号/规格',
        'product_code' => '商品编号',
        'supplier_code' => '商品货号',
        'supplier_id' => '供应商ID',//供应商
		'supplier_name' => '供应商名称',//供应商
		'project_id' => '项目',
		'project_name' => '项目',
		'buy_level' => '龙虎等级',
		'buy_level_name' => '龙虎等级',
        'set_id' =>'定价方案',
		'set_name' =>'定价方案标题',
        'buy_count' => '销售数量',
		'buy_price' => '单价(元)',
        'buy_beans' => '使用体育豆',
        'beans' => '订单总花体育豆数量',
		'beans_discount' => '体育豆抵扣',
		'coupon_discount' =>'优惠券抵扣',
        'post' => '运费(元/件)',
        'buy_amount' => '实付金额',//(含运费，元)
		'purpose' => '购买方式',
		'gf_name' => '购买人',
		'storecheck' => '状态',
		'ret_count' => '退换数量',
		'ret_amount' => '退货金额',

        );
    }

    public function labelsOfList() {
        return array(
        'id','order_num','product_code','product_title','json_attr',
        'buy_price','buy_count','buy_amount','ret_count','ret_amount',
        'supplier_name','order_Date','pay_gfcode',
        );
    }

    public  function saveOrderdata($order_num){
        $tmp = new MallSalesOrderData();
        $car=Cardata::model()->findAll('order_num="'.$order_num.'"');
        foreach($car as $c) {
            $tmp->attributes=$c->attributes;
            $tmp->isNewRecord = true;
            unset($tmp->id);
            //$orderdata->orter_item = 757;
            $tmp->save();         
            //$orderdata->member_gfid = $c->buy_count;
            //$orderdata->storecheck = $c->service_code;
        }
    }
}
