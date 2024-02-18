<?php

class ActivitySignListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    // 活动报名列表
    public function actionIndex($title='' , $content='' , $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'state in(721) and activity_club_id='.get_session('club_id');
		$criteria->condition=get_where($criteria->condition,!empty($title),'activity_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'activity_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index', $data);
    }

    // 已报名列表
    public function actionIndex_data($title='' , $content='' , $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'state in(2,374) and free_state_Id=1202 and activity_club_id='.get_session('club_id');
		$criteria->condition=get_where($criteria->condition,!empty($title),'activity_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'activity_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_data', $data);
    }
	
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;

            $this->render('create', $data);
        } else {
			$this->saveCreateData();
        }
    }

    function saveCreateData() {
        $modelName = $this->model;
        $st=0;
		if ($_POST['submitType'] == 'tongguo') {
            $yes='审核通过';
            $no='审核通过失败';
        } else if ($_POST['submitType'] == 'baocun') {
            $yes='保存成功';
            $no='保存失败';
        }
        $is_fill=1;
        $apply_count='';
        if(!empty($_POST['add_tag'])){
            foreach($_POST['add_tag'] as $v){
                if(empty($v['sign_gfid'])){
                    $is_fill=0;
                }
            }
            if($is_fill==1){
                foreach($_POST['add_tag'] as $v){
                    $data=ActivitySignList::model()->find('activity_id='.$_POST[$modelName]['activity_id'].' and activity_data_id='.$_POST[$modelName]['activity_data_id'].' and sign_gfid='.$v['sign_gfid'].' and state=2 and (free_state_Id=1201 or free_state_Id=1202)');
                    if(empty($data)){
                        $data=ActivitySignList::model()->find('activity_id='.$_POST[$modelName]['activity_id'].' and activity_data_id='.$_POST[$modelName]['activity_data_id'].' and sign_gfid='.$v['sign_gfid'].' and (state<>2 or (free_state_Id<>1201 and free_state_Id<>1202))');
                        if(empty($data)){
                            $data=new ActivitySignList();
                            $data->isNewRecord = true;
                            unset($data->id);
                        }
                        $data->activity_id = $_POST[$modelName]['activity_id'];
                        $data->activity_data_id = $_POST[$modelName]['activity_data_id'];
                        $data->sign_gfid = $v['sign_gfid'];
                        $data->sign_account = $v['sign_account'];
                        $data->sign_name = $v['sign_name'];
                        $data->sign_sex = $v['sign_sex'];
                        $data->sige_phone = $v['sige_phone'];
                        $data->state = get_check_code($_POST['submitType']);
                        $data->logon_way = 1375;
                        if ($_POST['submitType'] == 'tongguo') {
                            $data->audit_time = date('Y-m-d h:i:s');
                            $data->adminid = get_session('admin_id');
                            $data->adminname = get_session('admin_name');
                            $data->free_state_Id = 1201;
                        }

                        // 添加服务信息表,后台添加数据直接进入待确认
                        $serviceData=[];
                        $serviceData=GfServiceData::model()->find('order_type=354 and service_id='.$data->activity_id.' and service_data_id='.$data->activity_data_id.' and gfid='.$v['sign_gfid'].' and state=2 and is_pay=464');
                        if(empty($serviceData)){
                            $mallPriceSet=MallPriceSet::model()->find('pricing_type=354 and service_id='.$data->activity_id);$mallPriceSetDetails=MallPriceSetDetails::model()->find('set_id='.$mallPriceSet->id.' and pricing_type=354 and service_id='.$data->activity_id.' and service_data_id='.$data->activity_data_id);
                            $ActivityList=ActivityList::model()->find('id='.$data->activity_id);
                            $ActivityData=ActivityListData::model()->find('id='.$data->activity_data_id);
                            $serviceData=GfServiceData::model()->find('order_type=354 and service_id='.$data->activity_id.' and service_data_id='.$data->activity_data_id.' and gfid='.$v['sign_gfid'].' and is_pay<>464');
                            if(empty($serviceData)){
                                $serviceData=new GfServiceData();
                                $serviceData->isNewRecord = true;
                                unset($serviceData->id);
                                $serviceData->order_num = $this->get_max_order_num();
                            }
                            $serviceData->order_type = 354;
                            $serviceData->project_id = $ActivityData->project_id;
                            $serviceData->supplier_id = $ActivityList->activity_club_id;
                            $serviceData->gfid = $v['sign_gfid'];
                            $serviceData->gf_account = $v['sign_account'];
                            $serviceData->contact_phone = $v['sige_phone'];
                            $serviceData->service_id = $data->activity_id;
                            $serviceData->service_code = $ActivityList->activity_code;
                            $serviceData->service_ico = $ActivityList->activity_small_pic;
                            $serviceData->service_name = $ActivityList->activity_title;
                            $serviceData->service_data_id = $data->activity_data_id;
                            $serviceData->service_data_name = $ActivityData->activity_content;
                            $serviceData->servic_time_star = $ActivityData->activity_time;
                            $serviceData->servic_time_end = $ActivityData->activity_time_end;
                            $serviceData->buy_count = 1;
                            $serviceData->set_code = $mallPriceSet->event_code;
                            $serviceData->set_name = $mallPriceSet->event_title;
                            $serviceData->price_set_id = $mallPriceSetDetails->id;
                            $serviceData->buy_price = $mallPriceSetDetails->sale_price;
                            $serviceData->free_money=$serviceData->buy_price;
                            $serviceData->udate = date('Y-m-d h:i:s');
                            $serviceData->check_way = $ActivityData->apply_check_way;
                            $serviceData->state = get_check_code($_POST['submitType']);
                            if ($_POST['submitType'] == 'tongguo') {
                                $serviceData->is_pay=464; //后台添加数据不用缴费
                                $serviceData->order_state=1462;
                            }
                            $serviceData->free_make=0;
                            $serviceData->add_time = date('Y-m-d h:i:s');
                            $serviceData->service_address = $ActivityList->activity_address;
                            $st=$serviceData->save();
                        }else{
                            $st=1;
                        }

                        if($st==1){
                            $data->order_num = $serviceData->order_num;
                        }
                        $st=$data->save();
                    }else{
                        $st=1;
                        $apply_count.=$v['sign_account'].',';
                    }
                }
            }else{
                $no='账号不能为空';
            }
        }

        if($apply_count!=''){
            $yes=$yes.','.rtrim($apply_count, ',').'账号已报名';
        }
	    show_status($st, $yes, get_cookie('_currentUrl_'), $no); 
    }

    public function actionGetListData(){
        $data = ActivityListData::model()->findAll('activity_id='.$_POST['id']);
        $ar = array();
        if(!empty($data))foreach($data as $key => $val){
            $count=GfServiceData::model()->count('order_type=354 and service_id='.$_POST['id'].' and service_data_id='.$val->id.' and state=2');
            if(!empty($_POST['index'])&&$_POST['index']==1){
                if($val->apply_number>$count){
                    $ar[$key]['id'] = $val->id;
                    $ar[$key]['activity_content'] = $val->activity_content;
                    $ar[$key]['remnant'] = $val->apply_number-$count;
                }
            }else{
                $ar[$key]['id'] = $val->id;
                $ar[$key]['activity_content'] = $val->activity_content;
                $ar[$key]['remnant'] = $val->apply_number-$count;
            }
        }
        echo CJSON::encode($ar);
    }

    // 帐号验证
    public function actionValidate($activity_id='',$activity_data_id='',$gf_account=0) {
        $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
        if(!empty($user))$data=ActivitySignList::model()->find('activity_id='.$activity_id.' and activity_data_id='.$activity_data_id.' and sign_gfid='.$user->GF_ID.' and state=2 and (free_state_Id=1201 or free_state_Id=1202)');
        if(!empty($user)&&$user->user_state==506) {
            if($user->passed!=2) {  
                ajax_status(0, '帐号未实名');
            }elseif(!empty($data)){
                ajax_status(0, '该账号已报名');
            }else{
                $ar = array();
                $ar['GF_ID'] = $user->GF_ID;
                $ar['ZSXM'] = $user->ZSXM;
                $ar['real_sex'] = $user->real_sex;
                $ar['real_sex_name'] = $user->real_sex_name;
                $ar['PHONE'] = $user->PHONE;
                $ar['real_birthday'] = $user->real_birthday;
                $ar['status'] = 1;
                echo CJSON::encode($ar);
            }
        }else{
            ajax_status(0, '您输入的账号不存在或已冻结');
        }
    }

	/**
	 * 获取流水号
	 */
	function get_max_order_num(){
		$num = date('Ymd');
        $num1= '000000';  
        $orderinfo = GfServiceData::model()->find("left(order_num,8)='".$num."' order by order_num DESC");
        if(!empty($orderinfo)){
            $num1=$orderinfo->order_num;
        }
        return $num.substr(''.(1000001+substr($num1, -6)),1,6);
	}

    // 活动报名待审核列表
    public function actionIndex_audit($start_date = '', $end_date = '', $state='', $title='', $content='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'activity_club_id='.get_session('club_id');
        if($state==371){
            $criteria->condition .= ' and state='.$state;
        }else{
            $criteria->condition .= ' and state in(2,373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'activity_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'activity_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
		$data['count1'] = $model->count('state=371 and activity_club_id='.get_session('club_id'));
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_audit', $data);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
			$data = array();
			$data['model'] = $model;
            $data['activity_data'] = ActivityListData::model()->find('id='.$model->activity_data_id);
			$this->render('update', $data);
        } else {
            $this->saveData($model);
        }
    }

    // 活动报名提交审核
    public function actionSubmit(){
        $count = explode(',',$_POST['id']);
        foreach($count as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->state = get_check_code($_POST['submitType']);
            $model->audit_time = date('Y-m-d h:i:s');
            $model->adminid = get_session('admin_id');
            $model->adminname = get_session('admin_name');
            $model->free_state_Id = 1201;
            $st=$model->save();
            GfServiceData::model()->updateAll(array('state'=>$model->state,'is_pay'=>464,'order_state'=>1462),'order_type=354 and order_num="'.$model->order_num.'"');
        }
        show_status($st,'提交审核成功',Yii::app()->request->urlReferrer,'提交审核失败');
    }

    // 活动报名审核列表
    public function actionCheck(){
        $count = explode(',',$_POST['id']);
        $str='';
        foreach($count as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->state = get_check_code($_POST['submitType']);
            $model->audit_time = date('Y-m-d H:i:s');
            $model->adminid = get_session('admin_id');
            $model->adminname = get_session('admin_name');

            $aData=ActivityListData::model()->find('id='.$model->activity_data_id);
            $applyCount=GfServiceData::model()->count('order_type=354 and service_id='.$model->activity_id.' and service_data_id='.$model->activity_data_id.' and state=2');
            if($aData->apply_number-$applyCount<=0&&$model->state==2){
                $st=0;
                $str=($str==''?'':',').$model->sign_account;
            }else{
                $st=$model->save();
                if ($model->state==2&&$aData->activity_money<=0) {
                    GfServiceData::model()->updateAll(array('state'=>$model->state,'is_pay'=>464,'order_state'=>1462),'order_type=354 and order_num="'.$model->order_num.'"');
                }else{
                    if($model->state==373){
                        GfServiceData::model()->updateAll(array('state'=>$model->state,'order_state'=>1173),'order_type=354 and order_num="'.$model->order_num.'"');
                    }else{
                        GfServiceData::model()->updateAll(array('state'=>$model->state),'order_type=354 and order_num="'.$model->order_num.'"');
                    }
                }
                $s_id=GfServiceData::model()->find('order_type=354 and order_num="'.$model->order_num.'"');
                if($st==1&&$model->state==2&&$_POST['if_notice']==649&&$aData->activity_money>0){
                    $this->actionNotice($s_id->id,1,1);
                }
                if($st==1&&$model->state==373&&$_POST['if_notice']==649){
                    $this->notice($model->sign_gfid,$model->activity_id,$model->activity_data_id,$model->state,315,'',$s_id->id);
                }
            }
        }
        if($str!=''){
            $str=$str.'名额已满，';
        }
        show_status($st,'审核成功',Yii::app()->request->urlReferrer,$str.'审核失败');
    }

    function saveData($model) {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        $model->state = get_check_code($_POST['submitType']);
		if ($_POST['submitType'] == 'shenhe') {
            $model->audit_time = date('Y-m-d h:i:s');
            $model->adminid = get_session('admin_id');
            $model->adminname = get_session('admin_name');
            $model->free_state_Id = 1201;
            $yes='提交审核成功';
            $no='提交审核失败';
        } else if ($_POST['submitType'] == 'baocun') {
            $yes='保存成功';
            $no='保存失败';
        } else if ($_POST['submitType'] == 'tongguo' || $_POST['submitType'] == 'butongguo') {
            $yes='操作成功';
            $no='操作失败';
            $model->audit_time = date('Y-m-d H:i:s');
            $model->adminid = get_session('admin_id');
            $model->adminname = get_session('admin_name');
        } else {
            $yes='操作成功';
            $no='操作失败';
        }
        $aData=ActivityListData::model()->find('id='.$model->activity_data_id);
        $applyCount=GfServiceData::model()->count('order_type=354 and service_id='.$model->activity_id.' and service_data_id='.$model->activity_data_id.' and state=2');
        if($aData->apply_number-$applyCount<=0&&$model->state==2){
            $st=0;
            $no='名额已满，审核失败';
        }else{
            $st=$model->save();
            if ($_POST['submitType'] == 'shenhe'||($model->state==2&&$aData->activity_money<=0)) {
                GfServiceData::model()->updateAll(array('state'=>$model->state,'is_pay'=>464,'order_state'=>1462),'order_type=354 and order_num="'.$model->order_num.'"');
            }else{
                if($model->state==373){
                    GfServiceData::model()->updateAll(array('state'=>$model->state,'order_state'=>1173),'order_type=354 and order_num="'.$model->order_num.'"');
                }else{
                    GfServiceData::model()->updateAll(array('state'=>$model->state),'order_type=354 and order_num="'.$model->order_num.'"');
                }
            }
            $if_notice=empty($_POST[$modelName]['if_notice'])?648:$_POST[$modelName]['if_notice'];
            $s_id=GfServiceData::model()->find('order_type=354 and order_num="'.$model->order_num.'"');
            if($st==1&&$model->state==2&&$if_notice==649&&$aData->activity_money>0){
                $this->actionNotice($s_id->id,1,1);
            }
            if($st==1&&$model->state==373&&$if_notice==649){
                $this->notice($model->sign_gfid,$model->activity_id,$model->activity_data_id,$model->state,315,'',$s_id->id);
            }
        }
	    show_status($st, $yes, get_cookie('_currentUrl_'), $no); 
    }

    // 通知缴费
    public function actionNotice($id,$radio,$audit=0){
        $modelName = 'GfServiceData';
        $ex = explode(',',$id);
        $r = 0;
        foreach($ex as $d){
            $model = $this->loadModel($d, $modelName);
            $money = ($radio==0) ? $model->buy_price : 0;
            $model->free_make = $radio;
            $model->free_money = $money;
            $model->is_pay = ($radio==0) ? 464 : $model->is_pay;
            $model->order_state = ($radio==0) ? 1462 : $model->order_state;
            $r = $model->save();
            if($r==1&&!empty($model->order_num)){
                $sign_list = ActivitySignList::model()->find('order_num="'.$model->order_num.'"');
            }
            if($radio==1 && $model->buy_price>0){
                $free_state_Id=1195;
                $this->save_shopping($model);
            }else{
                $free_state_Id=1201;
                $this->notice($model->gfid,$model->service_id,$model->service_data_id,$model->state,315,'',$model->id);
            }
            if(!empty($sign_list)){
                $sign_list->updateByPk($sign_list->id,array('free_state_Id'=>$free_state_Id));
            }
        }
        if($audit==0){
            show_status($r,'发送成功',Yii::app()->request->urlReferrer,'发送失败');
        }
    }
    /**
	 * 生成购物车信息，
	 */
	function save_shopping($model){
        $base_code = BaseCode::model()->find('f_id=354');
        if(!empty($model->project_id))$sign_level = ClubMemberList::model()->find('gf_account='.$model->gf_account.' and member_project_id='.$model->project_id.' and club_status=337');

        $mall_price_set= MallPriceSet::model()->find('service_id='.$model->service_id.' and pricing_type=354');
        $w1='set_id='.$mall_price_set->id.' and pricing_type=354 and service_data_id='.$model->service_data_id;
        $SetDs = MallPriceSetDetails::model()->find($w1);
        $w1='pricing_type=354 and set_id='.$mall_price_set->id.' and service_data_id='.$model->service_data_id.' and set_details_id='.$SetDs->id;
        $MallPricingDetails = MallPricingDetails::model()->find($w1);

        $effective_time=date("Y-m-d H:i:s",strtotime("+30 minute"));
        $order_data=array('order_type'=>354
        	,'buyer_type'=>210
	        ,'order_gfid'=>$model->gfid
	        ,'money'=>$model->buy_price
	        ,'order_money'=>$model->buy_price
	        ,'total_money'=>$model->buy_price
	        ,'effective_time'=>$effective_time);
		$add_order=Carinfo::model()->addOrder($order_data);
		$sv=empty($add_order['order_num'])?0:1;
		if(!empty($add_order['order_num'])){
			GfServiceData::model()->updateByPk($model->id,array('shopping_order_num'=>$add_order['order_num'],'effective_time'=>$effective_time));
			
	        // 购物车详细
	        $cat_copy = new CardataCopy();
	        $cat_copy->isNewRecord = true;
	        unset($cat_copy->id);
	        $cat_copy->order_num = $add_order['order_num'];
	        $cat_copy->order_type = 354;
	        $cat_copy->order_type_name = $base_code->F_NAME;
	        $cat_copy->supplier_id = $model->supplier_id;
	        $cat_copy->buy_price = $model->buy_price;  // 商品单价
	        $cat_copy->buy_amount = $model->buy_price;  // 购买实际金额
	        if(!empty($mall_price_set)){
	            $cat_copy->set_id = $mall_price_set->id;
	        }
	        if(!empty($MallPricingDetails)){
	            $cat_copy->details_id = $MallPricingDetails->id;
	        }
	        $cat_copy->project_id = $model->project_id;
	        $cat_copy->project_name = $model->project_name;
	        if(!empty($sign_level)){
	            $cat_copy->buy_level = $sign_level->project_level_id;
	            $cat_copy->buy_level_name = $sign_level->project_level_name;
	            $cat_copy->gf_club_id = empty($sign_level->club_id)?0:$sign_level->club_id;
	        }
	        $cat_copy->buy_count = 1;
	        $cat_copy->gfid = $model->gfid;
	        $cat_copy->gf_name = $model->gf_name;
	        $cat_copy->service_id = $model->service_id;
	        $cat_copy->service_code = $model->service_code;
	        $cat_copy->service_ico = $model->service_ico;
	        $cat_copy->service_name = $model->service_name;
	        $cat_copy->service_data_id = $model->service_data_id;
	        $cat_copy->service_data_name = $model->service_data_name;
	        $cat_copy->uDate = date('Y-m-d H:i:s');
	        $cat_copy->gf_service_id = $model->id;
	        $cat_copy->effective_time = $effective_time;
	        $st=$cat_copy->save();
		}

        if($sv==1&&$st==1){
            // 加入购物车成功后发送缴费通知
            $this->notice($model->gfid,$model->service_id,$model->service_data_id,$model->state,314,'',$model->id);
        }
    }

    // 活动缴费通知列表
    public function actionIndex_pay_notice($start_date = '', $end_date = '', $is_notice='', $title='', $content='', $keywords = '') {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.get_session('club_id');
        if($is_notice==1){
            $criteria->condition .= ' and order_type=354 and state=2 and is_pay=463';
            $criteria->condition .= ' and (isnull(sending_notice_time) or sending_notice_time="0000-00-00 00:00:00")'; 
        }else{
            $criteria->condition .= ' and order_type=354 and state=2';
            $criteria->condition .= ' and (!isnull(sending_notice_time) and sending_notice_time<>"0000-00-00 00:00:00")'; 
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(sending_notice_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(sending_notice_time,10)<="' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'service_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'service_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'order_num,gf_account,gf_name',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $col = 'supplier_id='.get_session('club_id').' and order_type=354 and state=2 and is_pay=463';  
        $col .= ' and (isnull(sending_notice_time) or sending_notice_time="0000-00-00 00:00:00")';
		$data['count1'] = $model->count($col);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_pay_notice', $data);
    }

    // 取消通知
    public function actionUnnotice($id){
        $len = explode(',',$id);
        $sv = 0;
        foreach($len as $d){
            $model = GfServiceData::model()->find('id='.$d);
            Carinfo::model()->deleteAll('order_num="'.$model->shopping_order_num.'"');
            CardataCopy::model()->deleteAll('order_num="'.$model->shopping_order_num.'"');
            $model->shopping_order_num = '';
            $model->sending_notice_time = null;
            $model->is_pay = 463;
            $sv = $model->save();
        }
        show_status($sv,'撤销成功',Yii::app()->request->urlReferrer,'撤销失败');
    }

    //活动缴费确认列表
    public function actionIndex_confrim($start_date = '', $end_date = '', $pay_confirm='', $title='', $content='', $keywords = '') {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.get_session('club_id');
        if($pay_confirm==1){
            $criteria->condition .= ' and order_type=354 and state=2 and is_pay=464 and pay_confirm=0';
        }else{
            $criteria->condition .= ' and order_type=354 and state=2 and is_pay=464 and pay_confirm=1';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)<="' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'service_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'service_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'order_num,gf_account,gf_name',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['count1'] = $model->count('supplier_id='.get_session('club_id').' and order_type=354 and state=2 and is_pay=464 and pay_confirm=0');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_confrim', $data);
    }

    // 确认缴费
    public function actionConfirmed($id){
        $modelName = 'GfServiceData';
        $ex = explode(',',$id);
        $r = 0;
        foreach($ex as $d){
            $model = $this->loadModel($d, $modelName);
            $model->pay_confirm = 1;
            $model->pay_confirm_time = date('Y-m-d H:i:s');
            $model->order_state = 1170;
            $model->pay_adminid = get_session('admin_id');
            $model->pay_admin_name = get_session('admin_name');
            $list = ActivityList::model()->find('id='.$model->service_id);
            if(!empty($list)){
                $list->gf_gross=empty($list->gf_gross)?0:$list->gf_gross;
                $model->gf_gross = $list->gf_gross;
                $model->gf_money = ($model->buy_price-$model->free_money) * ($list->gf_gross/100);
                $list->club_gross=empty($list->club_gross)?100:$list->club_gross;
                $model->club_gross = $list->club_gross;
                $model->club_money = ($model->buy_price-$model->free_money) * ($list->club_gross/100);
            }
            $r = $model->save();

            if($r==1){
                $sign_list = ActivitySignList::model()->find('order_num="'.$model->order_num.'"');
                if(!empty($sign_list)){
                    $sign_list->updateByPk($sign_list->id,array('free_state_Id'=>1202,'pay_confirm_time'=>$model->pay_confirm_time));
                    $foot=new GfUserFoot();
                	unset($foot->id);
	            	$foot->GF_ID=$sign_list->sign_gfid;
	            	$foot->content='报名参加了“'.$sign_list->activity_title.'”';
	            	$foot->time=$model->pay_confirm_time;
	            	$foot->save();
                }
                $this->notice($model->gfid,$model->service_id,$model->service_data_id,$model->state,315,1,$model->id);
            }
        }
        show_status($r,'确认成功',Yii::app()->request->urlReferrer,'确认失败');
    }
    
    // 报名活动相关通知
	function notice($gfid,$activity_id,$data_id,$state,$code,$pay_confirm=0,$gf_data_id){
		$type_id = 23;
		$admin_id = get_session('admin_id');
        $type = ($state==2) ? '【缴费通知消息】' : '【审核通知消息】';
        $type = $pay_confirm==1? '【报名成功消息通知】':$type;
		$txt1 = '点击本条信息进入缴费界面';
		$txt2 = '点击本条信息进入详情界面';
		$txt3 = $pay_confirm==0?'恭喜您！您的活动报名审核已通过。':'报名成功';
		$txt4 = '很抱歉！您的活动报名审核未通过。';
		$noti1 = ($state==2) ? $txt3 : $txt4;
		$noti2 = ($state==2&&$pay_confirm==0) ? $txt1 : $txt2;
        $serviceData = GfServiceData::model()->find('order_type=354 and id='.$gf_data_id);
        $content_html = '<font>'.$serviceData->service_name.'</font><br><font>'.$serviceData->service_data_name.'</font><br><font>'.$noti1.'</font><br><font style="color:rgb(170, 170, 170);">'.$noti2.'</font>';
        if($code==315){
            $data = array(
                'type' => $type,
                'pic' => $serviceData->service_ico,
                'title' => $serviceData->service_name,
                'content' => $noti2,
                'content_html' => $content_html,
                'datas' => [array('order_num'=>$serviceData->order_num)],
                'type_id' => $type_id
            );
        }elseif($code==314){
            $data = array(
                'type' => $type,
                'pic' => $serviceData->service_ico,
                'title' => $serviceData->service_name,
                'content' => $noti2,
                'content_html' => $content_html,
                'order_num' => $serviceData->shopping_order_num
            );
        }
        send_msg($code,$admin_id,$gfid,$data);
        if($pay_confirm==0){
            GfServiceData::model()->updateAll(array('sending_notice_time'=>date('Y-m-d H:i:s'),'notice_content'=>$content_html,'adminid'=>get_session('admin_id'),'admin_name'=>get_session('admin_name')),'order_type=354 and id='.$gf_data_id);
        }
    }

    // 活动签到列表
    public function actionIndex_sign_in($is_sign='',$star='',$end='',$title='',$content='',$keywords='') {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id');
        $criteria->condition .= ' and order_type=354 and is_pay=464 and state=2 and order_state<>1173 and order_state<>468 and servic_time_end>=now() and pay_confirm=1';
        $star=empty($star) ? date("Y-m-d", strtotime("-1 month")) : $star;
        $end=empty($end) ? date("Y-m-d") : $end;
        if($is_sign==''){
            $criteria->condition.=' and !isnull(sign_come) and sign_come<>"0000-00-00 00:00:00"';
            $criteria->condition.=' and left(sign_come,10)>="' . $star . '"';
            $criteria->condition.=' and left(sign_come,10)<="' . $end . '"';
        }elseif($is_sign==1){
            $criteria->condition.=' and (isnull(sign_come) or sign_come="0000-00-00 00:00:00") and servic_time_star>now()';
            $criteria->condition.=' and left(pay_confirm_time,10)>="' . $star . '"';
            $criteria->condition.=' and left(pay_confirm_time,10)<="' . $end . '"';
        }elseif($is_sign==2){
            $criteria->condition.=' and (isnull(sign_come) or sign_come="0000-00-00 00:00:00") and servic_time_star<=now()';
            $criteria->condition.=' and left(pay_confirm_time,10)>="' . $star . '"';
            $criteria->condition.=' and left(pay_confirm_time,10)<="' . $end . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'service_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'service_data_id',$content,'');
        $criteria->condition = get_like($criteria->condition,'info_order_num,order_num,gf_name,contact_phone',$keywords,'');
        $criteria->order = 'state_time DESC';
        $data = array();
        $data['star'] = $star;
        $data['end'] = $end;
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and '.get_where_club_project('activity_club_id'));
        $data['num'] = $model->count(get_where_club_project('supplier_id').' and state=2 and is_pay=464 and order_type=354 and order_state<>1173 and order_state<>468 and servic_time_end>=now() and pay_confirm=1');
        $data['count1'] = $model->count(get_where_club_project('supplier_id').' and state=2 and is_pay=464 and order_type=354 and (sign_come is null or sign_come="0000-00-00 00:00:00") and servic_time_star>=now() and order_state<>1173 and order_state<>468 and servic_time_end>=now() and pay_confirm=1');
        $data['count2'] = $model->count(get_where_club_project('supplier_id').' and state=2 and is_pay=464 and order_type=354 and (sign_come is null or sign_come="0000-00-00 00:00:00") and servic_time_star<=now() and order_state<>1173 and order_state<>468 and servic_time_end>=now() and pay_confirm=1');
        parent::_list($model, $criteria, 'index_sign_in', $data);
    }

    // 发送签到验证码
    public function actionGetSignCode($id){
        $count = explode(',',$id);
        foreach($count as $d){
            $modelName = 'GfServiceData';
            $model = $this->loadModel($d, $modelName);
            $model->send_sign_code=649;
            $st=$model->save();
            $basepath=BasePath::model()->getPath(191);
            $pic=$basepath->F_WWWPATH.$model->service_ico;
            $title=$model->service_name;
            $content='签到验证码'.$model->sign_code.',请按时签到。';
            $content_html = '<font>'.$model->service_data_name.'</font><br><font>签到验证码：'.$model->sign_code.'，请按时签到。</font><br><font style="color:rgb(170, 170, 170);">点击本条信息进入详情界面</font><br>';
            $url='';
            $type_id=23;
            $datas=array(array('order_num'=>$model->order_num));
            $sendArr=array('type'=>'【活动签到通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'content_html'=>$content_html,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
            game_audit($model->supplier_id,$model->gfid,$sendArr);
        };
        show_status($st,'发送成功',Yii::app()->request->urlReferrer,'发送失败');
    }

    // 点击签到
    public function actionSave_Sourcer($id){
        $count = explode(',',$id);
        foreach($count as $d){
            $modelName = 'GfServiceData';
            $model = $this->loadModel($d, $modelName);
            $achie = QmddAchievemen::model()->findAll('f_type='.$model->order_type.' order by f_code ASC');
            $orderInfo = MallSalesOrderData::model()->find('orter_item=757 and gf_service_id='.$model->id.' and order_num="'.$model->info_order_num.'"');
            if(!empty($achie))foreach($achie as $v){
                $achie_data = QmddAchievemenData::model()->find('gf_service_data_id='.$model->id.' and f_achievemenid='.$v->f_id);
                if(empty($achie_data)){
                    $achie_data = new QmddAchievemenData();
                    $achie_data->isNewRecord=true;
                    unset($achie_data->f_id);
                }
                if(!empty($orderInfo)){
                    $achie_data->order_num_id = $orderInfo->id;
                }
                $achie_data->order_type = $model->order_type;
                $achie_data->order_type_name = $model->order_type_name;
                $achie_data->service_id = $model->service_id;
                $achie_data->service_code = $model->service_code;
                $achie_data->service_ico = $model->service_ico;
                $achie_data->service_name = $model->service_name;
                $achie_data->service_data_id = $model->service_data_id;
                $achie_data->service_data_name = $model->service_data_name;
                $achie_data->gf_id = $model->gfid;
                $achie_data->f_achievemenid = $v->f_id;
                $achie_data->gf_service_data_id = $model->id;
                $achie_data->service_order_num = $model->order_num;
                $achie_data->club_id = $model->supplier_id;
                $sf=$achie_data->save();
            }
            $model->sign_come=date('Y-m-d H:i:s');
            $model->order_state=1171;
            $sn=$model->save();
            
            $basepath=BasePath::model()->getPath(191);
            $pic=$basepath->F_WWWPATH.$model->service_ico;
            $title=$model->service_name;
            $content='您已签到成功，请按时参加活动';
            $content_html = '<font>'.$model->service_data_name.'</font><br><font>您已签到成功，请按时参加活动。</font><br><font style="color:rgb(170, 170, 170);">点击本条信息进入详情界面</font><br>';
            $url='';
            $type_id=23;
            $datas=array(array('order_num'=>$model->order_num));
            $sendArr=array('type'=>'【活动签到通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'content_html'=>$content_html,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
            game_audit($model->supplier_id,$model->gfid,$sendArr);
        }
        show_status($sn,'签到成功',Yii::app()->request->urlReferrer,'失败');
    }


    // 活动评价列表
    public function actionIndex_evaluate($star='',$end='',$keywords = '') {
        $model = QmddAchievemenData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.get_session('club_id').' and order_type=354';
        if ($star != '') {
            $criteria->condition.=' and left(evaluate_time,10)>="' . $star . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(evaluate_time,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'service_order_num,gf_zsxm,service_name',$keywords,'');
        $criteria->order='uDate DESC';
        $criteria->group='gf_service_data_id';
        $data = array();
        $data['star'] = $star;
        $data['end'] = $end;
        parent::_list($model, $criteria,'index_evaluate', $data);
    }

    // 活动评价详情
    public function actionEvaluate_details($id) {
        $modelName = 'QmddAchievemenData';
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($model->gf_service_data_id)){
                $data['eval_list'] = QmddAchievemenData::model()->findAll('gf_service_data_id='.$model->gf_service_data_id);
            }
            $this->render('evaluate_details', $data);
        } else {
            $this-> saveEvaluateData($model,$_POST[$modelName]);
        }
    }

    function saveEvaluateData($model,$post) {
        $model->attributes = $post;
        $now=date('Y-m-d H:i:s');
        $sv=0;
        if($model){
            QmddAchievemenData::model()->updateAll(array(
                'club_evaluate_info'=>$model->club_evaluate_info,
                'club_f_mark'=>$model->club_f_mark,
                'club_evaluate_time'=>$now
            ),'gf_service_data_id='.$model->gf_service_data_id);
            $sv++;
        }
	    show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
    }

    // 报名费用明细
    public function actionPay_stat_data($club_id='', $start_date = '', $end_date = '', $title='', $content='', $keywords = '') {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.$club_id;
        $criteria->condition .= ' and order_type=354 and state=2 and is_pay=464 and pay_confirm=1';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)<="' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'service_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'service_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'info_order_num,gf_account,gf_name',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.$club_id);
        parent::_list($model, $criteria, 'pay_stat_data', $data);
    }
    
    // 日结算明细
    public function actionIndex_stat_data($club_id='', $start_date = '', $end_date = '', $title='', $content='', $keywords = '') {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        if($club_id!=''){
            $criteria->condition = 'supplier_id='.$club_id;
        }else{
            $criteria->condition = get_where_club_project('supplier_id');
        }
        $criteria->condition .= ' and order_type=354 and state=2 and is_pay=464 and pay_confirm=1';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)<="' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'service_id',$title,'');
		$criteria->condition=get_where($criteria->condition,!empty($content),'service_data_id',$content,'');
        $criteria->condition=get_like($criteria->condition,'info_order_num,gf_account,gf_name',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['activity_list'] = ActivityList::model()->findAll('state=2 and activity_club_id='.$club_id);
        parent::_list($model, $criteria, 'index_stat_data', $data);
    }

	public function actionDelete($id) {
        parent::_clear($id);
    }

    // 取消报名操作
    public function actionCancel($id,$new='',$del='',$yes='',$no='') {
        
        $count=ActivitySignList::model()->updateAll(array('state'=>$del),'id in(' . $id . ')');

        $list=ActivitySignList::model()->findAll('id in(' . $id . ')');
        foreach($list as $l){
            GfServiceData::model()->updateAll(array('state'=>$del),'order_type=354 and order_num="'.$l->order_num.'"');
        }
        if ($count > 0) {
            ajax_status(1, $yes, get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, $no);
        }
    }

}