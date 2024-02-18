<?php

class OrderRecord extends BaseModel {
	 /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return '{{order_record}}';//订单操作记录表（每次订单修改、审核状态变更都要记录
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'ispay' => array(self::BELONGS_TO, 'BaseCode', 'is_pay'),
			'base_logistics_state' => array(self::BELONGS_TO, 'BaseCode', 'logistics_state'),
        );
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
        'order_id' => '订单ID',//关联mall_sales_order_info表',
        'order_num' => '单号',//，关联mall_sales_order_info表
        'sign_state' =>'客服操作',// 关联base_code表ID为371-374类型
        'is_pay' => '支付状态',// 0未付款   1已付款
        'is_pay_name' => '支付状态说明',
        'order_state' => '订单状态',//465确认,466退款，467分单,468关闭,469完成,,470待审核
        'order_state_name' => '订单状态',//说明内容
        'order_state_des_content' =>'操作备注',
        'order_state_des_time' =>'操作时间',
        'user_member'=> '操作会员',//， 关联base_code表MEMBERTYPE类型id:502-服务机构210-GF会员
        'operator_gfid' => '操作人GFID',//,关联userlist表， 502关联qmdd_administrators表
        'operator_gfname' => '操作人姓名',
        'logistics_xh' => '发货单序号',//，关联order_info_logistics表，默认值为00总订单
        'logistics_id' => '物流单号',//，表order_info_logistics的id
        'logistics_state' =>'物流状态',// 472-未发货 473-已发货 474-已签收 475-已评价 476-已发货
        // 'logistics_state_name' var=> '物流状态',
        'logistics_state_name' => '物流状态',  // 因var报错，因此将var删去
        'if_del' => '是否删除',//0 否 1 是
        'change_type' =>'退换货标识',//change_typeBASECOED1137退货，1138换货，0普通销售
        );
    }

	protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
			$this->operator_gfid = get_session('admin_id');
            $this->operator_gfname = get_session('admin_name');
            $this->order_state_des_time = date('Y-m-d H:i:s');
        }
        return true;
    }

    //从购物车生产销售单
    public  function saveOrderRec($data){
        $this->attributes=$data->attributes;
        $this->isNewRecord = true;
        unset($this->id);
        //$this->order_num = $data->order_num;
        $this->is_pay = 464;
        $this->order_state = 470;
        $this->order_state_des_content =$data->content;
        $this->user_member = 502;
        $this->logistics_state = 472;
   return $this->save();
    }
}
