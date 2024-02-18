<?php

class ActivityList extends BaseModel {

	public $explain_temp = '';
    public $activity_apply_way_referee = '';
	public $remove_data_ids = '';
    public $show=0;
	public $video_id='';
	public $video_title='';
    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    public function tableName() {
        return '{{activity_list}}';
    }

    public function check_save($show) {
        $this->show=$show;
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'online' => array(self::BELONGS_TO, 'BaseCode', 'activity_online'),
			'admin' => array(self::BELONGS_TO, 'QmddAdministrators', 'change_adminid'),
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
        'id' => '自增id',
        'activity_code' => '活动编号',
        'activity_title' => '活动标题',
        'activity_small_pic' => '缩略图',
        'activity_big_pic' => '滚动图',
        'activity_club_id' => '发布单位',// ，关联club_list表id
        'activity_club_code' => '单位账号',//，关联club_list表club_code
        'activity_club_name' => '发布单位',
        'activity_online' => '显示前端',
        'activity_address' => '活动地点',
        'navigatio_address' => '导航地点',
        'dispay_star_time' => '显示时间',
        'dispay_end_time' => '显示时间',
        'sign_up_date' => '报名时间',
        'sign_up_date_end' => '截止时间',
        'activity_apply_way_referee' => '是否开通报名',
        'effective_time' => '缴费截止',
        'activity_time' => '活动时间',
        'activity_time_end' => '活动截止',
        'local_men' => '联系人',
        'local_and_phone' => '联系电话',
        'organizational' => '组织单位',
        'state' => '状态',
        'state_name' => '状态',
        'reasons_for_failure' => '操作备注',
        'explain' => '活动介绍',
        'audit_time' => '审核日期',
        'adminid' => '审核员',
        'adminname' => '审核员',
        'change_time' => '更改时间',
        'change_adminid' => '操作人员',
        'change_adminname' => '操作人员',
        'gf_gross' => '平台毛利（%）',
        'club_gross' => '单位毛利率（%）',
        'way_referee' => '是否开通报名',
        );
    }

    public function picLabels() {
        return 'activity_small_pic,activity_big_pic';//,site_description_tem
    }
    public function pathLabels(){ return '';}
    protected function beforeSave() {
        $table='ActivityList';
        parent::beforeSave();
        $this->explain=getHtmlFile($this,'explain');
        if(empty($this->activity_code)){
           $this->activity_code=getAutoNo($table,'','');
        }
        return true;
    }

    public function save_set($model){
        if($this->state==2){
            $this->update_MallPriceSet($this); //*定价方案开始*/
            $this->update_MallPriceSetDetails($this);
        }
    }

    function update_MallPriceSet($thism){
        //*定价方案开始*/
        $mall_price_set= MallPriceSet::model()->find('service_id='.$thism->id.' and pricing_type=354');
        /*检查类型为354活动报名的是否存在该活动*/
        if(empty($mall_price_set)){
            $mall_price_set = new MallPriceSet;
            $mall_price_set->isNewRecord = true;
            unset($mall_price_set->id);
            $mall_price_set->service_id = $thism->id;
        }
        $mall_price_set->event_title = $thism->activity_title;
        $mall_price_set->supplier_id = $thism->activity_club_id;
        $mall_price_set->supplier_name = $thism->activity_club_name;
        $mall_price_set->pricing_type = 354;
        $mall_price_set->pricing_type_name = '活动报名';
        $mall_price_set->star_time = $thism->sign_up_date;
        $mall_price_set->start_sale_time = $thism->sign_up_date;
        $mall_price_set->end_time = $thism->sign_up_date_end;
        $mall_price_set->down_time = $thism->sign_up_date_end;
        $mall_price_set->add_adminid = get_session('admin_id');
        $mall_price_set->f_check = 2;
        $mall_price_set->f_check_name = '审核通过';
        $mall_price_set->reasons_adminID = get_session('admin_id');
        $mall_price_set->reasons_admin_nick = get_session('admin_name');
        $mall_price_set->reasons_time = date('Y-m-d H:i:s');
        $mall_price_set->update_date = date('Y-m-d H:i:s');
        $mall_price_set->apply_time = date('Y-m-d H:i:s');
        $mall_price_set->save();
    }

    function update_MallPriceSetDetails($thism){
        $club_membership_fee = ClubMembershipFee::model()->find('code="TS53"');
        $price = MallPriceSet::model()->find('service_id='.$thism->id.' and pricing_type=354');
        $mset_id = $price->id;
        $adata=ActivityListData::model()->findAll('activity_id='.$thism->id);
        foreach ($adata as $v) { //生成销售价格方案
            $this->save_MallPriceSetDetails($thism,$v,$mset_id, $club_membership_fee);
            $this->save_MallPricingDetails($thism,$v,$mset_id, $club_membership_fee);
        }
    }

    function save_MallPriceSetDetails($thism,$v,$mset_id,$p){
        $w1='set_id='.$mset_id.' and pricing_type=354 and service_data_id='.$v->id;
        $MallPriceSetDetails = MallPriceSetDetails::model()->find($w1);
        if(empty($MallPriceSetDetails)){
            $MallPriceSetDetails = new MallPriceSetDetails;
            $MallPriceSetDetails->isNewRecord = true;
            unset($MallPriceSetDetails->id);
            $MallPriceSetDetails->set_id = $mset_id;
        }
        $MallPriceSetDetails->pricing_type = 354;
        if(!empty($p)){
            $MallPriceSetDetails->product_id =$p->product_id;
            $MallPriceSetDetails->product_code =$p->product_code;
            $MallPriceSetDetails->product_name =$p->product_name;
            $MallPriceSetDetails->json_attr =$p->json_attr;
        }
        $MallPriceSetDetails->purpose = 94;
        $MallPriceSetDetails->shop_purpose = 94;
        $MallPriceSetDetails->sale_price = $v->activity_money;
        $MallPriceSetDetails->Inventory_quantity = $v->apply_number;
        $MallPriceSetDetails->up_quantity = $v->apply_number;
        $MallPriceSetDetails->service_id = $thism->id;
        $MallPriceSetDetails->service_code =$thism->activity_code;
        $MallPriceSetDetails->service_name =$thism->activity_title;
        $MallPriceSetDetails->service_data_id = $v->id;
        $MallPriceSetDetails->service_data_name = $v->activity_content;
        $MallPriceSetDetails->u_date = date('Y-m-d H:i:s');
        $MallPriceSetDetails->star_time = $thism->sign_up_date;
        $MallPriceSetDetails->start_sale_time = $thism->sign_up_date;
        $MallPriceSetDetails->end_time = $thism->sign_up_date_end;
        $MallPriceSetDetails->down_time = $thism->sign_up_date_end;
        $MallPriceSetDetails->supplier_id = $thism->activity_club_id;
        $MallPriceSetDetails->supplier_name = $thism->activity_club_name;
        $MallPriceSetDetails->f_check = 2;
        $MallPriceSetDetails->save();
    }

    function save_MallPricingDetails($thism,$v,$mset_id,$p){
        $w1='set_id='.$mset_id.' and pricing_type=354 and service_data_id='.$v->id;
        $SetDs = MallPriceSetDetails::model()->find($w1);
        $w1='pricing_type=354 and set_id='.$mset_id.' and service_data_id='.$v->id.' and set_details_id='.$SetDs->id;
        $MallPricingDetails = MallPricingDetails::model()->find($w1);
        if(empty($MallPricingDetails)){
            $MallPricingDetails = new MallPricingDetails;
            $MallPricingDetails->isNewRecord = true;
            unset($MallPricingDetails->id);
        }
        $MallPricingDetails->set_id = $mset_id;
        $MallPricingDetails->star_time = $thism->sign_up_date;
        $MallPricingDetails->start_sale_time = $thism->sign_up_date;
        $MallPricingDetails->end_time = $thism->sign_up_date_end;
        $MallPricingDetails->down_time = $thism->sign_up_date_end;
        $MallPricingDetails->set_details_id = $SetDs->id;
        if(!empty($p)){
            $MallPricingDetails->product_id =$p->product_id;
            $MallPricingDetails->product_data_code =$p->product_code;
            $MallPricingDetails->product_name =$p->product_name;
            $MallPricingDetails->json_attr =$p->json_attr;
        }
        $MallPricingDetails->customer_type = 210;
        $MallPricingDetails->sale_show_id = 1129;
        $MallPricingDetails->sale_show_name = '普通销售';
        $MallPricingDetails->sale_price = $v->activity_money;
        $MallPricingDetails->shopping_price = $v->activity_money;
        $MallPricingDetails->add_adminid = get_session('admin_id');
        $MallPricingDetails->service_id = $thism->id;
        $MallPricingDetails->service_code = $thism->activity_code;
        $MallPricingDetails->service_name = $thism->activity_title;
        $MallPricingDetails->service_data_id = $v->id;
        $MallPricingDetails->service_data_name = $v->activity_content;
        $MallPricingDetails->inventory_quantity = $v->apply_number;
        $MallPricingDetails->if_user = 649;
        $MallPricingDetails->pricing_type = 354;
        $MallPricingDetails->supplier_id = $thism->activity_club_id;
        $MallPricingDetails->f_check = 2;
        $MallPricingDetails->save();
    }


    
	public function getAge($birthday) {
        //格式化出生时间年月日
        $byear=date('Y',$birthday);
        $bmonth=date('m',$birthday);
        $bday=date('d',$birthday);

        //格式化当前时间年月日
        $tyear=date('Y');
        $tmonth=date('m');
        $tday=date('d');

        //开始计算年龄
        $age=$tyear-$byear;
        if($bmonth>$tmonth || $bmonth==$tmonth && $bday>$tday){
            $age--;
        }
        return $age;
    }
    function getStateName() {
        $s1= '';
        $d1=$this->sign_up_date;
        $d2=$this->sign_up_date_end;
        $d3=date('Y-m-d H:i:s');
        $d4=date('Y-m-d');
        
       if($d1>$d3){
            $s1= '报名未开始'; 
        }elseif($d1<=$d3&&$d3<$d2){
            $s1= '报名中'; 
        }elseif($d3>$d2&&$this->activity_time>$d4){
            $s1= '报名截止'; 
        }elseif($this->activity_time<=$d4&&$this->activity_time_end>=$d4){
            $s1= '活动中'; 
        }elseif($this->activity_time_end<$d4){
            $s1= '活动结束'; 
        }
       return $s1;
   }

}
