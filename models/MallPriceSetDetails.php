<?php

class MallPriceSetDetails extends BaseModel {

    public function tableName() {
        return '{{mall_price_set_details}}';
    }

    /**
     * 模型验证规则,
     */
    public function rules() {
        return array(
            array(
                'set_id,pricing_type,no,product_id,product_code,product_name,product_data_id,json_attr,purpose_name,up_quantity,purchase_price,oem_price,sale_price,
                sale_bean,sale_price2,sale_bean2,post_price,purpose,shop_purpose,shop_name,Inventory_quantity,secondary_quantity,available_quantity,service_id,service_code,service_name,
                service_data_id,service_data_name,return_quantity,change_quantity,if_dispay,u_date,up_price_id,up_gross_profit_id,flash_sale,star_time,end_time,down_time,supplier_id,supplier_name,start_sale_time,up_available_quantity,sale_id', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_price_set' => array(self::BELONGS_TO, 'MallPriceSet', 'set_id'),
			'product' => array(self::BELONGS_TO, 'MallProducts', 'product_id'),
			'price_id' => array(self::BELONGS_TO, 'MallMemberPriceInfo', 'down_pricing_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'set_id' => '策略表id', //,关联mall_price_set表ID',
            'set_code' =>'方案编号',
            'pricing_type' => '订单类型', // - 关联表base_code表order类型ID为351-369明星空间,385、503',
            'no' => '序号',
            'product_id' => '商品id', //关联mall_product表id',
            'product_code' => '商品编号',
            'product_name' => '商品名称',
            'down_pricing_id' => '销售类型',  //关联mall_product_data表ID',
            'json_attr' => '型号/规格',
            'purpose' => '上架类型来源',  //关联base_code表W类型id: 94、普通销售，95、限时抢购，716、会员促销（购买自用），717、代销下单（二次上架），718单位导购 ，719退货/下架',
            'purpose_name' => '上架来源名称',
            'shop_purpose' => '销售方式',  //关联base_code表W类型id: 94、普通销售，95、限时抢购，716、会员促销（购买自用），717、代销下单（二次上架），718单位导购 ，719退货/下架',
            'shop_name' => '购买目的名称',
            'up_quantity' => '上架商品数量（最大可售数量）',
            'purchase_price' => '采购价',
            'oem_price' => '贴牌价',
            'sale_price' => '商品单价(元)',
            'sale_bean' => '销售豆',
            'sale_price2' => '二次销售价',
            'sale_bean2' => '二次销售豆',
            'post_price' => '运费(元/件)',
            'Inventory_quantity' => '上架数量',
            'secondary_quantity' => ' 二次上架/导购',  //触发器从mall_sales_order_data表销售时间在本方案的时间的上架商品数量合计数',
            'available_quantity' => '已售数量',  //触发器从mall_sales_order_data表销售时间在本方案上架商品数量合计数',
            'return_quantity' => '退货数量',  //触发器从mall_sales_order_data表销售时间在本方案的时间内产生的换货商品数量合计数',
            'change_quantity' => '换货数量',  //触发器从mall_sales_order_data表销售时间在本方案的时间内产生的换货商品数量合计数',
            'if_dispay' => '是否下架',  //关联base_code表yes_no类型id 648=否，649是',
            'service_id' => '服务产品id',  //根据pricing_type类型取表ID,详细数据可查看base_code表',
            'service_code' => '服务产品',  //code',
            'service_name' => '服务产品标题',
            'service_data_id' => '服务产品属性ID',
            'service_data_name' => '服务产品属性名',
            'u_date' => '添加时间',
            'up_price_id' => '上架价格折扣方案',  // 关联mall_member_price_info的ID',
            'up_gross_profit_id' => '毛利方案',  //关联mall_gross_profit_id',
            'flash_sale' => '自动上下架表示',  //0普通销售，1是限时抢购',
            'star_time' => '上线时间',
            'end_time' => '下线时间',
            'start_sale_time' => '销售时间',
            'down_time' => '下架时间',
            'supplier_id' => '商家名称',  // 关联club_list表id
            'supplier_name' => '供应商名称',  // 关联club_list表id
            'sale_id' => '销售方式',
            'up_available_quantity' => '已售数量',
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
        if($this->isNewRecord){
            $this->u_date = get_date();
        }
        return true;
    }
   /*
   sid,$did,$parray()=array(array($tmp,field)...)
    */
  public function savePriceDetails($sid,$did,$parray=array()){
        $w1='set_id='.$sid.' and service_data_id='.$did;
        $tmp = MallPriceSetDetails::model()->find($w1);
        if(empty($tmp)){
            $tmp = new MallPriceSetDetails;
            $tmp->isNewRecord = true;
            unset($tmp->id);
        }
        foreach ($parray as  $v ){
          $tmp->setFromArray($v[0],$v[1]);//把($v[0] 按$v[1] 说明赋值到$tmp
        }
        $tmp->save();
    }
}
