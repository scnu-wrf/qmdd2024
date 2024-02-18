<?php

class ClubStoreTrain extends BaseModel {
    
    public $train_description_temp="";
	public $remove_data_ids = '';
    public $show=0;
	public $video_id='';
	public $video_title='';
    public function tableName() {
        return '{{club_store_train}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='train_men,train_phone,train_area,train_address,train_title,train_logo,train_pic,train_description,train_type1_id,train_deal_ocunt,dispay_start_time,dispay_end_time,train_buy_start,train_buy_end,train_start,train_end,organizational,train_clubid,train_description_temp,if_train_live,train_state,reasons_for_failure,audit_time,train_state_adminid,train_state_adminname,train_club_code,train_id,train_gfname,change_time,gf_gross,club_gross,period,longitude,latitude,video_live_id';
        if($this->show==0){
            $a = array(
                array('train_title,if_train_live,apply_way,train_area,train_address,train_men,train_phone,train_logo,train_pic,dispay_start_time,dispay_end_time,train_buy_start,train_buy_end,train_start,train_end', 'required', 'message' => '{attribute} 不能为空'),
                array($s2,'safe'),
            );
        } else{
            $a = array(
                array($s2,'safe'),
            );
        }
        return $a;
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'train_project_id'),
			'online' => array(self::BELONGS_TO, 'BaseCode', 'if_train_live'),
			'admin' => array(self::BELONGS_TO, 'QmddAdministrators', 'train_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'train_code' => '培训编号',
            'train_title' => '培训标题',
            'train_logo' => '缩列图',
            'train_pic' => '滚动图',
            'train_description' => '培训描述',
            'train_info' => '套餐清单',
            'train_sign_declare' => '报名须知',
            'train_type1_id' => '类型',
            'train_type2_id' => '类别',
            'train_group_star' => '可报名出年日期开始',
            'train_group_end' => '可报名出年日期结束',
            'train_sale_count' => '销售数量',
            'train_deal_ocunt' => '最大可售量',
            'dispay_start_time' => '前端显示时间',
            'dispay_end_time' => '前端显示时间',
            'train_buy_start' => '报名时间',
            'train_buy_end' => '报名时间',
            'train_start' => '培训时间',
            'train_end' => '培训时间',
            'apply_way' => '是否开通报名',
            'train_statec' => '培训状态',
            'train_state' => '审核状态',
            'train_area' => '地点',
            'train_address' => '导航地点',
            'train_men' => '联系人',
            'train_phone' => '联系电话',
            'train_physical_examination' => '培训要求体检周期',
            'train_project_id' => '项目',
            'train_state_adminid' => '审核员',
            'audit_time' => '审核日期',
            'reasons_for_failure' => '操作备注',
            'train_id' => '操作人员',
            'train_club_code' => '培训发布的单位账号',
            'train_clubid' => '发布单位',
            'change_time' => '更改时间',
            'add_time' => '发布时间',
            'if_train_live'=>'显示前端',
            'organizational' => '组织单位',
            'gf_gross' => '平台毛利（%）',
            'club_gross' => '单位毛利率（%）',
            'period' => '培训周期'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    protected function afterFind() {
        parent::afterFind();
        return true;
    }
    
    protected function beforeSave() {
        parent::beforeSave();
        // 套餐清单
        $basepath = BasePath::model()->getPath(134);
        
        //介绍
        if ($this->train_description_temp != '') {

            if ($this->train_description != '') {
                set_html($this->train_description, $this->train_description_temp, $basepath);
            } else {
                $rs = set_html('', $this->train_description_temp, $basepath);
                //if ($rs['news_code'] == 0) {
                    $this->train_description = $rs['filename'];
                //}
            }
        } else {
            $this->train_description = '';
        }
        
        if($this->isNewRecord){
            if(empty($this->train_code)){
                $code=$_POST["ClubStoreTrain"]['train_club_code'];
                $num = date('md');
                $num1 = '00';  
                $code1 = $this->find("left(train_code,15)='P".$code.$num."' order by train_code DESC");
                if(!empty($code1)){
                    $num1 = $code1->train_code;
                }
                $this->train_code = 'P'.$code.$num.substr(''.(101+substr($num1, -2)),1,2);
            }
        }

        if($this->train_state==2){
            $fee = ClubMembershipFee::model()->find('code="TS55"');
            if(!empty($fee->product_id))$info = GfServiceInfo::model()->find('product_id='.$fee->product_id);
            if(empty($this->gf_gross)&&!empty($info)){
                $this->gf_gross = $info->gf_gross;
            }
            if(empty($this->club_gross)&&!empty($info)){
                $this->club_gross = $info->club_gross;
            }
        }
        return true;
    }

    
    public function save_set($model){
        if($this->train_state==2){
            $this->update_MallPriceSet($this); //*定价方案开始*/
            $this->update_MallPriceSetDetails($this);
        }
    }
    
    function update_MallPriceSet($thism){
        //*定价方案开始*/
        $mall_price_set= MallPriceSet::model()->find('service_id='.$thism->id.' and pricing_type=352');
        /*检查类型为352培训报名的是否存在该培训*/
        if(empty($mall_price_set)){
            $mall_price_set = new MallPriceSet;
            $mall_price_set->isNewRecord = true;
            unset($mall_price_set->id);
            $mall_price_set->service_id = $thism->id;
        }
        $mall_price_set->event_title = $thism->train_title;
        $mall_price_set->supplier_id = $thism->train_clubid;
        $mall_price_set->supplier_name = $thism->train_clubname;
        $mall_price_set->pricing_type = 352;
        $mall_price_set->pricing_type_name = '培训报名';
        $mall_price_set->star_time = $thism->train_buy_start;
        $mall_price_set->start_sale_time = $thism->train_buy_start;
        $mall_price_set->end_time = $thism->train_buy_end;
        $mall_price_set->down_time = $thism->train_buy_end;
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
        $club_membership_fee = ClubMembershipFee::model()->find('code="TS55"');
        $price = MallPriceSet::model()->find('service_id='.$thism->id.' and pricing_type=352');
        $mset_id = $price->id;
        $adata=ClubTrainData::model()->findAll('train_id='.$thism->id);
        foreach ($adata as $v) { //生成销售价格方案
            $this->save_MallPriceSetDetails($thism,$v,$mset_id, $club_membership_fee);
            $this->save_MallPricingDetails($thism,$v,$mset_id, $club_membership_fee);
        }
    }

    function save_MallPriceSetDetails($thism,$v,$mset_id,$p){
        $w1='set_id='.$mset_id.' and pricing_type=352 and service_data_id='.$v->id;
        $MallPriceSetDetails = MallPriceSetDetails::model()->find($w1);
        if(empty($MallPriceSetDetails)){
            $MallPriceSetDetails = new MallPriceSetDetails;
            $MallPriceSetDetails->isNewRecord = true;
            unset($MallPriceSetDetails->id);
            $MallPriceSetDetails->set_id = $mset_id;
        }
        $MallPriceSetDetails->pricing_type = 352;
        if(!empty($p)){
            $MallPriceSetDetails->product_id =$p->product_id;
            $MallPriceSetDetails->product_code =$p->product_code;
            $MallPriceSetDetails->product_name =$p->product_name;
            $MallPriceSetDetails->json_attr =$p->json_attr;
        }
        $MallPriceSetDetails->purpose = 94;
        $MallPriceSetDetails->shop_purpose = 94;
        $MallPriceSetDetails->sale_price = $v->train_money;
        $MallPriceSetDetails->Inventory_quantity = $v->apply_number;
        $MallPriceSetDetails->up_quantity = $v->apply_number;
        $MallPriceSetDetails->service_id = $thism->id;
        $MallPriceSetDetails->service_code =$thism->train_code;
        $MallPriceSetDetails->service_name =$thism->train_title;
        $MallPriceSetDetails->service_data_id = $v->id;
        $MallPriceSetDetails->service_data_name = $v->train_content;
        $MallPriceSetDetails->u_date = date('Y-m-d H:i:s');
        $MallPriceSetDetails->star_time = $thism->train_buy_start;
        $MallPriceSetDetails->end_time = $thism->train_buy_end;
        $MallPriceSetDetails->down_time = $thism->train_buy_end;
        $MallPriceSetDetails->supplier_id = $thism->train_clubid;
        $MallPriceSetDetails->supplier_name = $thism->train_clubname;
        $MallPriceSetDetails->f_check = 2;
        $MallPriceSetDetails->save();
    }
    
    function save_MallPricingDetails($thism,$v,$mset_id,$p){
        $w1='set_id='.$mset_id.' and pricing_type=352 and service_data_id='.$v->id;
        $SetDs = MallPriceSetDetails::model()->find($w1);
        $w1='pricing_type=352 and set_id='.$mset_id.' and service_data_id='.$v->id.' and set_details_id='.$SetDs->id;
        $MallPricingDetails = MallPricingDetails::model()->find($w1);
        if(empty($MallPricingDetails)){
            $MallPricingDetails = new MallPricingDetails;
            $MallPricingDetails->isNewRecord = true;
            unset($MallPricingDetails->id);
        }
        $MallPricingDetails->set_id = $mset_id;
        $MallPricingDetails->star_time = $thism->train_buy_start;
        $MallPricingDetails->start_sale_time = $thism->train_buy_start;
        $MallPricingDetails->end_time = $thism->train_buy_end;
        $MallPricingDetails->down_time = $thism->train_buy_end;
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
        $MallPricingDetails->sale_price = $v->train_money;
        $MallPricingDetails->shopping_price = $v->train_money;
        $MallPricingDetails->add_adminid = get_session('admin_id');
        $MallPricingDetails->service_id = $thism->id;
        $MallPricingDetails->service_code = $thism->train_code;
        $MallPricingDetails->service_name = $thism->train_title;
        $MallPricingDetails->service_data_id = $v->id;
        $MallPricingDetails->service_data_name = $v->train_content;
        $MallPricingDetails->inventory_quantity = $v->apply_number;
        $MallPricingDetails->if_user = 649;
        $MallPricingDetails->pricing_type = 352;
        $MallPricingDetails->supplier_id = $thism->train_clubid;
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
}
