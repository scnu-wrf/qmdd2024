<?php

class MallPricingDetails extends BaseModel {

    public function tableName() {
        return '{{mall_pricing_details}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('set_details_id,customer_type,gf_salesperson_paytype,customer_level_id,shopping_beans,shopping_price,add_adminid,uDate,no,set_id,level_code,flash_sale,supplier_id,supplier_name,pricing_type,count,inventory_quantity,start_sale_time,sale_price', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_price_set' => array(self::BELONGS_TO, 'MallPriceSet', 'set_id'),
			'mall_price_set_details' => array(self::BELONGS_TO, 'MallPriceSetDetails', 'set_details_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
	
            'id' => '自增ID',
            'set_id' => '策略表ID',  //关联mall_price_set表id',
            'flash_sale' => '是否限时抢购',  //0普通销售，1限时抢购flash_sale',
            'no' => '商品上架序号',
            'code' => '活动方案编号',  //关联mall_price_set表event_code',
            'title' => '活动方案名称',
            'star_time' => '上线时间',
            'end_time' => '下线时间',
            'down_time' => '下架时间',
            'set_details_id' => '上架数量',  //mall_price_set_details 的ID',
            'product_id' => '商品表id',  //关联mall_products表ID值',
            'product_name' => '商品名称',
            'product_data_code' => '商品属性货号',
            'product_data_id' => '商品属性表ID',  //关联mall_products_data表ID值',
            'json_attr' => '商品属性名称',
            'purpose' => '上架类型来源',  //关联base_code表W类型id: 94、普通销售，95、限时抢购，716、会员促销（购买自用），717、代销下单（二次上架），718单位导购 ，719退货/下架',
            'purpose_name' => '上架类型来源名称',
            'shop_purpose' => '销售方式（购买方式）id',  //关联base_code表W类型id: 94、普通销售，95、限时抢购，716、会员促销（购买自用），717、代销下单（二次上架），718单位导购 ，719退货/下架',
            'shop_name' => '销售方式名称',
            'customer_type' => '客户类型',  //关联base_code表MEMBERTYPE类型id:502-服务机构210-GF会员',
            'customer_name' => '购买客服类别名称',
            'gf_salesperson_paytype' => 'GF销售单位支付类型',  //关联base_code表 453免费认证 454 轻松支付',
            'paytype' => 'GF销售单位支付类型说明',
            'customer_level_id' => '客户等级id,',  //关联member_card表',
            'level_code' => '会员编码',
            'level_name' => '客户等级名称',
            'shopping_beans' => '销售体育豆',
            'shopping_price' => '销售价格',
            'discount_price' => '会员价格折扣率',
            'discount_beans' => '体育折扣率',
            'count' => '上架数量',
            'sale_max' => '最大购买数',
            'gf_salesperson_float' => '售出毛利额',
            'add_adminid' => '添加操作管理员id',  //关联qmdd_administrators表ID',
            'add_date' => '添加时间',
            'datails_id' => '保险使用定价格的ID',  //关联mall_pricing_details表ID',
            'service_id' => '服务产品id',  //根据mall_price_set表pricing_type类型取表ID,详细数据可查看base_code表',
            'service_code' => '服务产品code',
            'service_name' => '服务产品标题',
            'service_data_id' => '服务产品属性ID',
            'service_data_name' => '服务产品属性名',
            'inventory_quantity' => '上架数量',
            'secondary_quantity' => '二次上架数量',  //触发器从mall_sales_order_data表销售时间在本方案的时间的上架商品数量合计数',
            'available_quantity' => '销售数量',  //触发器从mall_sales_order_data表销售时间在本方案上架商品数量合计数',
            'return_quantity' => '退货数量',  //触发器从mall_sales_order_data表销售时间在本方案的时间内产生的换货商品数量合计数',
            'change_quantity' => '换货数量',  //触发器从mall_sales_order_data表销售时间在本方案的时间内产生的换货商品数量合计数',
            'if_user' => '是否使用',  //关联base_code表yes_no类型id 648=否，649是',
            'procduct_memo' => '备注说明',
            'uDate' => '记录修改',
            'pricing_type' => '订单类型',  //关联表base_code表order类型ID为351-369明星空间,385、503'',',
            'supplier_id' => '供应商id', //关联club_list表id',
            'supplier_name' => '供应商名称',
         
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
			$this->uDate = date('Y-m-d h:i:s');
        }
        return true;
    }
    
    
	/**
	 * 1、普通销售，3、限时抢购，4、会员促销（购买自用），5、代销下单（二次上架），7单位导购 ，8退货/下架 9上架
	 */
	function purposeSet($stable="mall_pricing_details",$purpose_set){
		$purpose_set=empty($purpose_set)?"":$purpose_set;
		$fs= explode(',',$purpose_set);
		$p_param=$stable.".purpose";
		$sp_param=$stable.".shop_purpose";
		$ssp_param=$stable.".sale_show_id";
		$where="";
		$spe="";
		foreach($fs as $k=>$v){
			if($v==""){
				continue;
			}
			switch($v){
				case 1:
				case 94:
//				$where.=$spe." (".$p_param."=94 and ".$sp_param."=94) ";
				$where.=$spe." ".$ssp_param."=1129 ";
				$spe=" or ";
				break;
				case 3:
				case 95:
//				$where.=$spe." (".$sp_param."=95) ";
				$where.=$spe." (".$ssp_param."=1134 or ".$ssp_param."=1135) ";
				$spe=" or ";
				break;
				case 4:
				case 716:
//				$where.=$spe." (".$p_param."=94 and ".$sp_param."=716) ";
				$where.=$spe." ".$ssp_param."=1133 ";
				$spe=" or ";
				break;
				case 5:
				case 717:
//				$where.=$spe." (".$p_param."=94 and ".$sp_param."=717) ";
				$where.=$spe." ".$ssp_param."=1131 ";
				$spe=" or ";
				break;
				case 7:
				case 718:
//				$where.=$spe." (".$p_param."=718 and ".$sp_param."=94) ";
				$where.=$spe." ".$ssp_param."=1130 ";
				$spe=" or ";
				break;
				case 1129:
				case 1130:
				case 1131:
				case 1132:
				case 1133:
				case 1134:
				case 1135:
				$where.=$spe." ".$ssp_param."=".$v." ";
				$spe=" or ";
				break;
			}
		}
		//仅商城使用sale_show_id 字段
		return empty($where)?"":" and (".$where.")";
	}
    
	/**
	 * @param $level_no 多个使用,隔开
	 * @param $purpose、$shop_purpose 多个使用,隔开 
	 * 销售方式／购买方式  94、普通销售，95、限时抢购，716、会员促销（购买自用），717、代销下单（二次上架），718单位导购 ，719退货/下架 
	 * 1、普通销售，3、限时抢购，4、会员促销（购买自用），5、代销下单（二次上架），7单位导购 ，8退货/下架 9上架
	 * @return array('where'=>$where,'table'=>"mall_pricing_details d,mall_price_set s,mall_price_set_details set_dt")
	 */
	function priceShowSQL($param){
		$supplier_id=empty($param['supplier_id'])?null:$param['supplier_id'];
		$product_id=empty($param['product_id'])?null:$param['product_id'];
		$product_data_id=empty($param['product_data_id'])?null:$param['product_data_id'];
		$purpose_set=empty($param['purpose_set'])?null:$param['purpose_set'];
		$level_no=empty($param['level_no'])?null:$param['level_no'];
		$pricing_type=empty($param['pricing_type'])?361:$param['pricing_type'];
		$customer_type=empty($param['customer_type'])?210:$param['customer_type'];
		$datetime=empty($param['datetime'])?null:$param['datetime'];
		$onsale=empty($param['onsale'])?1:$param['onsale'];
		$buy=empty($param['buy'])?0:$param['buy'];
		
		$customer_type=$customer_type==2?210:$customer_type;
		$customer_type=$customer_type==210?"210,1472":$customer_type;
		$level_no=$level_no==24?0:$level_no;
		
		$set_data=array();
	 	if($pricing_type==363||$pricing_type==361||$pricing_type==2){
	 		$set_data['product_id']=$product_id;
	 	}else{
	 		$set_data['service_id']=$product_id;
	 		$set_data['service_data_id']=$product_data_id;
	 	}
		$cr = new CDbCriteria;
        $cr->join = "JOIN mall_price_set on mall_price_set.id=t.set_id";
		$cr->condition=" t.pricing_type={$pricing_type}";
		$cr->condition=get_where_in($cr->condition,$customer_type,'t.customer_type',$customer_type);
		if($buy==1){
			$cr->condition.=" and (case when mall_price_set.end_time>=now() and (now() between t.star_time and t.end_time) and (IFNULL(t.down_time,'')='' or now() < t.down_time) and (case when t.pricing_type=364  then 1 else IFNULL(t.inventory_quantity,0)-IFNULL(t.available_quantity,0) end)>0 and t.f_check=2 and mall_price_set.if_user_state=649 and mall_price_set.f_check=2  then 1 else 0 end)=1";
		}
		
		$cr->condition=get_where($cr->condition,$set_data['service_id'],"t.service_id",$set_data['service_id']);
		$cr->condition=get_where($cr->condition,$set_data['service_data_id'],"t.service_data_id",$set_data['service_data_id']);
		$cr->condition=get_where($cr->condition,$set_data['product_id'],"t.product_id",$set_data['product_id']);
		$cr->condition.=$this->purposeSet("t",$purpose_set);
		if(isset($level_no)&&$level_no!=-1){
			$cr->condition.=" and (t.level_no in(".$level_no.") or (t.level_no=0 and t.sale_show_id in(1129,1134,1135)))";
		}
		return $cr;
	}
	
	/**
	 * 获取普通定价
	 * @return details_id,set_details_id,set_code,set_id,set_name,shopping_price,shopping_beans,buy_level,buy_level_no,buy_level_name
	 */
	public function getNormalPrice($param){
		$param['purpose_set']=94;
		$param['level_no']=0;
		$cr=$price_show_sql_data=$this->priceShowSQL($param);
		$cr->order='t.id desc';
		$cr->select=isset($param['select'])?$param['select']:"t.id as details_id,t.set_details_id,t.sale_show_id,t.code as set_code,t.set_id,t.title as set_name,IFNULL(t.shopping_price,'0.00') as shopping_price,IFNULL(t.shopping_beans,'0') as shopping_beans,t.customer_level_id as buy_level,t.level_no as buy_level_no,t.level_name as buy_level_name ";
		return $this->find($cr,array(),false);
	}


   /*
   sid,$did,$parray()=array(array($tmp,field)...)
    */
  public function savePriceDetails($sid,$did,$parray=array()){
        $w1='set_id='.$sid.' and service_data_id='.$did;
        $tmp0 = MallPriceSetDetails::model()->find($w1);
        $w1.=' and set_details_id='.$tmp0->id;
        $tmp = MallPricingDetails::model()->find($w1);
        if(empty($tmp)){
            $tmp = new MallPricingDetails;
            $tmp->isNewRecord = true;
            unset($tmp->id);
            $tmp->set_details_id = $tmp0->id;
            $tmp->set_id = $sid;
            $tmp->service_data_id = $did;
        }
        foreach ($parray as  $v ){
          $tmp->setFromArray($v[0],$v[1]);//把($v[0] 按$v[1] 说明赋值到$tmp
        }
        $tmp->save();
    }

}
