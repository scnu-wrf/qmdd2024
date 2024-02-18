<?php

class Cardata extends BaseModel {

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{shopping_car_data}}';
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array('mall_products' => array(self::BELONGS_TO, 'MallProducts', 'product_id'),);
    }

     /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    //关联数据自动处理
    public function getrelations() {
      $s1='club_list,club_id:id,club_name';     
     // $s1.='goodsreport,f_rid:id,f_timeid:timeid&f_timetype:timetype';
      return $s1;
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
        'order_no' => '序号',
        'order_type' => '商品类型',
		'order_type_name' => '商品类型',
		'orter_item' => '订单项目',
        'product_id' => '商品ID',
        'product_code' => '产品编码',
        'product_ico' => '商品图片',
		'product_title' => '商品名称',
		'product_data_id' =>'属性ID',
        'json_attr' => '规格属性',
        'json_attr_explain' => '属性说明',  // 使用在赛事、培训等，,
        'product_ico' => '商品图片',
        'supplier_id' => '供应商id',
		'supplier_name' => '供应商',
		'project_id' => '项目',
		'project_name' => '项目',
		'buy_level_name' => '龙虎等级',
        'set_name' =>'定价方案标题',
        'buy_count' => '数量',
		'buy_price' => '商品单价',
        'buy_beans' => '使用体育豆',
        'beans' => '豆数量',
		'bean_discount' => '豆抵扣',
		'coupon_discount' =>'优惠券抵扣',
        'post' => '邮费',
        'buy_amount' => '实付金额',
		'purpose' => '购买方式',
		'leaving_a_message' => '留言备注',
        'gfid' => '单位id',  // purpose=7 
        'gf_name' => '购买人',
        'uDate'=>'购物车时间',
        'binding_no'=>'捆绑源id',  // data_id,关本表ID',
        'order_source'=>'销售归属',  // -1 gf_商城，-2二次上架，）',
        'set_id' => '定价方案',
        'set_name' => '定价方案名称',  // 关联mall_price_set表event_title',
        'details_id' => '定价表ID', // 关联mall_pricing_details表ID'
        'set_detail_id' => '数量明细',  // mall_price_set_detailsID'
        'set_post_id' => '运费ID',  // 关联mall_products_price_post表ID',
        'set_post_content' => '运费方案',
        'service_id' => '服务产品id',  // 根据mall_price_set表pricing_type类型取表ID'',',
        'service_code' => '服务产品编码',
        'service_ico' => '服务产品图标',
        'service_name' => '服务产品标题',
        'service_data_id' => '服务产品属性ID',
        'service_data_name' => '服务产品属性名',
        'gf_service_id' => '服务表来ID',  // 关联gf_service_data表id，多个服务单用,隔开',
        'uDate' => '加入车时间',
        'effective_time' => '有效时间',
        'gf_join_id' => '入驻关联表ID',  // ',
        'sale_show_id' => 'sale_show_id',
        'gf_club_id' => '所属单位id',  // 非会员gf_club_id=0',
        );
    }
    public function beforSave() {
        parent::beforSave();
        return true;
    }

    public function addOrderData($param){
    	$settlement = new CardataCopy();
        $sv=$settlement->insert($param);
        return $sv;
    }
}
