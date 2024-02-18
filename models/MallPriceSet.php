<?php

class MallPriceSet extends BaseModel {
	public $product = '';
	public $pricing = '';
	public $post_list = '';
	public $flash_s = '';

    public function tableName() {
        return '{{mall_price_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('event_title', 'required', 'message' => '{attribute} 不能为空'),
            array('start_sale_time', 'required', 'message' => '{attribute} 不能为空'),
            array('supplier_id', 'required', 'message' => '{attribute} 不能为空'),
            //array('mall_member_price_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('salesperson_profit_id', 'required', 'message' => '{attribute} 不能为空'),
            array('star_time', 'required', 'message' => '{attribute} 不能为空'),
            array('end_time', 'required', 'message' => '{attribute} 不能为空'),
            array('down_time', 'required', 'message' => '{attribute} 不能为空'),
            array('event_title,pricing_type,if_user_state,star_time,end_time,supplier_id,add_adminid,update_date,
                    f_check,reasons_adminID,reasons_for_failure,reasons_time,product,pricing,post_list,mall_member_price_id,
                    salesperson_profit_id,flash_sale,down_time,frozen_id,frozen_time,apply_time', 'safe'),
        
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
            'admin_frozen_id' => array(self::BELONGS_TO, 'QmddAdministrators','frozen_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'event_code' =>'方案编号',
            'event_title' => '方案标题',
			'supplier_id' =>'销售商家',
			'supplier_name' =>'供应商名称',
			'mall_member_price_id' => '定价方案',
			'mall_member_price_name' => '定价方案',  // 销售成员价格方案名称，来源mall_member_price_info 名称
			'salesperson_profit_id' => '毛利分配方案',
			'salesperson_profit_name' => '毛利分配方案',  // 商品毛利分配方案名称,对应gf_salesperson_info NAME
			'if_user_state' => '上下线设置',
            'user_state_name' => '上下线状态',
            'pricing_type' => '订单类型',
			'pricing_type_name' => '订单类型',
			'flash_sale' => '是否显示限时抢购设置',
            'star_time' => '上线时间',
            'start_sale_time' => '销售时间',
			'end_time' => '下线时间',
            'down_time' => '下架时间',
            'add_adminid' => '添加管理员',
            'update_date' => '操作时间',
            'f_check' => '审核状态',
            'f_check_name' => '审核状态名称',
			'reasons_adminID' => '操作员',
			'reasons_admin_nick' => '操作员名称',
			'reasons_for_failure' => '操作备注',
			'reasons_time' => '审核时间',
			'data_sourcer_table' => '上架关联数据表',
			'data_sourcer_id' => '数据来源表ID',  // ID=0 表示全部',
			'data_sourcer_name' => '数据来源名称',  // 例如比赛名称等',
			'data_sourcer_bz' => '备注说明',
			'if_del' => '是否逻辑删除',
            'down_up' => '上下架类型',  // 1上架，-1下架，在BASECODE ID=21，22的BASECODE',
            'service_id' => '服务产品id',  // 根据pricing_type类型取表ID,详细数据可查看base_code表'
            'frozen_id' => '冻结人',
            'frozen_time' => '冻结时间',
            'apply_time' => '申请时间',

            'star_time1' => '开始使用时间',
            'end_time1' => '结束使用时间',
            'supplier_name1' => '使用方案单位',
            'product_name' => '绑定商品名称',
            'product_code' => '绑定商品编号',
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
            //$this->update_date = date('Y-m-d H:i:s');
            $this->add_adminid = Yii::app()->session['admin_id'];
        }
        //$this->reasons_adminID = Yii::app()->session['admin_id'];
        //$this->reasons_admin_nick = Yii::app()->session['gfnick'];
        //$this->reasons_time = date('Y-m-d H:i:s');
        return true;
    }
     /*检查类型为351赛事服务的是否存在该竟赛赛事
     $datastr=  $s1='service_id:id,event_title:game_title,supplier_id:game_club_id,';
        $s1.='supplier_name:game_club_name,star_time:Signup_date,';
        $s1.='end_time:Signup_date_end,down_time:Signup_date_end,';
        $s1.='start_sale_time:Signup_date,if_user_state=1,f_check=2,';
        $s1.='pricing_type=1,pricing_type_name=赛事活动,f_check_name=审核通过'
     */
    function updatePriceSet($tmp0,$id,$typeid,$datastr){
        //*定价方案开始*/
        $w1='service_id='.$id.' and pricing_type='.$typeid;
        $tmp= MallPriceSet::model()->find($w1);
        if(empty($tmp)){
           $tmp = new MallPriceSet;
           $tmp->isNewRecord = true;
            unset($tmp->id);
        }
        $tmp->setFromArray($tm0,$datastr);
        $tmp->save();
    }

}
