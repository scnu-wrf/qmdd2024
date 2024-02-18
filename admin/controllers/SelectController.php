<?php

class SelectController extends BaseController {

    protected $model = '';

    public function init() {
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionProducts($keywords = '', $club_id = 0, $type = 0) {
        $data = array();
        $model = MallProducts::model();
        $criteria = new CDbCriteria;
        //$criteria->condition = 'IS_DELETE=510 AND type_fater>1158 and type_fater<1163';
		$criteria->condition = 'display=2 AND IS_DELETE=510 AND type_fater=361 and product_code is not null';
        //$criteria->condition .=' AND supplier_id='.$club_id;
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' supplier_id',$club_id,'');
		//$criteria->condition=get_where($criteria->condition,!empty($type),' type_fater',$type,'');
        $criteria->condition=get_like($criteria->condition,'name,supplier_code',$keywords,'');
		$criteria->order = 'supplier_code ASC';
        parent::_list($model, $criteria, 'products', $data);
    }

	public function actionServant($keywords = '', $club_id = 0, $type = 0, $project_id = 0) {
        $data = array();
        $model = QmddServerPerson::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'check_state=2';
		$criteria->condition .=' AND '.get_where_club_project('club_id','');
		$criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,'');
        if ($keywords != '') {
            $criteria->condition .= ' AND (qualification_name like "%' . $keywords . '%" OR qcode like "%' . $keywords . '%")';
        }
		$criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'servant', $data);
    }

    public function actionProductData($keywords = '', $club_id = 0,$type='') {
        $data = array();
        $model = MallProducts::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'IS_DELETE=510 AND display in (2,511)';

        $criteria->condition .=' AND '.get_where_club_project('supplier_id','');
		if ($type != '') {
            $criteria->condition.=' AND type_fater=' . $type;
        }
        if ($keywords != '') {
            $criteria->condition .= ' AND (name like "%' . $keywords . '%" OR code like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'productData', $data);
    }

    //选择商品分类
    public function actionProduct_type($keywords = '') {
        $data = array();
        $model = MallProductsTypeSname::model();
        $criteria = new CDbCriteria;
        //$criteria->condition = 'length(trim(tn_code))=1';
        $criteria->condition = '1=1';
        if ($keywords != '') {
            $criteria->condition .= ' AND sn_name like "%' . $keywords . '%"';
        }
        $criteria->order = 'tn_code';
        $data = array();
        parent::_list($model, $criteria, 'product_type', $data,1000);
    }

    //选择毛利结算分类设置
	public function actionGross_type($keywords = '') {
        $data = array();
        $model = MallProductsTypeSname::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'base_f_id in(351,352,353,354,355,356,357,359,777,1424)';
        if ($keywords != '') {
            $criteria->condition .= ' AND ct_name like "%' . $keywords . '%"';
        }
		$criteria->order = 'tn_code';
        $data = array();
        parent::_list($model, $criteria, 'gross_type', $data,1000);
    }

	////////////选择服务上架资源///////////
	public function actionServer_sourcer($keywords='',$club_id=0,$type=0,$star='',$end='',$stype='') {
        $data = array();
        $arr = array();
        $model = QmddServerSourcer::model();
        $pagename='server_sourcer';
        $arrid='';
        $sourcerid=QmddServerSetData::model()->findAll('s_timestar>="'.$star.' 00:00:00" and s_timeend<="'.$end.' 23:59:59" group by server_sourcer_id');
        if(!empty($sourcerid)){
            foreach ($sourcerid as $s) $arr[]=$s->server_sourcer_id;
            $arrid=gf_implode(',',$arr);
        }
        $criteria = new CDbCriteria;
        $cr = 'state=2  AND t.s_levelid is not null';
        $cr.=' and club_id='.$club_id;
        /*
        if($arrid!=''){
            $cr.=' and t.id not in ('.$arrid.')';
        }*/
		$cr=get_where($cr,!empty($type),' t.t_typeid',$type,'');
        $cr=get_where($cr,!empty($stype),' t.t_stypeid',$stype,'');
        $cr=get_like($cr,'t.s_code,t.s_name',$keywords,'');
        $criteria->condition=$cr;
		$criteria->order = 't.s_code ASC';
        if($type==1){
           $pagename='server_sourcer_CG';
        } elseif($type==2){
            $pagename='server_sourcer_FWZ';
        }
        $data['stype'] = QmddServerUsertype::model()->getType($type);
        parent::_list($model, $criteria, 'server_sourcer', $data);
    }

	////////////选择服务///////////
	public function actionService($keywords = '', $type=0,$club_id=0) {
        $data = array();
		$base_code=BaseCode::model()->findByPk($type);
		$modelname=$base_code->F_VIEWNAME;
		$sql=$base_code->sql_select;
        $model = $modelname::model();
        $criteria = new CDbCriteria;
		//$criteria->select = 'id select_id,name select_title,code select_code';
        $criteria->condition = $sql;

		if($type==361 || $type==363 || $type==363) {
			$criteria->condition .=' AND '.get_where_club_project('supplier_id','');

			$criteria->condition.=' AND type_fater=' . $type;

            if ($keywords != '') {
               $criteria->condition .= ' AND (name like "%' . $keywords . '%" OR code like "%' . $keywords . '%")';
            }
            parent::_list($model, $criteria, 'service_product', $data);
		} else if ($type==351 || $type==354) {
		    $criteria->condition .=' AND '.get_where_club_project('game_club_id','');

			$criteria->condition=get_like($criteria->condition,'game_code,game_title',$keywords,'');
			parent::_list($model, $criteria, 'service_game', $data);
		} else if ($type==353) {
		    $criteria->condition .=' AND '.get_where_club_project('club_id','');
			$criteria->condition=get_like($criteria->condition,'service_code,title',$keywords,'');
			parent::_list($model, $criteria, 'service_servicedata', $data);
		} else if ($type==356) {
			  $criteria->condition .=' AND '.get_where_club_project('club_id','');
			$criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
			parent::_list($model, $criteria, 'service_memberset', $data);
		} else if ($type==366) {
			  $criteria->condition .=' AND '.get_where_club_project('club_id','');
			$criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
			parent::_list($model, $criteria, 'service_live', $data);
		} else if ($type==352) {
		    $criteria->condition .=' AND '.get_where_club_project('train_clubid','');
			$criteria->condition=get_like($criteria->condition,'train_code,train_title',$keywords,'');
			parent::_list($model, $criteria, 'service_train', $data);
		} else if ($type==355 || $type==357 || $type==358 || $type==359) {
			$criteria->condition=get_like($criteria->condition,'card_code,card_name',$keywords,'');
			parent::_list($model, $criteria, 'service_membercard', $data);
		} else if ($type==365) {
			$criteria->condition .=' AND '.get_where_club_project('club_id','');
			$criteria->condition=get_like($criteria->condition,'video_code,video_title',$keywords,'');
			parent::_list($model, $criteria, 'service_video', $data);
		}
    }
	//选择单条直播
    public function actionVideoLive($keywords = '', $club_id = '', $edit = 0) {
		$data = array();
        $model = VideoLive::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
		if($edit==1){
			$criteria->condition= 'if_del=648 and live_state=2 and state=1364';
		}else{
			$criteria->condition= 'if_del=648 and live_state=2 and state=1364 and live_end>"'.$now.'"';
		}
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->group='id';
		$criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'videolive', $data);
    }
	//选择多条直播
    public function actionVideoLive_more($keywords = '', $club_id = '') {
		$data = array();
        $model = VideoLive::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 'if_del=648 and live_state=2 and state=1364 and live_end>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'id DESC';
        $criteria->group='id';
        parent::_list($model, $criteria, 'videolive_more', $data);
    }
	//选择单条资讯
    public function actionClubNews($keywords = '', $club_id = '') {
		$data = array();
        $model = ClubNews::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 'if_del=506 and state=2 and news_date_end>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'news_code,news_title',$keywords,'');
        $criteria->order = 'id DESC';
        $criteria->group='id';
        parent::_list($model, $criteria, 'clubnews', $data);
    }
	//选择多条资讯
    public function actionClubNews_more($keywords = '', $club_id = '') {
		$data = array();
        $model = VideoLive::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 'if_del=506 and state=2 and news_date_end>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'news_code,news_title',$keywords,'');
        $criteria->order = 'id DESC';
        $criteria->group='id';
        parent::_list($model, $criteria, 'clubnews_more', $data);
    }
	//选择单条赛事
    public function actionGame($keywords = '', $club_id = '') {
		$data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 'state=2 and dispay_end_time>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' game_club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'id DESC';
        $criteria->group='id';
        parent::_list($model, $criteria, 'game', $data);
    }
	//选择多条赛事
    public function actionGame_more($keywords = '', $club_id = '') {
		$data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 'and state=2 and dispay_end_time>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' game_club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'id DESC';
        $criteria->group='id';
        parent::_list($model, $criteria, 'game_more', $data);
    }
	//选择单位
    public function actionClub($keywords = '', $partnership_type = '',$club_type = '',$edit_state='') {
        $data = array();
        $model = ClubList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unit_state=648 and state=2';
        if(!empty($edit_state)){
            $criteria->condition .= ' and edit_state='.$edit_state;
        }
        $criteria->condition=get_where($criteria->condition,!empty($club_type),' club_type',$club_type,'');
        $criteria->condition=get_where($criteria->condition,!empty($partnership_type),' partnership_type',$partnership_type,'');
        // $criteria->condition=get_where($criteria->condition,!empty($edit_state),' edit_state',$edit_state,'');
        $criteria->condition=get_like($criteria->condition,'club_code,club_name',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'club', $data);
    }

	// $partnership_type 单位类型
    // $no_cooperation 单位id，非此单位的联盟单位
    public function actionClubmore($keywords = '', $partnership_type = 0, $project_id = 0, $no_cooperation = 0,$club_type = '',$club_id = '') {

     $this->show_club($keywords, $partnership_type, $project_id, $no_cooperation,$club_type,$club_id,'clubmore');
    }

    function show_club($keywords, $partnership_type, $project_id, $no_cooperation,$club_type,$club_id,$pfile ) {
        $data = array();
        $model = ClubList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unit_state=648 and state=2 and edit_state=2';
        $criteria->select = 'id select_id,club_name select_title,club_code select_code';
        if ($keywords != '') {
            $criteria->condition .= ' AND (club_name like "%' . $keywords . '%" OR club_code like "%' . $keywords . '%")';
        }

        if ($partnership_type > 0) {
            $criteria->condition .= ' AND partnership_type=' . $partnership_type;
        }

        if ($project_id > 0) {
            $criteria->condition .= ' AND EXISTS(SELECT id FROM club_project WHERE club_id=t.id AND project_id=' . $project_id . ')';
        }

        if ($no_cooperation > 0) {
            $cooperation = CooperationClubList::model()->findAll('(club_id=' . $no_cooperation . ' OR invite_club_id=' . $no_cooperation . ')'
                    . ' AND project_id=' . $project_id.' AND cooperation_state not in (338,499,511)');
            $arr = array();
            foreach ($cooperation as $v) {
                if ($v->club_id != $no_cooperation) {
                    $arr[] = $v->club_id;
                } elseif ($v->invite_club_id != $no_cooperation) {
                    $arr[] = $v->invite_club_id;
                }
            }
            if (!empty($arr)) {
                $criteria->condition .= ' AND id not in (' . implode(',', $arr) . ')';
            }
            $criteria->condition .= ' AND id!=' . $no_cooperation;
        }
        if ($club_type != '') {
            $criteria->condition .= ' AND club_type=' . $club_type;
        }
        if ($club_id != '') {
            $arr='-1';
            $rec_club=GfRecommendClub::model()->find('club_id='.$club_id);
            if(!empty($rec_club->club_list)){
                $arr=$rec_club->club_list;
            }
            $criteria->condition .= ' AND id in (' .$arr. ')';
        }


        parent::_list($model, $criteria, $pfile, $data);
    }

    // 推荐到单位
    public function actionRecommClublist($keywords='',$club_id=0) {
        $data = array();
        $model = ClubList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unit_state=648 and id<>'.$club_id;
        $criteria->condition = get_like($criteria->condition,'',$keywords,'');
        parent::_list($model,$criteria,'recommClublist',$data);
    }

    //已认证包含项目的单位
    public function actionClublist($keywords = '', $partnership_type = 0, $project_id = 0, $club_type = '') {
        $data = array();
        $model = ClubList::model();
        $criteria = new CDbCriteria;
        if(empty($keywords)){
            $keywords='ghhggghdjyteyjtefdddd';
        }
        $criteria->condition = 'unit_state=648 and if(club_type in(8,189,380),state=2 and edit_state=2,state=2)';
        // $criteria->condition .=' AND '.get_where_club_project('club_id','');
        $criteria->condition .= ' AND EXISTS(SELECT id FROM club_project WHERE club_id=t.id AND project_state=506 AND auth_state=461)';

        $criteria->condition=get_like($criteria->condition,'club_code,club_name',$keywords,'');
        if ($partnership_type > 0) {
            $criteria->condition .= ' AND partnership_type=' . $partnership_type;
        }
        if ($project_id > 0) {
            $criteria->condition .= ' AND EXISTS(SELECT id FROM club_project WHERE club_id=t.id AND project_id=' . $project_id . ')';
        }
        if ($club_type != '') {
            $criteria->condition .= ' AND club_type=' . $club_type;
        }
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'clublist', $data);
    }

    //单位信息待认证
    public function actionClubEditlist($keywords = '', $partnership_type = 0, $project_id = 0, $club_type = '', $state = '', $edit_state = '') {
        $data = array();
        $model = ClubList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unit_state=648 and isNull(edit_state)';
        // $criteria->condition .=' AND '.get_where_club_project('club_id','');

        $criteria->condition=get_like($criteria->condition,'club_code,club_name',$keywords,'');
        if ($partnership_type > 0) {
            $criteria->condition .= ' AND partnership_type=' . $partnership_type;
        }
        if ($project_id > 0) {
            $criteria->condition .= ' AND EXISTS(SELECT id FROM club_project WHERE club_id=t.id AND project_id=' . $project_id . ')';
        }
        if ($club_type != '') {
            $criteria->condition .= ' AND club_type=' . $club_type;
        }
        if ($state != '') {
            $criteria->condition .= ' AND state=' . $state;
        }
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'clubEditlist', $data);
    }

	//选择发货商品
    public function actionOrderdata($keywords = '',$club_id=0) {
        $data = array();
        $arr_r = array();
        $arr_r[]=-1;
        $model = MallSalesOrderData::model();
        $return_data=$model->findAll('supplier_id='.$club_id.' AND order_type=361 AND change_type=1137 AND sale_show_id in (1129,1132,1133,1134,1135) and ret_state in (371,2)');
        foreach($return_data as $r){
            $arr_r[]=$r->Return_no;
        }
        $return_id=implode(',', $arr_r);
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.$club_id.' AND (logistics_id=0 or logistics_id="") AND order_type=361 AND change_type=0 AND gfid>0 and sale_show_id in (1129,1132,1133,1134,1135) and id not in ('.$return_id.')';
        $criteria->condition=get_like($criteria->condition,'order_num,product_code,product_title',$keywords,'');
		$criteria->order = 'gfid DESC';
        parent::_list($model, $criteria, 'orderdata', $data);
    }
	//选择开票商品
    public function actionInvoice_data($keywords = '',$club_id=0,$order_num='') {
        $data = array();
        $model = MallSalesOrderData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.$club_id.' AND invoice_data_id=0 AND order_num="'.$order_num.'"';
        $criteria->condition=get_like($criteria->condition,'product_code,product_title',$keywords,'');
		$criteria->order = 'gfid DESC';
        parent::_list($model, $criteria, 'invoice_data', $data);
    }

	//选择品牌
	public function actionBrand($keywords = '') {
        $data = array();
        $model = MallBrandStreet::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'brand_state=649';
        $criteria->condition.= ' and state=2 and if_del=510';
        //$criteria->select = 'brand_id select_id,brand_title select_title,brand_no select_code';
        if ($keywords != '') {
            $criteria->condition .= ' AND (brand_no like "%' . $keywords . '%" OR brand_title like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'brand', $data);
    }

    //选择单位品牌
    public function actionClubBrand($keywords = '',$club_id =0) {
        $data = array();
        $model = ClubBrand::model();
        $criteria = new CDbCriteria;
        //$criteria->condition = 'brand_state=649';
        $criteria->condition= 'state=2 and if_del=510';
        //$criteria->select = 'brand_id select_id,brand_title select_title,brand_no select_code';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),'club_id',$club_id,'');
        if ($keywords != '') {
            $criteria->condition .= ' AND (brand_no like "%' . $keywords . '%" OR brand_title like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'clubbrand', $data);
    }

    //选择地址
    public function actionClubaddress($keywords = '',$club_id = '') {
        $data = array();
        $model = MallClubAddress::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.$club_id;
        $criteria->condition=get_like($criteria->condition,'consignee,address',$keywords,'');
        parent::_list($model, $criteria, 'clubaddress', $data);
    }

	//选择定价方案
	public function actionMember_price($keywords = '',$sale_type = '') {
        $data = array();
        $model = MallMemberPriceInfo::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'id select_id,f_name select_title,f_code select_code';
		$criteria->condition=get_where($criteria->condition,!empty($sale_type),'sale_id',$sale_type,'');
        if ($keywords != '') {
            $criteria->condition .= ' AND (f_code like "%' . $keywords . '%" OR f_name like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'member_price', $data);
    }

	//选择毛利分配方案
	public function actionSalesperson_profit($keywords = '') {
        $data = array();
        $model = GfSalespersonInfo::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'id select_id,f_name select_title,f_code select_code';
        if ($keywords != '') {
            $criteria->condition .= ' AND (f_code like "%' . $keywords . '%" OR f_name like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'salesperson_profit', $data);
    }

	//选择服务方案
	public function actionServer_info($keywords = '',$club_id=0) {
        $data = array();
        $model = ServerTimePrice::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
		$criteria->condition=get_where($criteria->condition,!empty($club_id),' club_id',$club_id,'');
        $criteria->select = 'id select_id,tp_name select_title,tp_code select_code';
        if ($keywords != '') {
            $criteria->condition .= ' AND (tp_code like "%' . $keywords . '%" OR tp_name like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'server_info', $data);
    }
	//选择直播节目对应的录制文件
	public function actionProgram_video($keywords = '',$program_id=0) {
        $data = array();
        $model = BoutiqueVideo::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
		$criteria->condition=get_where($criteria->condition,!empty($program_id),' live_program_id',$program_id,'');
		$criteria->condition=get_like($criteria->condition,'video_code,video_title',$keywords,'');
        parent::_list($model, $criteria, 'program_video', $data);
    }

	//选择管理员
	public function actionClub_admin($keywords = '') {
        $data = array();
        $model = Clubadmin::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.get_session('club_id');
        $criteria->select = 'id select_id,admin_gfnick select_title,admin_gfaccount select_code';
		//$criteria->condition=get_where($criteria->condition,!empty($club_id),' club_id',$club_id,'');
		$criteria->condition=get_like($criteria->condition,'admin_gfaccount,admin_gfnick',$keywords,'');
        parent::_list($model, $criteria, 'club_admin', $data);
    }
	//添加属性
	public function actionAttribute($keywords = '') {
        $data = array();
        $model = MallAttribute::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent is NULL';
        $criteria->select = 'id select_id,attr_name select_title,attr_code select_code';
        if ($keywords != '') {
            $criteria->condition .= ' AND (attr_name like "%' . $keywords . '%" OR attr_code like "%' . $keywords . '%")';
        }
        parent::_list($model, $criteria, 'attribute', $data);
    }
	//选择gf帐号
	public function actionGfuser($keywords = '',$real_sex=0,$ms_start='',$ms_end='',$passed='',$code=0,$lang_type=0) {
        $data = array();
        $model = userlist::model();
        $criteria = new CDbCriteria;
        if($keywords==''){
            $keywords='IKJM3434534BGFGF122NIFDK';
        }
        $criteria->condition = 'if_del=510';  //  AND '.get_where_club_project('club_id','');
        $criteria->condition = get_like($criteria->condition,'GF_ACCOUNT',$keywords,'');
        $criteria->condition = get_where($criteria->condition,($ms_start!=""),'real_birthday>=',$ms_start,'"');
        $criteria->condition = get_where($criteria->condition,($ms_end!=""),'real_birthday<=',$ms_end,'"');
        if($passed=='0'){
            $criteria->condition .= ' and passed<>2';
        }else{
            $criteria->condition = get_where($criteria->condition,!empty($passed),'passed',$passed,'');
        }
        $criteria->select = 'GF_ID as select_id,GF_NAME as select_title,GF_ACCOUNT as select_code,user_state as select_sex,lock_date_start as select_start,lock_date_end as select_end,passed,ZSXM,real_sex,native,nation,real_birthday,id_card';
        parent::_list($model, $criteria, 'gfuser', $data);
    }

	//选择gf帐号 动动约授权人员，不分单位
	public function actionGfuser_move($keywords='',$club_id='',$len=0) {
        $data = array();
        $model = userlist::model();
        $criteria = new CDbCriteria;
        $con = empty($keywords) ? ' and 1=2' : ' and 1=1';
        $criteria->condition = 'passed=2'.$con;// and club_id='.$club_id;
        // $criteria->condition = get_like($criteria->condition,'GF_ACCOUNT',$keywords,'');
        $criteria->condition = get_where($criteria->condition,!empty($keywords),'GF_ACCOUNT',$keywords,'');
        parent::_list($model, $criteria, 'gfuser_move', $data);
    }

    //选择未注册GF帐号
    public function actionGfIdelUserAllNumber($keywords = ''){
        $data = array();
        $model = GfIdelUserAllNumber::model();
        $criteria = new CDbCriteria;
        if($keywords==''){
            $criteria->condition = 't.is_use=0 and t.f_vip=0';
            $criteria->join = "JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM gf_idel_user_all_number)-(SELECT MIN(id) FROM gf_idel_user_all_number))+(SELECT MIN(id) FROM gf_idel_user_all_number)) AS id from gf_idel_user_all_number limit 30) AS t2 on t.id=t2.id";
        }else{
            $criteria->condition = 'account='.$keywords;
        }
        parent::_list($model,$criteria,'gfIdelUserAllNumber',$data,12);
    }
    //选择会员信息
    public function actionClubMemberList($keywords = '') {
        $data = array();
        $model = ClubMemberList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_status=337';
        $criteria->condition=get_like($criteria->condition,'zsxm,gf_account',$keywords,'');
        parent::_list($model, $criteria, 'clubmemberlist', $data);
    }
	//选择场地
	public function actionGfSite($keywords = '',$club_id=0,$project_id=0) {
        $data = array();
        $model = GfSite::model();
		$now = date('Y-m-d H:i:s');
        $criteria = new CDbCriteria;
        $cr='site_state=2 and user_club_id='.$club_id;
		//$criteria->condition=get_where($criteria->condition,!empty($club_id),' user_club_id',$club_id,'');
       // $criteria->select = 'id as select_id,site_code as select_code,site_name as select_title';
        //$criteria->condition .= ' and site_date_start<"'.$now.'" AND ( site_date_end>"'.$now.'" or site_date_end="0000-00-00 00:00:00" or site_date_end="")';
        if(!empty($project_id)){
            $cr.= ' and exists(select * from gf_site_project gs where gs.site_id=t.id and gs.project_id='.$project_id.')';
        }
        $cr=get_like($cr,'t.site_name',$keywords,'');
        $criteria->condition=$cr;

        parent::_list($model, $criteria, 'gfSite', $data);
    }

	//赛事服务资源-选择场地
	public function actionQmddGfSite($keywords = '',$club_id=0,$project_id=0,$site_id=0) {
        $data = array();
        $model = QmddGfSite::model();
        $criteria = new CDbCriteria;
        $cr = 'site_state=2 and user_club_id='.$club_id;
		$cr=get_where($cr,!empty($site_id),' site_id',$site_id,'');
        $cr=get_where($cr,!empty($project_id),' project_id',$project_id,'');
		$cr=get_like($cr,'site_name,server_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group = 'id';
        parent::_list($model, $criteria, 'qmddgfSite', $data);
    }
	//选择服务者
	public function actionQualification($keywords = '',$project_id='',$type_id='',$free_state_Id='',$is_pay='',$if_del='506') {
        $data = array();
		$p=$project_id;
		$t=$type_id;
        $model = QualificationsPerson::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'unit_state=648 and check_state=2 and auth_state=931 and free_state_Id=1202';
		$criteria->condition .=' and if_del in('.$if_del.')';
       // $criteria->select = 'id select_id,qualification_name select_title,gfaccount select_code';
        if($keywords==''){
            $keywords='IKJM3434534BGFGF122NIFDK';
        }
		$criteria->condition=get_where($criteria->condition,!empty($p),' project_id',$p,'');
		$criteria->condition=get_where($criteria->condition,!empty($t),' qualification_type_id',$t,'');
		$criteria->condition=get_where($criteria->condition,!empty($free_state_Id),' free_state_Id',$free_state_Id,'');
		$criteria->condition=get_where($criteria->condition,!empty($is_pay),' is_pay',$is_pay,'');
        $criteria->condition=get_like($criteria->condition,'qualification_name,gfaccount,gf_code',$keywords,'');
		$criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'qualification', $data);
    }

	//选择证书(已废弃)
	// public function actionCertificate($keywords = '',$type_id='') {
    //     $data = array();
    //     $model = BaseCode::model();
    //     $criteria = new CDbCriteria;
	// 	$criteria->condition = 'F_TCODE="WAITER" AND fater_id<>383';
    //     $criteria->select = 'f_id select_id,F_NAME select_title,F_TCODE select_code';
	// 	if ($type_id != '') {
    //         $criteria->condition .= ' AND fater_id=' . $type_id;
    //     }
	// 	$criteria->condition=get_like($criteria->condition,'F_NAME',$keywords,'');

    //     parent::_list($model, $criteria, 'certificate', $data);
    // }

	//选择证书(新)
	public function actionCertificate_type($keywords = '',$type_id='') {
        $data = array();
        $model = ServicerCertificate::model();
        $criteria = new CDbCriteria;
        $servicerType=ClubServicerType::model()->find('member_second_id="'.$type_id.'"');
		if(!empty($servicerType->certificate_type)) {
            $criteria->condition = 'id in('.$servicerType->certificate_type.')';
        }else{
            $criteria->condition = '!isNull(f_name)';
        }
        $criteria->condition=get_like($criteria->condition,'f_name',$keywords,'');
        parent::_list($model, $criteria, 'certificate_type', $data);
    }

	//资质要求
	public function actionServicerCertificate($keywords = '',$type_id='') {
        $data = array();
        $model = ServicerCertificate::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'isNull(fater_id)';
		$criteria->condition=get_like($criteria->condition,'f_name',$keywords,'');

        parent::_list($model, $criteria, 'servicerCertificate', $data);
    }

    //添加项目
    public function actionProject($keywords = '', $site_id = 0, $club_id=0) {
        $data = array();
		$model = ProjectList::model();
        $criteria = new CDbCriteria;
		$pro = array();
		if ($club_id>0) {
			$club=ClubProject::model()->findAll('project_state=506 AND auth_state=461 AND state=2 AND club_id='.$club_id);
			if (!empty($club)) {
				foreach ($club as $p) {
					$pro[]=$p->project_id;
				}
			} else {
				$pro[]=0;
			}
			$project=implode(',', $pro);
			$criteria->condition = 'project_type=1 AND (IF_VISIBLE=649 or IF_VISIBLE=1 AND  if_del=648) AND id in ('.$project.')';
		} else {
			$criteria->condition = 'project_type=1 AND IF_VISIBLE=649 or IF_VISIBLE=1 AND  if_del=648';
		}
        $criteria->select = 'id as select_id,project_name as select_title';
        $criteria->condition=get_like($criteria->condition,'project_name,project_simple_code',$keywords,'');
        if ($site_id > 0) {
            $site = GfSite::model()->find(array('condition' => 'id=' . $site_id, 'select' => 'site_code'));
            $project_list = GfSiteProject::model()->findAll(array('condition' => 'site_code="' . $site->site_code . '"', 'select' => 'project_id'));
            $arr = array();
            foreach ($project_list as $v) {
                $arr[] = $v->project_id;
            }
            $criteria->condition.=' AND id in (' . implode(',', $arr) . ')';
        }
        parent::_list($model, $criteria, 'project', $data);
    }

    //添加项目 (单选html)
    public function actionProject_list($keywords = '', $site_id = 0, $club_id=0,$project_state='506') {
        $data = array();
		$model = ProjectList::model();
        $criteria = new CDbCriteria;
		$pro = array();
		if ($club_id>0) {
			$club=ClubProject::model()->findAll('project_state in('.$project_state.') AND auth_state=461 AND state=2 AND club_id='.$club_id);
			if (!empty($club)) {
				foreach ($club as $p) {
					$pro[]=$p->project_id;
				}
			} else {
				$pro[]=0;
			}
			$project=implode(',', $pro);
			$criteria->condition = '(IF_VISIBLE=649 or IF_VISIBLE=1 AND  if_del=648) AND id in ('.$project.')';
		} else {
			$criteria->condition = 'IF_VISIBLE=649 or IF_VISIBLE=1 AND  if_del=648';
		}
        $criteria->select = 'id as select_id,project_name as select_title';
		$criteria->condition=get_like($criteria->condition,'project_name,project_simple_code',$keywords,'');
        if ($site_id > 0) {
            $site = GfSite::model()->find(array('condition' => 'id=' . $site_id, 'select' => 'site_code'));
            $project_list = GfSiteProject::model()->findAll(array('condition' => 'site_code="' . $site->site_code . '"', 'select' => 'project_id'));
            $arr = array();
            foreach ($project_list as $v) {
                $arr[] = $v->project_id;
            }
            $criteria->condition.=' AND id in (' . implode(',', $arr) . ')';
        }
        parent::_list($model, $criteria, 'project_list', $data);
    }

    //选择单位项目
    public function actionClubProject($keywords = '', $site_id = 0, $club_id=0) {
        $data = array();
		$model = ClubProject::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'project_state=506 AND auth_state=461 AND state=2 AND free_state_Id=1202';
        $criteria->condition=get_like($criteria->condition,'club_name,p_code,project_name',$keywords,'');
        $criteria->order = 'p_code desc';
        parent::_list($model, $criteria, 'clubProject', $data);
    }

    public function actionAdverService($adver_url_id, $club_id = 0, $keywords = '', $noid = '') {
        $data = array();
        $data['adver_url_id'] = $adver_url_id;
        $adver_url = AdverUrl::model()->getOne($adver_url_id);
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        if ($adver_url->ADV_URL_TABLE != '') {
            $modelName = $adver_url->ADV_URL_TABLE;
            $model = $modelName::model();
            $criteria->alias = $model->tableSchema->name;
            $selectArr = explode(',', $adver_url->ADV_URL_DATA);
            $whereArr = explode(' ', $adver_url->ADV_URL_DATA_WHERE);
            $with = array(); // 关联表
            // 获取关联表的表名
            foreach ($selectArr as $v) {
                $arr = explode('.', trim($v));
                if (count($arr) > 1 && $arr[0] != '' && !in_array($arr[0], $with) && $arr[0] != $criteria->alias) {
                    $with[] = $arr[0];
                }
            }

            foreach ($whereArr as $v) {
                $arr = explode('.', trim($v));
                if (count($arr) > 1 && $arr[0] != '' && !in_array($arr[0], $with) && $arr[0] != $criteria->alias) {
                    $with[] = $arr[0];
                }
            }

            // 判断是否存在多表关联
            if (!empty($with)) {
                $criteria->with = $with;

//                dump($criteria->select);
//                exit;
            }
            $arr = array();
            $selectitem = array('select_id', 'select_title', 'select_item1', 'select_item2', 'select_item3');
            foreach ($selectArr as $k => $v) {
                $arr[] = $v . ' as ' . $selectitem[$k];
            }
//                dump(implode(',', $arr));
//                exit;
            $criteria->select = implode(',', $arr);
            if (!empty($adver_url->ADV_URL_DATA_WHERE)) {
                $criteria->condition.=' AND ' . $adver_url->ADV_URL_DATA_WHERE;
            }

            // 如果广告本身为赛事馆，变更时排除自己
            if ($adver_url_id == 3 && $noid != '') {
                $criteria->condition.= ' AND ' . $selectArr[0] . '!=' . $noid;
            }
            if (!empty($keywords)) {
                $criteria->condition.=' AND ' . $selectArr[1] . ' like "%' . $keywords . '%"';
            }
            if ($adver_url_id == 10) {
                $criteria->condition.=' AND live_start<=now() and live_end>now() and state=1364 and channelState in(1,696) and if_del=648 and is_uplist=1';
            }

            if ($club_id > 0) {
                $criteria->condition = str_replace('[:club_id]', $club_id, $criteria->condition);
            }

            if ($adver_url_id == 198) {
                $criteria->group = 'mall_price_set_details.product_id';
            }
        } else {
            $nodata = (object) null;
            $nodata->select_id = 0;
            $nodata->select_title = '调用异常';
            $data['arclist'] = array($nodata);
            $data['pages'] = new CPagination(0);
            $this->render('adverService', $data);
            exit;
        }
        parent::_list($model, $criteria, 'adverService', $data);
    }

    public function actionGetAdverService($adver_url_id, $id) {
        $data = array();
        $data['adver_url_id'] = $adver_url_id;
        $adver_url = AdverUrl::model()->getOne($adver_url_id);
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        if ($adver_url->ADV_URL_TABLE != '') {
            $modelName = $adver_url->ADV_URL_TABLE;
            $model = $modelName::model();
            $criteria->alias = $model->tableSchema->name;
            $selectArr = explode(',', $adver_url->ADV_URL_DATA);
            $whereArr = explode(' ', $adver_url->ADV_URL_DATA_WHERE);
            $with = array(); // 关联表
            // 获取关联表的表名
            foreach ($selectArr as $v) {
                $arr = explode('.', trim($v));
                if (count($arr) > 1 && $arr[0] != '' && !in_array($arr[0], $with) && $arr[0] != $criteria->alias) {
                    $with[] = $arr[0];
                }
            }

            foreach ($whereArr as $v) {
                $arr = explode('.', trim($v));
                if (count($arr) > 1 && $arr[0] != '' && !in_array($arr[0], $with) && $arr[0] != $criteria->alias) {
                    $with[] = $arr[0];
                }
            }

            // 判断是否存在多表关联
            if (!empty($with)) {
                $criteria->with = $with;
//                foreach ($selectArr as $k => $v) {
//                    if (strpos($v, '.') === false) {
//                        $selectArr[$k] = 't.' . $v;
//                    }
//                }
                $criteria->select = $selectArr[0] . ' as select_id,' . $selectArr[1] . ' as select_title';
                $criteria->condition.=' AND ' . $selectArr[0] . '=' . $id;
            } else {
                $criteria->select = $selectArr[0] . ' as select_id,' . $selectArr[1] . ' as select_title';
                $criteria->condition.=' AND ' . $selectArr[0] . '=' . $id;
            }
        } else {
            $nodata = (object) null;
            $nodata->select_id = 0;
            $nodata->select_title = '调用异常';
            $data['arclist'] = array($nodata);
            $data['pages'] = new CPagination(0);
            $this->render('adverService', $data);
            exit;
        }
        $rs = $model->find($criteria);
        if ($rs != null) {
            echo $rs->select_title;
        }
    }

    public function actionServicePerson($club_id, $project_id = 0, $keywords = '',$code_type='',$ser_gf=0) {
        $data = array();
        $model = QualificationClub::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('qualifications_person');
        $now = date('Y-m-d H:i:s');
        $arrClub = array($club_id);
        $cooperation = CooperationClubList::model()->findAll('club_id=' . $club_id . ' AND (cooperation_state=337 OR cooperation_state=497)');
        foreach ($cooperation as $v) {
            $arrClub[] = $v->invite_club_id;
        }
        $criteria->condition = 't.club_id in (' . implode(',', $arrClub) . ') AND (t.state=337 OR t.state=497) AND qualifications_person.start_date<"' . $now . '" AND qualifications_person.end_date>"' . $now . '" AND qualifications_person.check_state=2 AND qualifications_person.qualification_type_id<>335 AND (qualifications_person.if_del=506 OR qualifications_person.if_del=510)';
        $criteria->select = '*,t.qualification_person_id as select_id,qualifications_person.qualification_name as select_title';
        if ($keywords != '') {
            $criteria->condition .= ' AND (qualifications_person.qualification_name like "%' . $keywords . '%" OR qualifications_person.project_name like "%' . $keywords . '%" OR qualifications_person.qualification_type like "%' . $keywords . '%")';
        }
        if ($project_id > 0) {
            $criteria->condition.=' AND t.project_id=' . $project_id;
        }
        if($ser_gf==0){
            parent::_list($model, $criteria, 'servicePerson', $data);
        }
        else{
            parent::_list($model, $criteria, 'servicePerson1', $data);
        }
    }

    //服务者资源管理-选择服务者
    public function actionServerPerson($club_id,$service_type='',$project_id='',$keywords='') {
        $data = array();
        $model = QualificationClub::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.$club_id.' and (state=337 OR state=497)';
        $criteria->condition .= ' and id not in(select person_id from qmdd_server_person qsp where qsp.club_id=t.club_id and qsp.if_del=506 and qsp.is_display=510 and qsp.check_state=2)';
        if(!empty($keywords)){
            $criteria->condition .= ' and exists(select * from qualifications_person q where q.id=t.qualification_person_id and (gfaccount like "%'.$keywords.'%" or qualification_name like "%'.$keywords.'%"))';
        }
        $criteria->condition = get_where($criteria->condition,!empty($service_type),'qualification_type',$service_type,'');
        $criteria->condition = get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $data['club_project_list'] = ClubProject::model()->findAll('club_id='.$club_id.' and project_state=506 and auth_state=461 and state=2 and free_state_Id=1202 and if_del=510');
        parent::_list($model, $criteria, 'serverPerson', $data);
    }

    public function actionUserName($club_id, $project_id = 0, $keywords = '',$code_type='GL') {
        $data = array();
        $model = QualificationClub::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('qualifications_person');
        $w1=get_where('(state=337 OR state=497)',($code_type!=""),'code_type',$code_type,'"');
        $w1=get_where($w1,($club_id>0),'club_id',$club_id,'');
        $s1='qualifications_person.qualification_name,qualifications_person.gfaccount';
        $criteria->condition=get_like($w1,$s1,$keywords,'');//get_where
        $criteria->order = 'gfaccount';
        $criteria->select = 't.id as select_id,';
        $criteria->select .= 'qualifications_person.qualification_name as select_title,';
        $criteria->select .= 'qualifications_person.gfaccount as select_code';
        parent::_list($model, $criteria, 'userName', $data);
    }

    public function actionGameList($keywords = '',$club_id = '') {
        $data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
        $cr='state=2 and dispay_end_time>="'.date("Y-m-d H:i:s").'"';
        $cr=get_where($cr,!empty($club_id),'game_club_id',$club_id,'');
        $cr=get_like($cr,'game_code,game_title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id';
        //$criteria->select = 't.id as select_id,';
        //$criteria->select .= 't.game_title as select_title,';
        //$criteria->select .= 't.game_code as select_code';
        parent::_list($model, $criteria, 'gameList', $data);
    }
    // 选择关联直播赛事
    public function actionVideo_game_list($keywords = '',$club_id = '') {
        $data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
        $cr='state=2 and game_time_end>="'.date("Y-m-d H:i:s").'"';
        $cr=get_where($cr,!empty($club_id),'game_club_id',$club_id,'');
        $cr=get_like($cr,'game_code,game_title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id';
        //$criteria->select = 't.id as select_id,';
        //$criteria->select .= 't.game_title as select_title,';
        //$criteria->select .= 't.game_code as select_code';
        parent::_list($model, $criteria, 'gameList', $data);
    }

	public function actionInsurance_service($keywords = '',$type='') {
        $data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
		if($type==351) {
			$criteria->condition='state=2 AND game_club_id='.get_session('club_id');
			$criteria->condition=get_like($criteria->condition,'game_code,game_title,game_club_name',$keywords,'');//get_where
			$criteria->order = 'id';
			$criteria->select = 't.id as select_id,';
			$criteria->select .= 't.game_title as select_title,';
			$criteria->select .= 't.game_code as select_code';
		}
        parent::_list($model, $criteria, 'Insurance_service', $data);
    }

	public function actionInsurance_servicedata($keywords = '',$type='',$service_id='') {
        $data = array();
        $model = GameListData::model();
        $criteria = new CDbCriteria;
		$criteria->condition='1';
		$criteria->select = 'id as select_id,game_data_name as select_title';
		if($type==351) {
			$criteria->condition.=' AND state=2';
			if($service_id!='') {
				$criteria->condition.=' AND game_id='.$service_id;
			}
			$criteria->condition=get_like($criteria->condition,'game_data_name',$keywords,'');//get_where
		}
        parent::_list($model, $criteria, 'Insurance_servicedata', $data);
    }

    public function actionGameSignList($keywords = '',$game_list_data_id=0,$arr='',$tcode='') {
        $data = array();
        $model = GameSignList::model();
        $criteria = new CDbCriteria;
        $criteria->condition='state=2 AND is_pay=464 AND game_man_type=997 AND pay_confirm=1 AND sign_game_data_id='.$game_list_data_id;
        $criteria->condition=get_like($criteria->condition,'id,code,sign_name,sign_account',$keywords,'');//get_where
        $data['arr'] = $arr;
        $data['tcode'] = $tcode;
        parent::_list($model, $criteria, 'gameSignList', $data, 500);
    }

    public function actionGameTeamTable($keywords = '',$game_list_data_id=0,$arr='',$tcode='') {
        $data = array();
        $model = GameTeamTable::model();
        $criteria = new CDbCriteria;
        $criteria->condition='state=2 AND is_pay=464 AND pay_confirm=1 AND sign_game_data_id='.$game_list_data_id;
        $criteria->condition=get_like($criteria->condition,'name',$keywords,'');
        $data['arr'] = $arr;
        $data['tcode'] = $tcode;
        parent::_list($model, $criteria, 'gameTeamTable', $data, 500);
    }

    public function actionGameListData($keywords = '',$game_id=0,$project_id=0,$id=0,$game_player_team=0,$game_sex=0) {
        $data = array();
        $model = GameListData::model();
        $criteria = new CDbCriteria;
        $criteria->condition='id!='.$id .' AND game_id='.$game_id.' AND if_del=510';
        if($game_sex==205){
            $criteria->condition.=' AND game_sex<>207';
        }
        else if($game_sex==207){
            $criteria->condition.=' AND game_sex<>205';
        }
		$criteria->condition=get_where($criteria->condition,$project_id<>0,'project_id',$project_id,'');
        $criteria->condition=get_like($criteria->condition,'game_item_name,game_player_team_name,game_sex_name,game_age_name',$keywords,'');//get_where
        $criteria->order = 'id';
        $criteria->select = 't.id as select_id,';
        $criteria->select .= 't.game_project_name as select_project,';
        $criteria->select .= 't.game_data_name as select_title,';
        $criteria->select .= 't.game_player_team as select_code,';
        $criteria->select .= 't.game_sex as select_sex,';
        $criteria->select .= 't.game_group_star as select_start,';
        $criteria->select .= 't.game_group_end as select_end';
		parent::_list($model, $criteria, 'gameListData', $data);
    }

    public function actionGameListData_insurance($keywords = '') {
        $data = array();
        $model = MallProducts::model();
        $criteria = new CDbCriteria;
        $criteria->condition='type=153 || type=155';
        $criteria->condition=get_like($criteria->condition,'code,name',$keywords,'');//get_where
        parent::_list($model, $criteria, 'gameListData_insurance', $data);
    }

    public function actionGame_arrange($keywords = '',$game_data_id=0) {
        $data = array();
        $model = GameListArrange::model();
        $criteria = new CDbCriteria;
        $criteria->condition='game_data_id='.$game_data_id.' AND fater_id is null';
        $criteria->condition=get_like($criteria->condition,'rounds,game_data_id',$keywords,'');//get_where
        parent::_list($model, $criteria, 'game_arrange', $data);
    }

    public function actionServicePlace($club_id, $project_id = 0, $keywords = '') {

        $data = array();
        $model = GfSiteProject::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('gf_site', 'project_list');
        $now = date('Y-m-d H:i:s');
        $arrClub = array($club_id);
        $cooperation = CooperationClubList::model()->findAll('club_id=' . $club_id . ' AND (cooperation_state=337 OR cooperation_state=497)');
        foreach ($cooperation as $v) {
            $arrClub[] = $v->invite_club_id;
        }
        $criteria->condition = 'gf_site.gf_site.site_state=2 AND gf_site.site_date_start<"' . $now . '" AND (gf_site.site_date_end>"'.$now.'" or gf_site.site_date_end="0000-00-00 00:00:00" or gf_site.site_date_end="") AND gf_site.user_club_id in (' . implode(',', $arrClub) . ')';
        $criteria->select = '*,gf_site.id as select_id,gf_site.site_name as select_title';
        if ($keywords != '') {
            $criteria->condition .= ' AND (gf_site.site_name like "%' . $keywords . '%" OR project_list.project_name like "%' . $keywords . '%")';
        }

        if ($project_id > 0) {
            $criteria->condition.=' AND t.project_id=' . $project_id;
        }

        parent::_list($model, $criteria, 'servicePlace', $data);
    }

    public function actionGift($base_id = 351, $club_id, $keywords = '') {
//        if (Yii::app()->session['club_id'] != 1) {
//            $club_id = Yii::app()->session['club_id'];
//        }

        $data = array();
        $data['wwwpath'] = '';
        $data['base_id'] = $base_id;

        $base_code = BaseCode::model()->getOne($base_id);
        if ($base_code != null && $base_code->user_table != '') {
            $tableArr = explode(',', $base_code->user_table);
            $modelName = $tableArr[0];
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = '1';
            $criteria->alias = $model->tableSchema->name;
            $selectArr = explode(',', $base_code->user_table_list);
            $whereArr = explode(' ', $base_code->user_table_where);
            // 关联表
            $with = array();

            // 获取关联表的表名
            foreach ($tableArr as $k => $v) {
                if ($k > 0) {
                    $with[] = $v;
                }
            }

            foreach ($selectArr as $v) {
                $arr = explode('.', trim($v));
                if (count($arr) > 1 && $arr[0] != '' && !in_array($arr[0], $with) && $arr[0] != $criteria->alias) {
                    $with[] = $arr[0];
                }
            }

            foreach ($whereArr as $v) {
                $arr = explode('.', trim($v));
                if (count($arr) > 1 && $arr[0] != '' && !in_array($arr[0], $with) && $arr[0] != $criteria->alias) {
                    $with[] = $arr[0];
                }
            }
            // 判断是否存在多表关联
            if (!empty($with)) {
                $criteria->with = $with;
            }
            $arr = array();
            $selectitem = array('select_id', 'select_title', 'select_item1', 'select_item2', 'select_item3');
            foreach ($selectArr as $k => $v) {
                $arr[] = $v . ' as ' . $selectitem[$k];
            }
            $criteria->select = implode(',', $arr);
            if (!empty($base_code->user_table_where)) {
                $criteria->condition.=' AND ' . $base_code->user_table_where;
            }

            if (!empty($keywords)) {
                $criteria->condition.=' AND ' . $selectArr[1] . ' like "%' . $keywords . '%"';
            }

            $criteria->condition = str_replace('[:club_id]', $club_id, $criteria->condition);

            // 查询图片存储路径；
            if (isset($selectArr[2])) {
                $arr = explode('.', $selectArr[2]);
                if (count($arr) > 1) {
                    $base_table = $arr[0];
                    $base_pic = $arr[1];
                } else {
                    $base_table = $criteria->alias;
                    $base_pic = $arr[0];
                }
                $base_path = BasePath::model()->find('F_SCODE="' . $base_table . '" AND F_FIELDNAME like "%' . $base_pic . '%"');
                if ($base_path != null) {
                    $data['wwwpath'] = $base_path->F_WWWPATH;
                }
            }

            if ($base_id == 353) {
                parent::_list($model, $criteria, 'gift_service', $data);
                exit;
            }

            if (in_array($base_id, array(361, 363, 364))) {
                parent::_list($model, $criteria, 'gift_products', $data);
                exit;
            }

            parent::_list($model, $criteria, 'gift', $data);
        } else {
            $nodata = (object) null;
            $nodata->select_id = 0;
            $nodata->select_title = '调用异常';
            $data['arclist'] = array($nodata);
            $data['pages'] = new CPagination(0);
            $this->render('gift', $data);
        }
    }

    public function actionClassify($base_f_id='', $keywords = '') {
        $data = array();
        $model = MallProductsTypeSname::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'id as select_id,sn_name as select_title';
        $criteria->condition=get_where($criteria->condition,!empty($base_f_id),' base_f_id',$base_f_id,'');
        if ($keywords != '') {
            $criteria->condition .= ' AND sn_name like "%' . $keywords . '%"';
        }
/*
        if ($tn_code!='') {
            $lg=strlen($tn_code);
            $lg1=$lg+2;
            $criteria->condition.=' and left(tn_code,'.$lg.')="'.$tn_code.'" and length(tn_code)='.$lg1;
        }
        */
        parent::_list($model, $criteria, 'classify', $data);
    }


	//添加区域
    public function actionArea($keywords = '') {
        $data = array();
        $model = TCountry::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(41,89,120);';
        //$criteria->select = 'id as select_id,country_code_three as select_code,chinese_name as select_title';
		$criteria->condition=get_like($criteria->condition,'english_name,chinese_name',$keywords,'');
        parent::_list($model, $criteria, 'area', $data);
    }
	//申请服务
    public function actionClubStore($keywords = '', $project_id = 0, $type_code=0, $reply=0) {
        $data = array();
        $model = ClubStoreDemand::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 AND service_type=521 AND if_dispay=649';
        $criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($type_code),' type_code',$type_code,'');
        $criteria->condition=get_like($criteria->condition,'service_code,title',$keywords,'');
        $data['type_code'] = MallProductsTypeSname::model()->getCode(173);
        if($reply==0){
            parent::_list($model, $criteria, 'clubStore', $data);
        }
        else{
            parent::_list($model, $criteria, 'club_reply', $data);
        }
    }
    //经营类目
	public function actionCategory($keywords = '',$fid=0) {
        $data = array();
        $model = AutoFilterSet::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1';
        $criteria->select = 'id as select_id,name as select_title';
        if ($keywords != '') {
            $criteria->condition .= ' AND name like "%' . $keywords . '%"';
        }

        if ($fid > 0) {
            $criteria->condition .= ' AND fater_id=' . $fid;
        }
        parent::_list($model, $criteria, 'category', $data);
    }
    //供应商经营类目
	public function actionManage_type($keywords = '') {
        $data = array();
        $model = ClubProductsType::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1';
        if ($keywords != '') {
            $criteria->condition .= ' AND ct_name like "%' . $keywords . '%"';
        }
		$criteria->order = 'ct_code';
        $data = array();
        $data['ctMark'] = ClubProductsType::model()->findAll();
        parent::_list($model, $criteria, 'manage_type', $data,1000);
    }

	//选择物流
	public function actionLogistics($keywords = '') {
        $data = array();
        $model = MallLogistic::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1';
        $criteria->select = 'f_id as select_id,f_code as select_code,f_name as select_title';
        if ($keywords != '') {
            $criteria->condition .= ' AND f_name like "%' . $keywords . '%"';
        }
        parent::_list($model, $criteria, 'logistics', $data);
    }

    //使用类型
	public function actionBaseCode($fid = -1, $keywords = '') {
        $data = array();
        $model = BaseCode::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'f_id as select_id,F_NAME as select_title';
        if ($keywords != '') {
            $criteria->condition .= ' AND F_NAME like "%' . $keywords . '%"';
        }
        if ($fid > 0) {
            $criteria->condition .= ' AND fater_id=' . $fid;
        }
        parent::_list($model, $criteria, 'basecode', $data);
    }
    //使用类型
	public function actionGfHealthyModel($keywords = '') {
        $data = array();
        $model = GfHealthyModel::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'id as select_id,attr_name as select_title';
        $criteria->condition=get_like($criteria->condition,'attr_name,attr_input_type,attr_unit,attr_values',$keywords,'');//get_where
        // if ($keywords != '') {
        //     $criteria->condition .= ' AND attr_name like "%' . $keywords . '%"';
        // }
        parent::_list($model, $criteria, 'gfHealthyModel', $data);
    }

    public function actionMapArea($address='',$city='',$district='',$lng='',$lat='') { 
        $data = array();
        $data['address'] = $address;
        $data['city'] = $city;
        $data['district'] = $district;
        $data['lng'] = $lng;
        $data['lat'] = $lat;
        $this->render('mapArea', $data);
    }

    public function actionMaterial($type = '',$club_id=0, $keywords = '') {
        // 252图片 253视频 254音频
        // if (!in_array($type, array(252, 253, 254))) {
            // exit('无效类型');
        // }

        $data = array();
        $model = GfMaterial::model();
        $criteria = new CDbCriteria;
		$criteria->condition = ($club_id==0) ? '1' : 'club_id='.$club_id;
        $criteria->condition.=' AND v_name <> ""';
        $criteria->select = '*,id as select_id,v_title as select_title,v_name as select_code';

        if ($type != '') {
            $criteria->condition .= ' AND v_type in ('.$type.')';
        }

        if ($keywords != '') {
            $criteria->condition .= ' AND v_title like "%' . $keywords . '%"';
        }

        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'material', $data, 10);
    }

	public function actionMaterialPicture($group_id = 0,$type = '', $keywords = '') {
        // 252图片 253视频 254音频
        if (!in_array($type, array(252, 253, 254))) {
            exit('无效类型');
        }
        $data = array();
        $model = GfMaterial::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = '*,id as select_id,v_title as select_title,v_name as select_code';

        $criteria->condition.=' AND club_id=' . Yii::app()->session['club_id'];

        if ($type != '') {
            $criteria->condition .= ' AND v_type=' . $type;
        }

        if ($keywords != '' and $keywords!='请输入标题关键字搜索') {
            $criteria->condition .= ' AND v_title like "%' . $keywords . '%"';
        }

        if ($group_id == -1) {
            $criteria->condition.=' AND (group_id is null OR group_id="" OR group_id=0)';
        } else if ($group_id != 0) {
            $criteria->condition.=' AND group_id=' . $group_id;
        }

        $criteria->order = 'id DESC';

        $data = array();
        $data['material_group'] = GfMaterialGroup::model()->findAll();
        $data['all_num'] = $model->count('v_type=252');
        $data['nogroup_num'] = $model->count('v_type=252 AND (group_id is null OR group_id="" OR group_id=0)');
        $data['group_id'] = $group_id;

        parent::_list($model, $criteria, 'materialPicture', $data,$pageSize = 10);
    }

    public function actionVideoBelong($type = '', $keywords = '') {
        // 705赛事直播 706社区直播 723培训直播
        $data = array();
        $modelName = array(705 => 'GameList', 706 => 'ClubList', 723 => 'ClubStoreTrain');
        if (!isset($modelName[$type])) {
            exit('无效类型');
        }
        $model = $modelName[$type]::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';

        switch ($type) {
            case 705:
                $criteria->select = '*,id as select_id,game_title as select_title';
                $criteria->condition .= ' AND state=2 AND if_del=510';
                if ($keywords != '') {
                    $criteria->condition=get_like($criteria->condition,'game_title,game_code',$keywords,'');
                }
                break;
            case 706:
                $criteria->select = '*,id as select_id,club_name as select_title';
                $criteria->condition .= ' AND state=2 AND if_del=510';
                if ($keywords != '') {
                    $criteria->condition=get_like($criteria->condition,'club_name,club_code',$keywords,'');
                }
                break;
            case 723:
                $criteria->select = '*,id as select_id,train_title as select_title';
                $criteria->condition .= ' AND train_state=2 AND if_del=0';
                if ($keywords != '') {
                    $criteria->condition=get_like($criteria->condition,'train_title,train_code',$keywords,'');
                }
                break;
            default :
                break;
        }

        $criteria->order = 'id ASC';

        parent::_list($model, $criteria, 'videoBelong', $data);
    }

    public function actionWatermark($keywords = '') {
        $data = array();
        $model = GfWatermark::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'id as select_id,w_title as select_title';

        if ($keywords != '') {
            $criteria->condition .= ' AND w_title like "%' . $keywords . '%';
        }

        $criteria->order = 'id DESC';

        parent::_list($model, $criteria, 'watermark', $data);
    }

    // 下架商品
    public function actionMallPricingDetails($keywords = '',$club_id=0) {
        $data = array();
        $model = MallPriceSetDetails::model();
        $criteria = new CDbCriteria;
        $now = date('Y-m-d H:i:s');
        $up_quantity='Inventory_quantity-sale_order_data_quantity';
        $criteria->condition = "(Inventory_quantity>sale_order_data_quantity or sale_order_data_quantity is null)";//." AND down_time is not null";  // .' AND up_quantity='.$up_quantity;
        $criteria->condition .=' AND f_check=2'.' AND pricing_type=361'.' AND purpose not in(0,95,719)'.' AND down_pricing_set_id=0'.' AND supplier_id='.$club_id;
        $criteria->condition=get_like($criteria->condition,'product_name,event_name',$keywords,'');
        parent::_list($model, $criteria, 'mallPricingDetails', $data);
    }

    // 服务方案
    public function actionQmddServiceTime($keywords = '',$membertype = 0){
        $data = array();
        $model = MemberCard::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'mamber_type='.$membertype;
        $criteria->condition = get_like($criteria->condition,'card_name',$keywords,'');
        parent::_list($model, $criteria, 'qmddServiceTime', $data);
    }

    // 会员收费项目设置绑定商品
    public function actionMemberFee($keywords = '') {
        $data = array();
        $model = MallProducts::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'IS_DELETE=510 AND type_fater in(351,352,353,354,355,356,357,359,777,1424)';
        if($_SERVER['SERVER_NAME']==wwwsportnet()){
            $criteria->condition .= ' AND supplier_id=2911';//内网
        }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
            $criteria->condition .= ' AND supplier_id=2498';//公网
        }else if($_SERVER['SERVER_NAME']=='oss.gfinter.net'){
            $criteria->condition .= ' AND supplier_id=2493';//公测
        }
        $criteria->condition=get_like($criteria->condition,'name,code',$keywords,'');
        parent::_list($model, $criteria, 'memberfee', $data);
    }

    // 服务名称
    public function actionServerName($keywords = '',$club_id,$t_typeid='') {
        $data = array();
        $model = QmddServerSetData::model();
        $criteria = new CDbCriteria;
		$criteria->condition = get_where_club_project('club_id').' and t_typeid='.$t_typeid.' and f_check=2';
        $criteria->condition = get_like($criteria->condition,'s_name',$keywords,'');
        $criteria->group = 's_name';
        parent::_list($model, $criteria, 'servername', $data);
    }

    // 选择收费项目
    public function actionClubMembershipFee($keywords = ''){
        $data = array();
        $model = ClubMembershipFee::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1';
        $criteria->condition = get_like($criteria->condition,'',$keywords,'');
        parent::_list($model,$criteria,'clubMembershipFee',$data);
    }

    // 选择服务费用方案
    public function actionClubMembershipFeeScaleInfo($keywords = '',$levetypeid){
        $data = array();
        $model = ClubMembershipFeeScaleInfo::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'expiry_date_end>"'.date('Y-m-d H:i:s').'" AND levetypeid='.$levetypeid;
        $criteria->condition = get_like($criteria->condition,'',$keywords,'');
        parent::_list($model,$criteria,'clubMembershipFeeScaleInfo',$data);
    }

    // 选择竞赛项目
    public function actionGameListDataFee($keywords='',$game='',$game_list_id=''){
        $data = array();
        $model = GameListData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'exists(select * from game_list where id=t.game_id)';
        $criteria->condition = get_where($criteria->condition,!empty($game),'game_id',$game,'');
        // $criteria->condition = get_where($criteria->condition,!empty($game_list_id),'game_id',$game_list_id,'');
        $criteria->condition = get_like($criteria->condition,'t.game_data_name',$keywords,'');
        // $data['game_list_id'] = GameList::model()->findAll('game_club_id='.get_session('club_id'));
        parent::_list($model,$criteria,'gameListDataFee',$data);
    }

    // 退货收货员
    public function actionQmddAdministrators($keywords='',$club_id=''){
        $data = array();
        $model = QmddAdministrators::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.$club_id.' and if_del=510';
        $criteria->condition = get_like($criteria->condition,'admin_gfaccount,admin_gfnick',$keywords,'');
        parent::_list($model,$criteria,'qmddAdministrators',$data);
    }


    // 战略伙伴成员入会选择收费项目
    public function actionIf_items($keywords = '',$set_id = ''){
        $data = array();
        $model = GfPartnerMemberValues::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'isNull(set_input_id) and set_id='.$set_id;
        $criteria->condition = get_like($criteria->condition,'',$keywords,'');
        parent::_list($model,$criteria,'if_items',$data);
    }

    // 直播打赏申请选择图片
    public function actionRewardPictures($interact_type='',$gift_type=''){
        $data = array();
        $model = RewardName::model();
        $criteria = new CDbCriteria;
        $interact_type = (empty($interact_type)) ? 0 : $interact_type;
        $gift_type = (empty($gift_type)) ? 0 : $gift_type;
        $criteria->condition = 'interact_type='.$interact_type.' and gift_type='.$gift_type;
        // $criteria->condition = get_where($criteria->condition,$interact_type,'interact_type',$interact_type,'');
        // $criteria->condition = get_where($criteria->condition,$gift_type,'gift_type',$gift_type,'');
        // $criteria->condition = get_like($criteria->condition,'reward_code,reward_name',$keywords,'');
        $criteria->order = 'reward_code';
        $data['interact_type'] = BaseCode::model()->getCode(1393);
        parent::_list($model,$criteria,'rewardPictures',$data);
    }

    // 直播打赏申请选择图片类型
    public function actionRewardPicturesGift($id){
        $arr = array();
        if(!empty($id)){
            $data = GiftType::model()->findAll('interact_type='.$id);
            if(!empty($data))foreach($data as $key => $val){
                $arr[$key]['id'] = $val->id;
                $arr[$key]['name'] = $val->name;
            }
        }
        echo CJSON::encode($arr);
    }

    // 虚拟商品设置
    public function actionVirtualDetail($keywords=''){
        $data = array();
        $model = MallProducts::model();
        $criteria = new CDbCriteria;
        // 8/26修改：废弃虚拟类：type_fater=364
        $criteria->condition = 'type_fater=1424 and IS_DELETE=510';
        $criteria->condition = get_like($criteria->condition,'code,name',$keywords,'');
        parent::_list($model,$criteria,'virtualDetail',$data);
    }

    // 虚拟商品上架
    public function actionVirtualMallPricingDetails($keywords=''){
        $data = array();
        $model = VirtualMallProducts::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'IS_DELETE=510';
        $criteria->condition = get_like($criteria->condition,'code,product_name',$keywords,'');
        parent::_list($model,$criteria,'virtualMallPricingDetails',$data);
    }

    // 选择虚拟充值商品
    public function actionVirtualMallPriceSetDetails($keywords='',$set_id=''){
        $data = array();
        $model = VirtualMallPriceSetDetails::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'end_time>now() and Inventory_quantity>0 and exists(select * from virtual_mall_price_set v where v.id=t.set_id and is_user=649 and if_del=648)';
        if(!empty($set_id)){
            $criteria->condition .= ' and set_id='.$set_id;
        }
        $criteria->condition = get_like($criteria->condition,'product_code,product_name',$keywords,'');
        $data['set_id'] = VirtualMallPriceSet::model()->findAll('is_user=649 and if_del=648 and end_time>now() and f_check=2');
        parent::_list($model,$criteria,'virtualMallPriceSetDetails',$data);
    }







	/*********前端接口*********/

	//测试
    public function actionTest() {
      //  $_SESSION['admin_user_id']='481';
        $cooperation=BaseCode::model()->getClub_type2_all();
        echo '{data:'.json_encode(toArray($cooperation,'f_id,F_NAME,fater_id')).'}';
    }
	//获取用户约起列表
    public function actionGetServiceDemandList($gfid=0) {
        $_SESSION['admin_user_id']='481';
		$list=ClubServiceData::model()->findAll("service_type=520 AND detail_gfid={$gfid}");
        echo json_encode(toArray($list,'id,service_code,title,type_name,project_name,data_id,data_name,budget_amount,uDate'));
    }
	//获取动动约类型列表
    public function actionGetServiceTypeList() {
     //   $_SESSION['admin_user_id']='481';
		$list=QmddServerType::model()->findAll("if_user=649");
        echo json_encode(toArray($list,'id,t_code,t_name'));
    }
	//获取动动约类型列表
    public function actionGetServiceUserTypeList($type="") {
      //  $_SESSION['admin_user_id']='481';
		$where="if_del=510";
		$list=QmddServerUsertype::model()->findAll($where);
        echo json_encode(toArray($list,'id,f_ucode,f_uname'));
    }
	//选择客服业务类型
    public function actionProblem_type() {
		$data = array();
        $model = GfCustomerProblemType::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'fater_id is null';
        parent::_list($model, $criteria, 'problem_type', $data,100);
    }
	//选择单位客服业务类型
    public function actionClub_problem_type($type_1="",$type_2="") {
		$data = array();
        $model = GfCustomerProblemType::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 't.fater_id is null and FIND_IN_SET(t.id,gf_customer_type_set.problem_type) and gf_customer_type_set.type_1='.$type_1.' and gf_customer_type_set.type_2='.$type_2;
        $criteria->join = 'join gf_customer_type_set';
        parent::_list($model, $criteria, 'club_problem_type', $data,100);
    }

}
