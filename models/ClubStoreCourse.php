<?php

class ClubStoreCourse extends BaseModel {

	public $explain_temp = '';
	public $remove_data_ids = '';
    public $course_data_list = '';
    public $show=0;

    public function tableName() {
        return '{{club_store_course}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='course_code,course_title,course_small_pic,course_big_pic,course_club_id,course_club_code,course_club_name,is_online,dispay_star_time,dispay_end_time,market_time,market_time_end,state,explain,explain_temp,audit_time,adminid,admin_name,change_time,change_adminid,change_adminname,gf_gross,club_gross,course_money,project_id,course_grade,course_type_id,course_type2_id';
        if($this->show==0){
            $a = array(
                array('dispay_star_time,dispay_end_time,market_time,market_time_end', 'required', 'message' => '{attribute} 不能为空'),
                array($this->safeField(),'safe'),
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
			'online' => array(self::BELONGS_TO, 'BaseCode', 'is_online'),
			'admin' => array(self::BELONGS_TO, 'QmddAdministrators', 'change_adminid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '自增id',
            'course_code' => '课程编号',
            'course_title' => '课程标题',
            'course_small_pic' => '缩略图',
            'course_big_pic' => '滚动图',
            'course_club_id' => '发布单位',
            'course_club_code' => '发布单位账号',
            'course_club_name' => '发布单位名称',
            'is_online' => '显示前端',
            'dispay_star_time' => '显示时间',
            'dispay_end_time' => '显示时间',
            'course_money' => '费用（元）',
            'course_grade' => '课程难度',
            'course_grade_name' => '课程难度名称',
            'project_id' => '项目',
            'project_name' => '项目名称',
            'market_time' => '销售时间',
            'market_time_end' => '销售时间',
            'state' => '审核状态',
            'state_name' => '状态名称',
            'explain' => '课程介绍',
            'uDate' => '更新时间',
            'audit_time' => '审核时间',
            'adminid' => '审核员',
            'adminname' => '审核操作员名称',
            'change_time' => '信息更改时间',
            'change_adminid' => '更改信息操作员id,关联qmdd_administrators表ID',
            'change_adminname' => '更改信息操作员',
            'gf_gross' => '平台毛利（%）',
            'club_gross' => '单位毛利率（%）',
            'course_type_id' => '类型',
            'course_type_name' => '培训类型',
            'course_type2_id' => '类别',
            'course_type2_name' => '类别',
            'course_data_list' => '课程列表',
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

		// 图文描述处理
        $basepath = BasePath::model()->getPath(292);
        if ($_POST["ClubStoreCourse"]['explain_temp'] != '') {
            if ($this->explain != '') {
                set_html($this->explain, $_POST["ClubStoreCourse"]['explain_temp'], $basepath);
            } else {
                $rs = set_html('', $_POST["ClubStoreCourse"]['explain_temp'], $basepath);
            }
			if (isset($rs['filename'])) {
                $this->explain = $rs['filename'];
            }
        } else {
            $this->explain = '';
        }

        if($this->isNewRecord){
            if(empty($this->course_code)){
                $code=$_POST["ClubStoreCourse"]['course_club_code'];
                $num = date('md');
                $num1 = '00';
                $code1 = $this->find("left(course_code,15)='K".$code.$num."' order by course_code DESC");
                if(!empty($code1)){
                    $num1 = $code1->course_code;
                }
                $this->course_code = 'K'.$code.$num.substr(''.(101+substr($num1, -2)),1,2);
            }
        }
        if($this->state==2){
            $fee = ClubMembershipFee::model()->find('code="TS58"');
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
        if($this->state==2){
            $this->update_MallPriceSet($this); //*定价方案开始*/
            $this->update_MallPriceSetDetails($this);
        }
    }

    function update_MallPriceSet($thism){
        //*定价方案开始*/
        $mall_price_set= MallPriceSet::model()->find('service_id='.$thism->id.' and pricing_type=1537');
        /*检查类型为1537课程购买的是否存在该课程*/
        if(empty($mall_price_set)){
            $mall_price_set = new MallPriceSet;
            $mall_price_set->isNewRecord = true;
            unset($mall_price_set->id);
            $mall_price_set->service_id = $thism->id;
        }
        $mall_price_set->event_title = $thism->course_title;
        $mall_price_set->supplier_id = $thism->course_club_id;
        $mall_price_set->supplier_name = $thism->course_club_name;
        $mall_price_set->pricing_type = 1537;
        $mall_price_set->pricing_type_name = '课程';
        $mall_price_set->star_time = $thism->market_time;
        $mall_price_set->start_sale_time = $thism->market_time;
        $mall_price_set->end_time = $thism->market_time_end;
        $mall_price_set->down_time = $thism->market_time_end;
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
        $club_membership_fee = ClubMembershipFee::model()->find('code="TS58"');
        $price = MallPriceSet::model()->find('service_id='.$thism->id.' and pricing_type=1537');
        $mset_id = $price->id;
        $this->save_MallPriceSetDetails($thism,$mset_id, $club_membership_fee);
        $this->save_MallPricingDetails($thism,$mset_id, $club_membership_fee);
    }

    function save_MallPriceSetDetails($thism,$mset_id,$p){
        $w1='set_id='.$mset_id.' and pricing_type=1537 and service_id='.$thism->id;
        $MallPriceSetDetails = MallPriceSetDetails::model()->find($w1);
        if(empty($MallPriceSetDetails)){
            $MallPriceSetDetails = new MallPriceSetDetails;
            $MallPriceSetDetails->isNewRecord = true;
            unset($MallPriceSetDetails->id);
            $MallPriceSetDetails->set_id = $mset_id;
        }
        $MallPriceSetDetails->pricing_type = 1537;
        if(!empty($p)){
            $MallPriceSetDetails->product_id =$p->product_id;
            $MallPriceSetDetails->product_code =$p->product_code;
            $MallPriceSetDetails->product_name =$p->product_name;
            $MallPriceSetDetails->json_attr =$p->json_attr;
        }
        $MallPriceSetDetails->purpose = 94;
        $MallPriceSetDetails->shop_purpose = 94;
        $MallPriceSetDetails->sale_price = $thism->course_money;
        $MallPriceSetDetails->Inventory_quantity = null;
        $MallPriceSetDetails->up_quantity = null;
        $MallPriceSetDetails->service_id = $thism->id;
        $MallPriceSetDetails->service_code =$thism->course_code;
        $MallPriceSetDetails->service_name =$thism->course_title;
        $MallPriceSetDetails->service_data_id = $thism->id;
        $MallPriceSetDetails->service_data_name = $thism->course_title;
        $MallPriceSetDetails->u_date = date('Y-m-d H:i:s');
        $MallPriceSetDetails->star_time = $thism->market_time;
        $MallPriceSetDetails->start_sale_time = $thism->market_time;
        $MallPriceSetDetails->end_time = $thism->market_time_end;
        $MallPriceSetDetails->down_time = $thism->market_time_end;
        $MallPriceSetDetails->supplier_id = $thism->course_club_id;
        $MallPriceSetDetails->supplier_name = $thism->course_club_name;
        $MallPriceSetDetails->f_check = 2;
        $MallPriceSetDetails->save();
    }

    function save_MallPricingDetails($thism,$mset_id,$p){
        $w1='set_id='.$mset_id.' and pricing_type=1537 and service_id='.$thism->id;
        $SetDs = MallPriceSetDetails::model()->find($w1);
        $w1='pricing_type=1537 and set_id='.$mset_id.' and service_id='.$thism->id.' and set_details_id='.$SetDs->id;
        $MallPricingDetails = MallPricingDetails::model()->find($w1);
        if(empty($MallPricingDetails)){
            $MallPricingDetails = new MallPricingDetails;
            $MallPricingDetails->isNewRecord = true;
            unset($MallPricingDetails->id);
        }
        $MallPricingDetails->set_id = $mset_id;
        $MallPricingDetails->star_time = $thism->market_time;
        $MallPricingDetails->start_sale_time = $thism->market_time;
        $MallPricingDetails->end_time = $thism->market_time_end;
        $MallPricingDetails->down_time = $thism->market_time_end;
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
        $MallPricingDetails->sale_price = $thism->course_money;
        $MallPricingDetails->shopping_price = $thism->course_money;
        $MallPricingDetails->add_adminid = get_session('admin_id');
        $MallPricingDetails->service_id = $thism->id;
        $MallPricingDetails->service_code = $thism->course_code;
        $MallPricingDetails->service_name = $thism->course_title;
        $MallPricingDetails->service_data_id = $thism->id;
        $MallPricingDetails->service_data_name = $thism->course_title;
        $MallPricingDetails->inventory_quantity = null;
        $MallPricingDetails->if_user = 649;
        $MallPricingDetails->pricing_type = 352;
        $MallPricingDetails->supplier_id = $thism->course_club_id;
        $MallPricingDetails->supplier_name = $thism->course_club_name;
        $MallPricingDetails->f_check = 2;
        $MallPricingDetails->save();
    }




}
