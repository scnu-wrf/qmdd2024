<?php

class ClubProjectController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$club_id=0,$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id','');
        $criteria->condition .= ' and state=2 and auth_state=461 and if_del=510';
        
        $criteria->condition=get_where($criteria->condition,!empty($state),' state',$state,'');
        $criteria->condition=get_like($criteria->condition,'project_name,club_name',$keywords,'');//get_where
        $criteria->order = 'entry_validity DESC';
		$data = array();
		$data['base_code'] = BaseCode::model()->getCode(370);
        parent::_list($model, $criteria, 'index', $data);
    }
	
	public function actionIndex_club($keywords = '',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.get_session('club_id').' and if_del=510';
		$criteria->condition=get_where($criteria->condition,!empty($state),' state',$state,'');
        $criteria->condition=get_like($criteria->condition,'project_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
		$data = array();
		$data['base_code'] = BaseCode::model()->getCode(370);
        parent::_list($model, $criteria, 'index_club', $data);
    }

	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_pics'] = array();
            $this->render('update_unit', $data);
          } else {
                 $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_pics'] = explode(',', $model->qualification_pics);
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post,$zeon=0) {
        $model->check_save(1);
        $model->attributes = $post;
        $model->state = get_check_code($_POST['submitType']);
        $url = get_cookie('_currentUrl_');
        if ($_POST['submitType'] == 'yaoqing') {
            $yes='邀请成功';
            $no='邀请失败';
        }elseif ($_POST['submitType'] == 'shenhe') {
            $yes='提交成功';
            $no='提交失败';
        }elseif ($_POST['submitType'] == 'tongguo'||$_POST['submitType'] == 'butongguo') {
            $yes='操作成功';
            $no='操作失败';
            $model->audit_time = date('Y-m-d H:i:s');
            $model->audit_adminid = get_session('admin_id');
            $model->audit_adminname = get_session('admin_name');
        }else{
            $yes='保存成功';
            $no='保存失败';
        }
        if($model->state==2){
            $model->auth_state = 460;
        }
        if($model->state==373){
            $model->auth_state = 457;
        }

        if($model->state==371){
            $model->add_time= date('Y-m-d H:i:s');
            if(get_session('club_type')==8){
                if(!empty($model->project_id)){
                    $server=ClubServicerType::model()->findAll('is_club_qualification=1');
                    $nt='';
                    foreach($server as $b){
                        $ps=ProjectSerivce::model()->find('project_id='.$model->project_id.' and qualification_type_id='.$b->member_second_id);
                        $cs=QualificationClub::model()->count("club_id=".$model->club_id." and project_id=".$model->project_id.' and qualification_type='.$b->member_second_id.' and state=337');
                        if($cs<$ps->min_count){
                            $nt.=$b->member_second_name.'、';
                        }
                    }
                    if($nt==''){
                        $st=$model->save();
                    }else{
                        $st=0;
                        $no='至少邀请符合项目的'.rtrim($nt, '、').'各一名，才可提交审核';
                    }
                }else{
                    $st=$model->save();
                }
            }else{
                $st=$model->save();
            }
        }else{
            $st=$model->save();
        }

        if ($_POST['submitType'] == 'yaoqing') {
            $url = $this->createUrl('update_unit', array('id'=>$model->id,'index'=>3));
        }
        if($st==1){
            $this->save_examine($model,$post);
        }
        show_status($st,$yes, $url,$no);
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    /**
     * 单位项目待审核列表
     */
    public function actionIndex_examine($keywords = '',$state='',$project_state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=371 and club_type=8 and if_del=510';  //  and club_id='.get_session('club_id')
        $criteria->condition = get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition = get_where($criteria->condition,!empty($project_state),'project_state',$project_state,'');
        $criteria->condition = get_like($criteria->condition,'project_name,club_name',$keywords,'');
        $criteria->order = 'add_time DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
        $data['project_state'] = BaseCode::model()->getCode(505);
        parent::_list($model, $criteria, 'index_examine', $data);
    }

    /**
     * 待审核界面
     */
    public function actionUpdate_examine($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_pics'] = explode(',', $model->qualification_pics);
            $this->render('update_examine', $data);
        } else {
            $zeon=1;
            $this->saveData($model,$_POST[$modelName],$zeon);
        }
    }

    /**
     * 保存星级
     */
    public function save_examine($model,$post){
        $sv = 0;
        if(!empty($model->project_credit)){
            $old = ServicerLevel::model()->find('member_second_id='.$model->partnership_type.' and card_score<='.$model->project_credit.' and card_end_score>='.$model->project_credit.' and entry_way='.$model->approve_state);
            if(!empty($old)){
                $model->project_level = $old->id;
            }
            $sv=$model->save();
        }
        // $ship_fee = ClubMembershipFee::model()->find('code="TS15"');
        // $ship_info = ClubMembershipFeeScaleInfo::model()->find('club_id='.get_session('club_id').' and levetypeid=502 order by use_default DESC');
        // if(!empty($ship_fee) && !empty($ship_info) && $sv==1){
        //     $fee_data = ClubMembershipFeeData::model()->find('levelid='.$model->project_level.' and product_id='.$ship_fee->product_id.' and scale_info_id='.$ship_info->id);
        //     if(!empty($fee_data)){
        //         $model->cost_admission = $fee_data->scale_amount;
        //         $model->cost_account = $fee_data->scale_amount;
        //         $model->save();
        //     }
        // }
    }

    /**
     * 设置使用的方案
     */
    public function actionScaleInfo($id,$par,$check_all){
        $modelName = $this->model;
        $count = explode(',',$id);
        $fee_info = ClubMembershipFeeScaleInfo::model()->find('id='.$par);
        $info = '操作失败';
        if($check_all==0){
            foreach($count as $d){
                $model = $this->loadModel($d,$modelName);
                if(!empty($fee_info->id)){
                    $data_info = ClubMembershipFeeData::model()->find('scale_info_id='.$fee_info->id.' and entry_way='.$model->approve_state.' and member_type='.$model->partnership_type.' and levelid='.$model->project_level);
                    if(!empty($data_info)){
                        $cp=ClubProject::model()->find('id='.$d.' and cost_admission='.$data_info->scale_amount.' and pay_blueprint='.$fee_info->id);
                        if(empty($cp)){
                            $sv=ClubProject::model()->updateByPk($d, array('cost_admission' => $data_info->scale_amount,'cost_account'=>$data_info->scale_amount,'pay_blueprint'=>$fee_info->id,'pay_blueprint_name'=>$fee_info->name));
                        }else{
                            $sv=1;
                        }
                    }else{
                        $sv=0;
                        $info='发送失败，未设置费用明细';
                    }
                    $fee_info->use_default = 1;
                    $fee_info->save();
                }
            }
        }
        // else{
        //     $model = QualificationsPerson::model()->findAll('check_state=2 and uDate>="'.$time_start.'" and uDate<="'.$time_end.'" and free_state_Id=1200');
        //     if(!empty($model))foreach($model as $v){
        //         if(!empty($fee_info)){
        //             if(!empty($v->project_level)){
        //                 $data_info = ClubMembershipFeeData::model()->find('scale_info_id='.$fee_info->id.' and levelid='.$v->project_level);
        //             }
        //             if(!empty($data_info)){
        //                 $v->cost_admission = $data_info->scale_amount;
        //                 $sv=$v->save();
        //             }
        //             $fee_info->use_default = 1;
        //             $fee_info->save();
        //         }
        //     }
        //     else{
        //         $sv = 0;
        //         $info = '无数据，操作失败';
        //     }
        // }
        $fee_info2 = ClubMembershipFeeScaleInfo::model()->findAll('id<>'.$par.' and club_id='.get_session('club_id'));
        foreach($fee_info2 as $fo2){
            $fo2->use_default = 0;
            $fo2->save();
        }
        if($sv==0){
            show_status($sv,'发送成功',Yii::app()->request->urlReferrer,$info);
        }
    }

    public function actionScales($info_id){
        $data = ClubMembershipFeeData::model()->findAll(
            array(
                'select'=>array('id','scale_info_id','levelid','levelname','scale_amount,member_type,member_name'),
                'order'=>'levelid',
                'condition'=>'scale_info_id='.$info_id
            )
        );
        if(!empty($data)){
            echo CJSON::encode($data);
        }
    }

    /**
     * 服务机构待确认列表
     */
    public function actionIndex_confirmed($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $criteria->with = array('club_list','mall_data_num','fee_order_num');
		$criteria->condition = 'free_state_Id in(1201,1202) and if_del=510';  //   AND t.club_id='.get_session('club_id');'t.state=2 and (t.cost_oper="" or t.cost_oper is null) and t.club_type=8';
        // $criteria->condition .= ' AND (mall_data_num.order_num=t.order_num OR fee_order_num.order_num=t.order_num OR fee_order_num.club_project_id=t.id)';  // AND club_list.club_type in(8,9,380) 
        // $criteria->condition .= ' AND (exists(SELECT * FROM mall_sales_order_data WHERE mall_sales_order_data.order_num=t.order_num)';
        // $criteria->condition .= ' OR exists(SELECT * FROM club_membership_fee_data_list WHERE club_membership_fee_data_list.order_num=t.order_num OR club_membership_fee_data_list.club_project_id=t.id))';
        $criteria->condition = get_like($criteria->condition,'t.project_name,t.order_num',$keywords,'');//get_where
        $criteria->order = 'add_time DESC';
		$data = array();
        parent::_list($model, $criteria, 'index_confirmed', $data);
    }

    /**
     * 超时未支付列表
     */
    public function actionIndex_overtime($keywords = '',$project='',$time_start='',$time_end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->updateAll(array('auth_state'=>457,'state'=>721,'free_state_Id'=>1400),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id','');
        $criteria->condition .= ' and free_state_Id=1400 and if_del=510'; 
        $time_start=$time_start=='' ? date("Y-m-d") : $time_start;
        $time_end=$time_end=='' ? date("Y-m-d") : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(cut_date,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(cut_date,10)<="'.$time_end.'"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_like($criteria->condition,'project_name,club_name',$keywords,'');
        $criteria->order = 'cut_date DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['project'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_overtime', $data);
    }
    public function actionUpdate_unpaid($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_pics'] = explode(',', $model->qualification_pics);
            $this->render('update_unpaid', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    /**
     * 战略伙伴待审核列表
     */
    public function actionIndex_strat($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=371 and club_type=189 and if_del=510';
        $criteria->condition = get_like($criteria->condition,'project_name,club_name',$keywords,'');
        $criteria->order = 'add_time DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_strat', $data);
    }

    /**
     * 待缴费列表
     */
    public function actionIndex_strat_pay($keywords = '',$project='',$pay_blueprint='',$time_start='',$time_end='',$free_state_Id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $model->updateAll(array('auth_state'=>457,'state'=>721,'free_state_Id'=>1400),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');

        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and if_del=510'; 
        if($free_state_Id==''){
            $criteria->condition .= ' and free_state_Id in(1195,1201,1400)'; 
        }else{
            $criteria->condition .= ' and free_state_Id='.$free_state_Id; 
        }

        // $criteria->condition .= ' AND not exists(select * from club_membership_fee_data_list where club_membership_fee_data_list.club_project_id=t.id)';
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($pay_blueprint),'pay_blueprint',$pay_blueprint,'');
        if ($time_start != '') {
            $criteria->condition.=' AND left(send_date,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(send_date,10)<="'.$time_end.'"';
        }
        $criteria->condition = get_like($criteria->condition,'p_code,club_name,project_name',$keywords,'');
        if($free_state_Id==''){
            $criteria->order = 'send_date DESC';
        }else{
            $criteria->order = 'uDate DESC';
        }
        $data = array();
        $data['count1'] = $model->count('state=2 and free_state_Id=1200');
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['project'] = ProjectList::model()->getProject();
        $data['paymen_state'] = BaseCode::model()->getCode(1194);
        $data['fee_list'] = ClubMembershipFeeScaleInfo::model()->findAll('fee_code="TS15" and club_id='.get_session('club_id'));
        $data['approve_state'] = BaseCode::model()->getCode(452);
        
        parent::_list($model, $criteria, 'index_strat_pay', $data);
    }

    /**
     * 单位项目待确认列表
     */
    public function actionIndex_strat_confirmed($keywords = '',$free_state_Id='',$time_start='',$time_end='',$project='',$pay_blueprint='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and if_del=510'; 
        if($free_state_Id==''){
            $criteria->condition .= ' and free_state_Id=1202'; 
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }else{
            $criteria->condition .= ' and free_state_Id='.$free_state_Id; 
        }
        if ($time_start != '') {
            $criteria->condition.=' AND left(effective_date,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(effective_date,10)<="'.$time_end.'"';
        }
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($pay_blueprint),'pay_blueprint',$pay_blueprint,'');
        // $criteria->condition .= ' and (cost_oper="" or cost_oper is null)';  
        // $criteria->condition .= ' AND not exists(select * from club_membership_fee_data_list where club_membership_fee_data_list.club_project_id=t.id)';
        $criteria->condition = get_like($criteria->condition,'project_name,club_name',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['count1'] = $model->count('state=2 and free_state_Id=1201');
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['project'] = ProjectList::model()->getProject();
        $data['fee_list'] = ClubMembershipFeeScaleInfo::model()->findAll('levetypeid=502');
        parent::_list($model, $criteria, 'index_strat_confirmed', $data);
    }

    /**
     * 服务机构入驻费列表.
     */
    public function actionIndex_ad_fee($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ClubMembershipFeeDataList::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('club_projectid');
        $criteria->condition = 'fee_type=404';
        $criteria->condition = get_like($criteria->condition,'t.order_num,t.club_name',$keywords,'');
        $data = array();
        parent::_list($model, $criteria, 'index_ad_fee', $data, 30);
    }

    /**
     * 每日会员缴费明细表-单位.
     */
    public function actionIndex_day($time_start='',$time_end='', $type='', $keywords = '',$project='',$f_userdate='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ClubMembershipFeeDataList::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('club_projectid');
        $criteria->condition = get_where_club_project('club_id','').' and club_project_id>0';
        $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
        $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(f_userdate,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(f_userdate,10)<="'.$time_end.'"';
        }
        $criteria->join = "JOIN club_list t2 on t.club_id=t2.id";
        if($type!=''){
            $criteria->condition = get_where($criteria->condition,!empty($type),'t2.club_type',$type,'');
        }
        
        $criteria->condition=get_where($criteria->condition,!empty($project),'t.project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($f_userdate),'left(f_userdate,10)',$f_userdate,'"');
        $criteria->condition = get_like($criteria->condition,'t.order_num,t.club_name,t2.club_code,t.project_name',$keywords,'');
        $criteria->order = 'f_userdate DESC';
        $data = array();
        $data['project'] = ProjectList::model()->getProject();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['base_code'] = BaseCode::model()->getReturn('8,9,189,380,1086');
        parent::_list($model, $criteria, 'index_day', $data, 30);
    }

    /**
     * 免费/有偿操作.
     */
    public function actionWhole($id) {
        $this->actionSend($id);
    }

    /**
     * 免费/有偿的执行actionSend这个方法，免单的直接进入club_membership_fee_data_list表，不存进购物车表，执行actionFree这个方法.
     * 免费/有偿的首先查找club_membership_fee这个表的入驻商品编号，然后存商品编号进入购物车表.
     * 
     * 通知缴费操作会保存一条信息到购物车列表.
     * 缴费后确认缴费操作回填一条到club_membership_fee_data_list表.
     * 
     * 通知缴费操作.
     * 分别存购物车账单表和购物车详细表.
     */
    public function actionSend($id) {
        $count = explode(',',$id);
        $al='';
        $freeId='';
        foreach($count as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $base_code = BaseCode::model()->find('f_id=355');
            $list = Carinfo::model()->find('order_num="'.$model->order_num.'"');
            if(!empty($list)){
                // continue;
                ajax_status(0,'账号：'.$model->p_code.'已通知，请选择未通知信息');
                break;
            }
            // $ship_fee = ClubMembershipFee::model()->find('code="TS15"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('club_id='.get_session('club_id').' and id='.$model->pay_blueprint);
            if(!empty($ship_info)){
                $fee_data = ClubMembershipFeeData::model()->find('gf_club_id='.get_session('club_id').' and levelid='.$model->project_level.' and product_id='.$ship_info->product_id.' and entry_way='.$model->approve_state.' and member_type='.$model->partnership_type.' and scale_info_id='.$model->pay_blueprint);
            }
            // 如果$fee_data不等于空并且$fee_data->scale_amount大于0，就执行保存到购物车，否则保存到会员明细表
            if(empty($fee_data->id)){
                $sf=0;
                $al='，未设置费用明细';
            }elseif($fee_data->scale_amount>0){
                // 购物车账单
                $order_data=array('order_type'=>355
		        	,'buyer_type'=>502
			        ,'order_gfid'=>$model->club_id
			        ,'money'=>$fee_data->scale_amount
			        ,'order_money'=>$fee_data->scale_amount
			        ,'total_money'=>$fee_data->scale_amount
			        ,'effective_time'=>date('Y-m-d H:i:s',strtotime('+3 day')));
				$add_order=Carinfo::model()->addOrder($order_data);
				if(empty($add_order['order_num'])){
					$sv=0;
				}else{
					$sv=1;
					// 购物车详细
	                $cat_copy = new CardataCopy();
	                $cat_copy->isNewRecord = true;
	                unset($cat_copy->id);
	                $cat_copy->order_num = $add_order['order_num'];
	                $cat_copy->order_type = 355;
	                $cat_copy->order_type_name = $base_code->F_NAME;
	                $cat_copy->product_id = $fee_data->product_id;
	                $cat_copy->product_code = $fee_data->product_code;
	                $cat_copy->product_title = $fee_data->product_name;
	                $cat_copy->product_data_id = $fee_data->product_id;
	                $cat_copy->json_attr = $fee_data->json_attr;
	                $cat_copy->supplier_id = $fee_data->gf_club_id;
	                $club=ClubList::model()->find('id='.$fee_data->gf_club_id);
	                if(!empty($club)){
	                    $cat_copy->supplier_name = $club->club_name;
	                }
	                $cat_copy->buy_price = $fee_data->scale_amount;
	                $cat_copy->buy_amount = $fee_data->scale_amount;
	                $cat_copy->project_id = $model->project_id;
	                $cat_copy->project_name = $model->project_name;
	                $cat_copy->buy_level = $model->project_level;
	                $cat_copy->buy_level_name = $model->level_name;
	                $cat_copy->buy_count = 1;
	                $cat_copy->total_pay = $fee_data->scale_amount;
	                $cat_copy->gfid = $model->club_id;
	                $cat_copy->gf_name = $model->club_name;
	                $cat_copy->uDate = date('Y-m-d H:i:s');
	                $cat_copy->gf_club_id = get_session('club_id');
	                $cat_copy->effective_time = date('Y-m-d H:i:s',strtotime('+3 day'));
	                $st=$cat_copy->save();
				}
        
                if($sv==1 && $st==1){
                    $model->auth_state = 460;
                    // $model->cost_admission = $fee_data->scale_amount;
                    $model->order_num = $add_order['order_num'];
                    $model->send_adminid = get_session('admin_id');
                    $model->send_adminname = get_session('admin_name');
                    $model->uDate = date('Y-m-d H:i:s');
                    $model->send_oper = get_session('admin_name');
                    $model->send_date = date('Y-m-d H:i:s');
                    $model->cut_date = date('Y-m-d H:i:s', strtotime('3 days'));
                    $model->free_state_Id = 1195;
                    $bs = BaseCode::model()->find('f_id='.$model->free_state_Id);
                    $model->free_state_name = $bs->F_NAME;
                    $model->pay_way = 12;
                    $bs = BaseCode::model()->find('f_id='.$model->pay_way);
                    $model->pay_way_name = $bs->F_NAME;
                    $sd=$model->save();
                }
                if($sv==1 && $st==1  && $sd==1){
                    $sf=1;

                    if($sf==1){
                        // 通知
                        $r_admin=QmddAdministrators::model()->find('club_code='.$model->p_code);
                        $m_message='您入驻的"'.$model->project_name.'"已选择“'.$model->approve_state_name.'”方式，请及时完成支付，支付确认成功后，即项目入驻完成。';
                        $basepath=BasePath::model()->getPath(191); 
                        $club=ClubList::model()->find("id=".get_session('club_id'));
                        $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                        $title='项目缴费通知';
                        $content='您入驻的'.$model->project_name.'已选择“'.$model->approve_state_name.'”方式...';
                        $url='';
                        $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>5);
                        backstage_send_message(get_session('admin_id'),$model->p_code,$m_message,$title,315,'B'.$model->p_code,$sendArr);
                    }
                }else{
                    $sf=0;
                }
            }elseif($fee_data->scale_amount<=0){
                $freeId.=$d.',';
            }
        }
        if($freeId!=''){
            $this->actionFree( rtrim($freeId, ','),1373);
        }
        show_status($sf,'发送成功',Yii::app()->request->urlReferrer,'发送失败'.$al);
    }

    /**
     * 免单入驻,直接存进club_membership_fee_data_list表.
     * 不生成订单号和金额
     */
    public function actionFree($id,$pay_way='') {
        $modelName = $this->model;
        $len = explode(',',$id);
        foreach($len as $v){
            $model = $this->loadModel($v,$modelName);
            $ship_fee = ClubMembershipFee::model()->find('code="TS15"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('id='.$model->pay_blueprint);
            if(!empty($ship_fee)){
                $model->project_level = empty($model->project_level) ? '0' : $model->project_level;
                $fee_data = ClubMembershipFeeData::model()->find('gf_club_id='.get_session('club_id').' and levelid='.$model->project_level.' and product_id='.$ship_fee->product_id.' and scale_info_id='.$ship_info->id);
            }
            $fee_list = new ClubMembershipFeeDataList;
            $fee_list->isNewRecord = true;
            unset($fee_list->id);
            if(!empty($fee_data)){
                $fee_list->scale_info_id = $fee_data->scale_info_id;
                $fee_list->scale_list_Id = $fee_data->scale_list_Id;
                $fee_list->scale_data_id = $fee_data->id;
                $fee_list->scale_code = $fee_data->scale_code;
                $fee_list->feeid = $fee_data->feeid;
                $fee_list->code = $fee_data->code;
                $fee_list->name = $fee_data->name;
                $fee_list->levetypeid = $fee_data->levetypeid;
                $fee_list->product_id = $fee_data->product_id;
                $fee_list->product_code = $fee_data->product_code;
                $fee_list->product_name = $fee_data->product_name;
                $fee_list->json_attr = $fee_data->json_attr;
                $fee_list->scale_amount = $fee_data->scale_amount;
                $fee_list->fee_type = 404;
                $fee_list->club_id = $model->club_id;
                $fee_list->club_name = $model->club_name;
                $fee_list->project_id = $model->project_id;
                $fee_list->project_name = $model->project_name;
                $fee_list->levelid = $model->project_level;
                $fee_list->levelname = $model->level_name;
                $fee_list->f_username = get_session('admin_name');
                $fee_list->f_userdate = date('Y-m-d H:i:s');
                $fee_list->f_freemark = 0;  // 0代表免费
                $fee_list->club_project_id = $model->id;
                $sv=$fee_list->save();
            }
            $model->cost_account = 0;
            $model->free_state_Id = 1201;
            $model->send_oper = get_session('admin_name');
            $model->send_date = date('Y-m-d H:i:s');
            $model->cut_date = date('Y-m-d H:i:s', strtotime('3 days'));
            if($pay_way==''){
                $pay_way=1374;
            }
            $model->pay_way = $pay_way;
            $bs2 = BaseCode::model()->find('f_id='.$model->pay_way);
            $model->pay_way_name = $bs2->F_NAME;
            if($sv==1){
                $sn=$model->save();
            }
            if($sv==1 && $sn==1){
                $sf=1;
                
                if($sf==1&&$model->pay_way==1374){
                    // 通知
                    $r_admin=QmddAdministrators::model()->find('club_code='.$model->p_code);
                    $m_message='您入驻的“'.$model->project_name.'”已选择“'.$model->approve_state_name.'”方式，根据系统规定，您申请的项目符合”免单“规定，系统已免单。';
                    $basepath=BasePath::model()->getPath(191); 
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                    $title='项目缴费通知';
                    $content='您入驻的“'.$model->project_name.'”已选择“'.$model->approve_state_name.'”方式...';
                    $url='';
                    $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>5);
                    backstage_send_message(get_session('admin_id'),$model->p_code,$m_message,$title,315,'B'.$model->p_code,$sendArr);
                }
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
     * 取消通知，通过删除购物车数据来取消
     */
    public function actionUnsend($id) {
        $len = explode(',',$id);
        foreach($len as $v){
            $model = ClubProject::model()->find('id='.$v);
            if(!empty($model)){
                ClubMembershipFeeDataList::model()->deleteAll('club_project_id='.$model->id);
                if(!empty($model->order_num)){
                    $count = Carinfo::model()->find('order_num="'.$model->order_num.'"');
                    if(!empty($count)){
                        $count->updateByPk($count->id,array('if_del'=>649));
                    }
                    CardataCopy::model()->deleteAll('order_num="'.$model->order_num.'"');
                }
                ClubProject::model()->updateByPk($v,array('order_num'=>'','free_state_Id'=>1200,'free_state_name'=>'待通知','pay_way'=>null,'pay_way_name'=>''));
                $sf=1;
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'取消成功',Yii::app()->request->urlReferrer,'取消失败');
    }

    /**
     * 待确认
     */
    public function actionConfirmed($id) {
        $modelName = $this->model;
        $n = explode(',',$id);
        foreach($n as $v){
            $model = $this->loadModel($v,$modelName);
            if($model->free_state_Id==1202) {
                $sf=0;
                continue;
            }
            $fee_list = ClubMembershipFeeDataList::model()->find('club_project_id='.$model->id);
            // if(!empty($fee_list)){
            //     $model->cost_oper = get_session('admin_name');
            //     $sf=$model->save();
            //     continue;
            // }
            $mall_info = MallSalesOrderInfo::model()->find('order_num="'.$model->order_num.'"');
            // if(!empty($mall_info)){
            //     $mall_data = MallSalesOrderData::model()->find('info_id='.$mall_info->id);
            // }
            $ship_fee = ClubMembershipFee::model()->find('code="TS15"');
            if(!empty($ship_fee)){
                $fee_data = ClubMembershipFeeData::model()->find('gf_club_id='.get_session('club_id').' and levelid='.$model->project_level.' and product_id='.$ship_fee->product_id);
            }
            if(empty($fee_list)){
                $fee_list = new ClubMembershipFeeDataList;
                $fee_list->isNewRecord = true;
                unset($fee_list->id);
            }
            if(!empty($fee_data)){
                $fee_list->scale_info_id = $fee_data->scale_info_id;
                $fee_list->scale_list_Id = $fee_data->scale_list_Id;
                $fee_list->scale_data_id = $fee_data->id;
                $fee_list->scale_code = $fee_data->scale_code;
                $fee_list->feeid = $fee_data->feeid;
                $fee_list->code = $fee_data->code;
                $fee_list->name = $fee_data->name;
                $fee_list->levetypeid = $fee_data->levetypeid;
                $fee_list->product_id = $fee_data->product_id;
                $fee_list->product_code = $fee_data->product_code;
                $fee_list->product_name = $fee_data->product_name;
                $fee_list->json_attr = $fee_data->json_attr;
            }
            if(!empty($mall_info)){
                $fee_list->scale_no = $mall_info->payment_code;
                $fee_list->scale_type = $mall_info->pay_supplier_type_name;
                $fee_list->date_start_scale = $mall_info->order_Date;
                $fee_list->date_end_scale = $mall_info->pay_time;
                $fee_list->date_scale = $mall_info->pay_time;
                $fee_list->scale_amount = $mall_info->total_money;
            }
            $fee_list->fee_type = 404;
            $fee_list->club_id = $model->club_id;
            $fee_list->club_name = $model->club_name;
            $fee_list->project_id = $model->project_id;
            $fee_list->project_name = $model->project_name;
            $fee_list->levelid = $model->project_level;
            $fee_list->levelname = $model->level_name;
            $fee_list->f_username = get_session('admin_name');
            $fee_list->f_userdate = date('Y-m-d H:i:s');
            $fee_list->club_project_id = $model->id;
            $fee_list->order_num = $model->order_num;
            $sv=$fee_list->save();
            $model->cost_oper = get_session('admin_name');
            $model->auth_state = 461;
            $model->free_state_Id = 1202;
            $model->entry_validity = date('Y-m-d H:i:s');
            $model->effective_date = date('Y-m-d H:i:s');
            $cType=ClubServicerType::model()->find('member_second_id='.$model->partnership_type);
            $day=date('Y-m-d H:i:s', strtotime("".$cType->renew_time." day"));
            $model->valid_until = $day;
            $bs = BaseCode::model()->find('f_id='.$model->free_state_Id);
            $model->free_state_name = $bs->F_NAME;
            $model->confirm_adminid = get_session('admin_id');
            $model->confirm_adminname = get_session('admin_name');
            $sn=$model->save();
            if($sv==1 && $sn==1){
                $sf=1;
                
                // 项目入驻报名确认之后项目单位兑换消费积分
                if($model->club_type==8){
                    $consumer_type=1467;
                }elseif($model->club_type==9){
                    $consumer_type=1479;
                }elseif($model->club_type==189){
                    $consumer_type=1124;
                }
                $credit_set=GfCredit::model()->find('object=1476 and item_type=355 and consumer_type='.$consumer_type);
                if(!empty($credit_set)){
                    if(round($model->cost_account/($credit_set->value/$credit_set->credit))>0){
                        $hl = new GfCreditHistory();
                        $hl->isNewRecord = true;
                        unset($hl->id);
                        $hl->object=502;
                        $hl->gf_id=$model->club_id;
                        $hl->get_object=502;
                        $hl->get_id=$model->club_id;
                        $hl->item_code=$credit_set->id;
                        $hl->service_source='项目入驻';
                        $hl->order_num=$model->order_num;
                        $hl->add_or_reduce=1;
                        $hl->credit=round($model->cost_account/($credit_set->value/$credit_set->credit));
                        $hl->add_time=date('Y-m-d H:i:s');
                        $hl->save();
                    }
                }

                $p_count=ClubProject::model()->count('club_id='.$model->club_id.' and auth_state=461');
                if($p_count>0){
                    $data = QmddAdministrators::model()->find('club_id='.$model->club_id);
                    if(empty($data)){
                        $data = new QmddAdministrators;
                        $data->isNewRecord = true;
                        unset($data->id);
                        
                        $data->ec_salt = rand(1,9999);
                        $acc = $model->p_code;
                        $p = md5(trim($acc).'123456');
                        $data->password = pass_md5($data->ec_salt,$p);
                    }
                    $role = QmddRoleClub::model()->find('f_rname="'.$model->partnership_name.'"');
                    $data->admin_level=$role->f_roleid;
                    $data->admin_gfaccount=$model->p_code;
                    $data->role_name=$role->f_rname;
                    $data->club_name=$model->club_name;
                    $data->save();
                }

                // 通知
                $r_admin=QmddAdministrators::model()->find('club_code='.$model->p_code);
                if($model->pay_way==12){
                    $m_message='您入驻的”'.$model->project_name.'“已完成支付，项目入驻完成。';
                    $content='您入驻的”'.$model->project_name.'“已完成支付，项目入驻完成。';
                }else{
                    $m_message='恭喜您，“'.$model->project_name.'”入驻成功。';
                    $content='恭喜您，“'.$model->project_name.'”入驻成功。';
                }
                $basepath=BasePath::model()->getPath(191); 
                $club=ClubList::model()->find("id=".get_session('club_id'));
                $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                $title='项目缴费确认';
                $url='';
                $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>5);
                backstage_send_message(get_session('admin_id'),$model->p_code,$m_message,$title,315,'B'.$model->p_code,$sendArr);
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'已确认',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionIndex_unit($keywords = '',$project_id='', $partnership_type='', $start_date = '', $end_date = '',$club_id=0, $state=0,$index='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ($club_id==0) ? get_where_club_project('club_id','') : 'club_id='.$club_id.' and if_del=510';
        if($index==1){
            $criteria->condition .= ' and state in(2,373)';
        }elseif($index==2){
            if($club_id==0){
                $criteria->condition .= ' and state=2 and auth_state=461 and club_id='.get_session('club_id');
            }else{
                $criteria->condition .= ' and state=2 and auth_state=461';
            }
            // $start_date='';$end_date='';
        }elseif($index==3){
            $criteria->condition .= ' and state=721 and club_id='.get_session('club_id');
        }elseif($index==4){
            $criteria->condition .= ' and state=371';
            $start_date='';$end_date='';
        }elseif($index==5){
            $criteria->condition .= ' and state in(373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }elseif($index==6){
            $criteria->condition .= ' and project_state in(507,1282,1283)';
        }elseif($index==7){
            $criteria->condition .= ' and state in(371,373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }
       
        $criteria->condition=get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($partnership_type),'partnership_type',$partnership_type,'');
        if($index==4){
            if ($start_date != '') {
                $criteria->condition.=' and left(add_time,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' and left(add_time,10)<="' . $end_date . '"';
            }
        }elseif($index==7||$index==5){
            if ($start_date != '') {
                $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
            }
        }else{
            if ($start_date != '') {
                $criteria->condition.=' and left(uDate,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' and left(uDate,10)<="' . $end_date . '"';
            }
        }
        $criteria->condition=get_like($criteria->condition,'club_name,p_code,project_name',$keywords,'');//get_where
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['partnership_type'] = ClubServicerType::model()->findAll('type in(1467,1124,1471,1479,1125)');
        $data['project_list'] = ProjectList::model()->getProject();
        if(get_session('club_id')==2450){
            $data['count1'] = $model->count('state=371');
        }else{
            $data['count1'] = $model->count('club_id='.get_session('club_id').' and state=371');
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_unit', $data);
    }

    public function actionIndex_list($project_id='', $partnership_type='', $start_date = '', $end_date = '', $keywords = '',$state=0 ) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id','').' and state='.$state.' and if_del=510';
        $criteria->condition=get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($partnership_type),'partnership_type',$partnership_type,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'add_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'add_time<=',$end_date,'"');
		$criteria->condition=get_like($criteria->condition,'club_name,p_code,project_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['partnership_type'] = BaseCode::model()->getClub_type2();
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_list', $data);
    }

	public function actionCreate_unit() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(!empty($model->project_id))$data['model2'] = QualificationClub::model()->findAll('club_id='.get_session('club_id').' and project_id='.$model->project_id);
            $data['type'] = ClubServicerType::model()->findAll('is_club_qualification=1');
            $data['remove_type'] = AutoFilterSet::model()->getCode(221);
            
            $this->render('update_unit', $data);
          } else {
             $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_unit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;

            if(!empty($model->project_id))$data['model2'] = QualificationClub::model()->findAll('club_id='.$model->club_id.' and project_id='.$model->project_id);
            $data['type'] = ClubServicerType::model()->findAll('is_club_qualification=1');
            $data['remove_type'] = AutoFilterSet::model()->getCode(221);
            
            $this->render('update_unit', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    // 撤销申请
    public function actionCancel($id,$new='',$del='',$yes='',$no='') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $id . ')';
        $count = $model->updateAll(array($new => $del), $criteria);
        if ($count > 0) {
            ajax_status(1, $yes, get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, $no);
        }
    }    

    // 冻结列表
    public function actionIndex_cold($start_date='',$end_date='',$keywords = '',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ClubProjectLock::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '(1=1)';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' AND left(t.add_time,10)>="'.$start_date.'"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(t.add_time,10)<="'.$end_date.'"';
        }
		$criteria->join = "JOIN club_project t2 on t.club_project_id=t2.id";
		$criteria->condition=get_like($criteria->condition,'t2.p_code,t2.club_name,t2.project_name',$keywords,'');
        $criteria->condition=get_where($criteria->condition,!empty($state),'t.state',$state,'');
        $criteria->order = 't.id DESC';
        $data = array();
        $data['state']=BaseCode::model()->getReturn('1282,1283,506,507');
        $data['start_date']=$start_date;
        $data['end_date']=$end_date;
        $data['count1'] = $model->count('state<>506 and left(add_time,10)="'.date("Y-m-d").'"');
        $data['count2'] = $model->count('state=506 and left(add_time,10)="'.date("Y-m-d").'"');
        parent::_list($model, $criteria, 'index_cold', $data);
    }

    // 单位项目状态处理
    public function actionAddForm(){
        $modelName = $this->model;
        $model = $this->loadModel($_POST['club_project_id'], $modelName);
        $model->project_state=$_POST['project_state'];
        if($_POST['project_state']==1282){
            $model->lock_date_start=date('Y-m-d H:i:s'); 
            $model->lock_date_end=date('Y-m-d H:i:s', strtotime('7 days'));
        }else if($_POST['project_state']==1283){
            $model->lock_date_start=date('Y-m-d H:i:s'); 
            $model->lock_date_end=date('Y-m-d H:i:s', strtotime('30 days'));
        }else if($_POST['project_state']==507){
            $model->lock_date_start=date('Y-m-d H:i:s'); 
            $model->lock_date_end='9999-00-00 00:00:00';
        }else{
            $model->lock_date_start=''; 
            $model->lock_date_end=''; 
        }
        $model->lock_reason=$_POST['lock_reason'];
        $sv=$model->save();
        if($sv==1){
            $lock = new ClubProjectLock();
            $lock->isNewRecord = true;
            unset($lock->id);
            $lock->club_project_id=$model->id;
            $lock->state=$model->project_state;
            $lock->lock_date_start=$model->lock_date_start;
            $lock->lock_date_end=$model->lock_date_end;
            $lock->lock_reason=$model->lock_reason;
            $lock->add_time=date('Y-m-d H:i:s'); 
            $lock->save();
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionIndex_thawy($keywords = '',$project_state='') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'auth_state=461 and state=2 and free_state_Id=1202 and project_state<>506 and if_del=510';
        $day=date('Y-m-d H:i:s',strtotime('+7 day'));
        if(empty($project_state)){
            $criteria->condition .= ' and lock_date_end<="'.$day.'" and lock_date_end>="'.date('Y-m-d H:i:s').'"' ;
        }else{
            $criteria->condition=get_where($criteria->condition,!empty($project_state),'project_state',$project_state,'');
        }
        $criteria->condition=get_like($criteria->condition,'club_name,p_code,project_name',$keywords,'');
        $criteria->order = 'lock_date_start desc';
        $data = array();
        $data['project_state']=BaseCode::model()->getReturn('1282,1283,507');
        parent::_list($model, $criteria,'index_thawy', $data);
    }
    
    // 单位项目解冻处理
    public function actionRemedy($id,$way){
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            if($way==1&&$model->project_state!=507){
                $model->effective_date=$model->lock_date_end;
            }
            $model->project_state=506;
            $model->lock_time=date('Y-m-d H:i:s');
            $sv=$model->save();
            if($sv==1){
                $cModel = new ClubProjectLock();
                $cModel->isNewRecord = true;
                unset($cModel->id);
                $cModel->club_project_id=$model->id;
                $cModel->state=$model->project_state;
                $cModel->add_time=date('Y-m-d H:i:s'); 
                $cModel->remedy_btn=$way; 
                $cModel->lock_date_start=$model->lock_date_start;
                $cModel->lock_date_end=$model->lock_date_end;
                if($way==0){
                    $cModel->lock_date_end=date('Y-m-d H:i:s');
                }
                $cModel->save();
            }
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }
}
 