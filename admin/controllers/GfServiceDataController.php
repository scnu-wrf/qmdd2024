<?php

class GfServiceDataController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($keywords = '',$start_date='',$end_date='',$state='',$is_pay='',$order_type='',$order_num='',$gf_name='',$contact_phone='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr=get_where_club_project('supplier_id','');
		$cr=get_where($cr,'state',$state,'');
		$cr=get_where($cr,$is_pay,'is_pay',$is_pay,'');
		$cr=get_where($cr,$order_type,'order_type',$order_type,'');
        $cr=get_like($cr,'service_name',$keywords,'');
		$cr=get_like($cr,'order_num',$order_num,'');
		$cr=get_like($cr,'gf_account,gf_name',$gf_name,'');
		$cr=get_like($cr,'contact_phone',$contact_phone,'');
		$cr=get_where($cr,($start_date!=""),'add_time>=',$start_date,'"');
        $criteria->condition=get_where($cr,($start_date!=""),'add_time<=',$end_date,'"');
        $criteria->order = 'id DESC';
		$data = array();
		$data['state'] = BaseCode::model()->getCode(370);
		$data['is_pay'] = BaseCode::model()->getCode(462);
		$data['order_type'] = BaseCode::model()->getOrderType();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionIndex_server($keywords = '',$start_date='',$end_date='',$is_pay='',$order_num='',$gf_name='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('supplier_id','');
        $cr.=' and order_type=353';
        $cr=get_where($cr,!empty($is_pay),'is_pay',$is_pay,'');
        $cr=get_like($cr,'service_name',$keywords,'');
        $cr=get_like($criteria->condition,'order_num',$order_num,'');
        $cr=get_like($cr,'gf_account,gf_name',$gf_name,'');
        $cr=get_where($cr,($start_date!=""),'add_time>=',$start_date,'"');
        $cr=get_where($cr,($end_date!=""),'add_time<=',$end_date,'"');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['is_pay'] = BaseCode::model()->getCode(462);
        parent::_list($model, $criteria, 'index_server', $data);
    }
    //动动约-服务预订-服务者预订
    public function actionIndex_server_FWZ($keywords = '',$start_date='',$end_date='',$star='',$end='',$server_state='',$order_state='') {
        $this->ShowServer($keywords,$start_date,$end_date,$star,$end,$server_state,$order_state,2,'index_server_FWZ');
    }
    //动动约-服务预订-场地预订
    public function actionIndex_server_CG($keywords = '',$start_date='',$end_date='',$star='',$end='',$server_state='',$order_state='') {
        $this->ShowServer($keywords,$start_date,$end_date,$star,$end,$server_state,$order_state,1,'index_server_CG');
    }
    //动动约-服务预订-约赛/约练预订
    public function actionIndex_server_YY($keywords = '',$start_date='',$end_date='',$star='',$end='',$server_state='',$order_state='') {
        $this->ShowServer($keywords,$start_date,$end_date,$star,$end,$server_state,$order_state,3,'index_server_YY');
    }
    public function ShowServer($keywords = '',$start_date='',$end_date='',$star='',$end='',$server_state='',$order_state='',$type='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($star=='') $star=$now;
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN qmdd_server_set_data on t.service_data_id=qmdd_server_set_data.id";
        $cr='t.order_type=353';
        $cr.=' and qmdd_server_set_data.t_typeid='.$type;
        $cr.=' and supplier_id='.get_session('club_id');
        $cr=get_where($cr,!empty($server_state),'server_state',$server_state,'');
        $cr=get_where($cr,!empty($order_state),'order_state',$order_state,'');
        $cr=get_where($cr,$start_date,'t.add_time>=',$start_date.' 00:00:00',"'");
        $cr=get_where($cr,$end_date,'t.add_time<=',$end_date.' 23:59:59',"'");
        $cr=get_where($cr,($star!=""),'t.servic_time_star>=',$star.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'t.servic_time_end<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'t.service_name,t.order_num',$keywords,''); 
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date; 
        $data['star'] = $star;
        $data['end'] = $end; 
        $data['server_state'] = BaseCode::model()->getCode(1513);
        $data['order_state'] = BaseCode::model()->getCode(1166);
        $data['stype'] = QmddServerUsertype::model()->getType($type);
        parent::_list($model, $criteria, $viewfile, $data);
    }
    //动动约-取消订单
    public function actionCancel($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('cancelled'=>1,'cancel_type'=>502));
                QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=1 and s_name_id='.$d);
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }

    public function actionIndex_game($keywords = '',$game_id='',$data_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where_club_project('supplier_id','');
        $criteria->condition.=' and order_type=351';
        $criteria->condition=get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
        $criteria->condition=get_like($criteria->condition,'service_name',$keywords,'');
        $criteria->order = 'id DESC';
        $sec=get_where_club_project('game_club_id','');
        $data = array();
        $data['game_id'] = GameList::model()->findAll($sec.' and game_state<>149 and state=2 and datediff(now(),game_time_end)<7 ');
        $data['is_pay'] = BaseCode::model()->getCode(462);
        parent::_list($model, $criteria, 'index_game', $data);
    }

    public function actionData_id($game_id){
        $data = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');  // .' and exists(select * from game_list gl where t.game_id=gl.id and gl.game_time>now())'
        $row = array();
        if(!empty($data)){
            foreach($data as $d => $val){
                // array_push($row,[$d->id,$d->game_data_name]);
                $row[$d]['id'] = $val->id;
                $row[$d]['game_data_name'] = $val->game_data_name;
            }
        }
        echo CJSON::encode($row);
    }
	
	public function actionIndex_server_amount($keywords = '',$start='',$end='',$state='',$server_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		if($start=='' && $end==''){
			$start=date('Y-m-d');
		}
		$criteria->condition=get_where_club_project('supplier_id','');
		$criteria->condition.=' and order_type=353 and is_pay=464';
		$criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
		$criteria->condition=get_where($criteria->condition,!empty($server_type),'t_stypeid',$server_type,'');
        $criteria->condition=get_like($criteria->condition,'data_name',$keywords,'');
		$criteria->condition=get_where($criteria->condition,($start!=""),'add_time>=',$start,'"');
        $criteria->condition=get_where($criteria->condition,($end!=""),'add_time<=',$end,'"');
		$criteria->select='id id,service_code service_code,t_stypename t_stypename,data_name data_name,sum(buy_count) count , sum(buy_price) amount,qmdd_server_set_list_id qmdd_server_set_list_id';
        $criteria->order = 'id DESC';
		$data = array();
		$data['state'] = BaseCode::model()->getCode(370);
		$data['is_pay'] = BaseCode::model()->getCode(462);
		$data['server_type_list']=QmddServerUsertype::model()->findAll();
		$data['start']=$start;
		$data['end']=$end;
		$data['end']=$end;
		$data['state_v']=$state;
		$data['server_type']=$server_type;
        parent::_list($model, $criteria, 'index_server_amount', $data);
    }
	
	public function actionLog($list_id=0,$state=0,$start='',$end='',$typeId=0) {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        $criteria->condition= 'qmdd_server_set_list_id='.$list_id.' and order_type=353 and is_pay=464';
		$criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
		$criteria->condition=get_where($criteria->condition,!empty($typeId),'t_stypeid',$typeId,'');
		$criteria->condition=get_where($criteria->condition,($start!=""),'add_time>=',$start,'"');
        $criteria->condition=get_where($criteria->condition,($end!=""),'add_time<=',$end,'"');
        $criteria->order = 'add_time ASC';
        $data = array();
		
        parent::_list($model, $criteria, 'log', $data,20);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $basepath = BasePath::model()->getPath(130);
            //$model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    //动动约服务预订数据详情
    public function actionUpdate_server($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update_server', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    //赛事服务报名详情
    public function actionUpdate_game($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update_game', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    // 服务签到管理列表  $sign_on=1：签到管理 $sign_on=2：待签到 $sign_on=3：未签到
    public function actionSignin_index($keywords='',$t_stypeid='',$project_id='',$servic_time_star='',$servic_time_end='',$sign_on='1') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $servic_time_star = empty($servic_time_star) ? date("Y-m-d") : $servic_time_star;
        $servic_time_end = empty($servic_time_end) ? date("Y-m-d") : $servic_time_end;
        $criteria = new CDbCriteria;
        $supplier_id = get_where_club_project('supplier_id');
        $act = ' and (sign_come>"0000-00-00 00:00:01" or is_invalid>1)';
        $acy = ' and order_type=353 and state=2 and is_pay=464';
        $acr = ' and (sign_come<"0000-00-00 00:00:01" or sign_come is null) and is_invalid=1';
        $acn = $acr.' and servic_time_star>"'.date("Y-m-d H:i:s").'"';  // sign_on=2
        $acm = $acr.' and servic_time_star<"'.date("Y-m-d H:i:s").'"';  // sign_on=3
        if($sign_on==2) $act = $acn;
        if($sign_on==3) $act = $acm;
        $str = ($sign_on==1) ? 'sign_come' : 'servic_time_star';
        $ste = ($sign_on==1) ? 'sign_come' : 'servic_time_end';
        $criteria->condition = $supplier_id.$acy.$act;
        $criteria->condition = get_where($criteria->condition,!empty($t_stypeid),'t_stypeid',$t_stypeid,"");
        $criteria->condition = get_where($criteria->condition,!empty($project_id),'project_id',$project_id,"");
        $criteria->condition = get_where($criteria->condition,!empty($servic_time_star),'left('.$str.',10)>="'.$servic_time_star.'"',"");
        $criteria->condition = get_where($criteria->condition,!empty($servic_time_end),'left('.$ste.',10)<="'.$servic_time_end.'"',"");
        $criteria->condition = get_like($criteria->condition,'order_num,gf_name,contact_phone',$keywords,'');
        $criteria->order = 'service_name';
        $data = array();
        $data['keywords'] = $keywords;
        $data['startDate'] = $servic_time_star;
        $data['endDate'] = $servic_time_end;
        $data['t_stypeid'] = QmddServerUsertype::model()->findAll();
        $data['project_id'] = ProjectList::model()->getProject();
        $data['count1'] = $model->count($supplier_id.$acy.$acn);
        $data['count2'] = $model->count($supplier_id.$acy.$acm);
        parent::_list($model, $criteria, 'signin_index', $data);
    }

    // 赛事签到管理列表
    public function actionSignin_game_index($keywords='',$servic_time_star='',$servic_time_end='',$game_id='',$data_id='',$is_sign='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id');
        $criteria->condition .= ' and order_type=351 and is_pay=464 and state=2 and order_type<>1173 and servic_time_end>=now()';
        // $criteria->condition .= ' and ((sign_come is not null or sign_come<>"0000-00-00 00:00:00") or (sign_code is not null))';
        if($is_sign==648){
            $criteria->condition .= ' and (sign_come is not null or sign_come<>"0000-00-00 00:00:00")';
        } else if($is_sign==649){
            $criteria->condition .= ' and (sign_come is null or sign_come="0000-00-00 00:00:00")';
        } else{
            $criteria->condition .= ' and ((sign_come is not null or sign_come<>"0000-00-00 00:00:00") or (sign_code is not null))';
        }
        $criteria->condition = get_where($criteria->condition,!empty($servic_time_star),'left(servic_time_star,10)>="'.$servic_time_star.'"',"");
        $criteria->condition = get_where($criteria->condition,!empty($servic_time_end),'left(servic_time_end,10)<="'.$servic_time_end.'"',"");
        $criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
        $criteria->condition = get_like($criteria->condition,'order_num,gf_name,contact_phone',$keywords,'');
        $criteria->order = 'service_data_id,order_num';
        $data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and state=2 and game_state<>149 and game_online=649 and game_time_end>=now()');
        $data['count1'] = $model->count(get_where_club_project('supplier_id').' and state=2 and is_pay=464 and order_type=351 and (sign_come is null or sign_come="0000-00-00 00:00:00") and servic_time_star>=now()');
        parent::_list($model, $criteria, 'signin_game_index', $data);
    }

    // 赛事待签到
    public function actionSignin_game_stat_index($keywords='',$servic_time_star='',$servic_time_end='',$game_id='',$data_id=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and servic_time_star>now()';
        $criteria->condition .= ' and order_type=351 and is_pay=464 and state=2 and order_type<>1173 and (sign_come is null or sign_come="0000-00-00 00:00:00")';
        $criteria->condition = get_where($criteria->condition,!empty($servic_time_star),'left(servic_time_star,10)>="'.$servic_time_star.'"',"");
        $criteria->condition = get_where($criteria->condition,!empty($servic_time_end),'left(servic_time_end,10)<="'.$servic_time_end.'"',"");
        $criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
        $criteria->condition = get_like($criteria->condition,'order_num,gf_name,contact_phone',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $s2 = GfServiceData::model()->findAll($criteria);
        $arr = toArray($s2,'id');
        $data['arr'] = $arr;
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and state=2 and game_state<>149 and game_online=649 and game_time_end>=now()');
        parent::_list($model, $criteria, 'signin_game_stat_index', $data);
    }

    // 点击签到
    public function actionSave_Sourcer($id,$is_invalid){
        $count = explode(',',$id);
        $adminid = get_session('admin_user_id');
        $admin_name = get_session('admin_name');
        $data = array();
        foreach($count as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $achie = QmddAchievemen::model()->findAll('f_type='.$model->order_type);
            $orderInfo = MallSalesOrderData::model()->find('orter_item=757 and gf_service_id='.$model->id.' and order_num="'.$model->info_order_num.'"');
            if(!empty($achie))foreach($achie as $v){
                $data1 = array();
                $achie_data = QmddAchievemenData::model()->find('gf_service_data_id='.$model->id.' and f_achievemenid='.$v->f_id);
                if(empty($achie_data)){
                    $achie_data = new QmddAchievemenData();
                    $achie_data->isNewRecord=true;
                    unset($achie_data->f_id);
                }
                $data1['f_id'] = (empty($achie_data)) ? '' : $achie_data->f_id;
                $data1['order_type'] = $model->order_type;
                $data1['order_type_name'] = $model->order_type_name;
                $data1['service_id'] = $model->service_id;
                $data1['service_code'] = $model->service_code;
                $data1['service_ico'] = $model->service_ico;
                $data1['service_name'] = $model->service_name;
                $data1['service_data_id'] = $model->service_data_id;
                $data1['service_data_name'] = $model->service_data_name;
                $data1['gf_id'] = $model->gfid;
                $data1['f_achievemenid'] = $v->f_id;
                $data1['gf_service_data_id'] = $model->id;
                $data1['service_order_num'] = $model->order_num;
                $data1['club_id'] = $model->supplier_id;
                if(!empty($orderInfo)){
                    $data1['order_num_id'] = $orderInfo->id;
                }
                $data[] = $data1;
                // $sf=$achie_data->save();
            }
      
                $basepath=BasePath::model()->getPath(191);
                $pic=$basepath->F_WWWPATH.$model->service_ico;
                $title=$model->service_name;
                $content='您预订的服务'.$model->service_data_name.$model->service_name.'于'.$model->sign_come.'签到成功';
                $content_html = '<font>'.$model->service_data_name.'</font><br><font>您已签到成功，请按时参加比赛。</font><br><font>点击本条信息进入详情界面</font><br>';
                $url='';
                $type_id=23;
                $datas=array(array('order_num'=>$model->order_num));
                $sendArr=array('type'=>'【动动约签到通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'content_html'=>$content_html,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                game_audit($model->supplier_id,$model->gfid,$sendArr);
            // }
        }
        GfServiceData::model()->updateAll([
                'sign_come' => date('Y-m-d H:i:s'),
                'order_state' => 1171,
                'is_invalid' => $is_invalid,
                'adminid' => $adminid,
                'admin_name' => $admin_name,
            ],
            'id in('.$id.')'
        );
        batch_update_datas('qmdd_achievemen_data',$data);
        show_status($sn,'签到成功',Yii::app()->request->urlReferrer,'失败');
    }

    // 资源服务预定统计列表
    public function actionService_stat_index($project_id='',$server_type='', $s_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $s_date=empty($s_date) ? date('Y-m') : $s_date;
        $criteria = new CDbCriteria;;
        $criteria->condition = 'order_type=353 and is_pay=464';
        $criteria->condition=get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($server_type),'t_stypeid',$server_type,'');
        $criteria->order='project_id';
        $criteria->select='project_id,project_name,t_stypeid,t_stypename,service_id,service_name,data_id,data_name,sum(if(isnull(sign_come),1,0)) count1, sum(if(isnull(sign_come),0,1)) count2';
        $criteria->condition .= ' AND left(servic_time_star,7)="'.$s_date.'"';
        $data = array();
		$data['project_id'] = ProjectList::model()->getAll();
        $data['server_type_list']=QmddServerUsertype::model()->findAll();
        $data['nowDate']=$s_date;
        parent::_list($model, $criteria, 'service_stat_index', $data);
    }

    // 资源服务预定统计详情
    public function actionService_stat_update($id,$projectId,$typeId,$date) {
        $model = GfServiceData::model();
        $criteria = New CDbCriteria;
        $criteria->condition = 'order_type=353 and is_pay=464';
        $criteria->condition = get_where($criteria->condition,!empty($id),'service_id',$id,'');
        $criteria->condition = get_where($criteria->condition,!empty($projectId),'project_id',$projectId,'');
        $criteria->condition = get_like($criteria->condition,'t_stypeid',$typeId,'');
        $criteria->order='service_name';
        $criteria->condition .= ' AND left(servic_time_star,7)="'.$date.'"';
        $data = array();
        parent::_list($model, $criteria, 'service_stat_update', $data);
    }
    // 会员服务预定统计列表
    public function actionMember_stat_index($project_id='',$server_type='',$s_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $s_date=empty($s_date) ? date('Y-m') : $s_date;
        $criteria = new CDbCriteria;;
        $criteria->condition = 'order_type=353 and is_pay=464';
        $criteria->condition=get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($server_type),'t_stypeid',$server_type,'');
        $criteria->order='project_id';
        $criteria->select='project_id,project_name,t_stypeid,t_stypename,gfid,gf_account,gf_name,sum(if(isnull(sign_come),1,0)) count1, sum(if(isnull(sign_come),0,1)) count2';
        $criteria->group='project_id,t_stypeid,gf_account';
        $criteria->condition .= ' AND left(servic_time_star,7)="'.$s_date.'"';
        $data = array();
		$data['project_id'] = ProjectList::model()->getAll();
        $data['server_type_list']=QmddServerUsertype::model()->findAll();
        $data['nowDate']=$s_date;
        parent::_list($model, $criteria, 'member_stat_index', $data);
    }
    // 会员服务预定统计详情
    public function actionMember_stat_update($id,$projectId,$typeId,$date) {
        $model = GfServiceData::model();
        $criteria = New CDbCriteria;
        $criteria->condition = 'gfid='.$id.' and order_type=353 and is_pay=464';
        $criteria->condition = get_where($criteria->condition,!empty($projectId),'project_id',$projectId,'');
        $criteria->condition = get_where($criteria->condition,!empty($typeId),'t_stypeid',$typeId,'');
        $criteria->order='service_name';
        $criteria->condition .= ' AND left(servic_time_star,7)="'.$date.'"';
        $data = array();
        parent::_list($model, $criteria, 'member_stat_update', $data);
    }

    // 赛事报到管理列表
    public function actionEvents_signin_index($keywords='',$game_id=0) {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->order='order_num';
        $criteria->condition = 'service_id='.$game_id.' and order_type=351 and is_pay=464';
        $criteria->condition = get_like($criteria->condition,'order_num',$keywords,"");
        $data = array();
        $data['game_id']=$game_id;
        parent::_list($model, $criteria, 'events_signin_index', $data);
    }

    // 服务收费明细表（业务与社区同时使用）
    public function actionIndex_server_detail($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where($criteria->condition,!empty($start_date),'servic_time_star>=',$start_date,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_date),'servic_time_end<=',$end_date,'"');
        $criteria->condition = get_like($criteria->condition,'info_order_num',$keywords,"");
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_server_detail', $data);
    }

    // <--暂时不用-->
    // 动动约预订收费分类表（财务与银行对账用）
    public function actionIndex_server_resever($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where($criteria->condition,!empty($start_date),'servic_time_star>=',$start_date,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_date),'servic_time_end<=',$end_date,'"');
        $criteria->condition = get_like($criteria->condition,'info_order_num',$keywords,"");
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_server_resever', $data);
    }

    // 动动约预订收费明细表（财务结算对账使用）
    public function actionIndex_resever_detail($keywords='',$order_num='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where($criteria->condition,!empty($start_date),'servic_time_star>=',$start_date,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_date),'servic_time_end<=',$end_date,'"');
        $criteria->condition = get_like($criteria->condition,'info_order_num',$order_num,"");
        $criteria->condition = get_like($criteria->condition,'service_name',$keywords,"");
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_resever_detail', $data);
    }

    public function actionGetSignCode($id){
        $count = explode(',',$id);
        foreach($count as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->send_sign_code=649;
            $st=$model->save();
            $basepath=BasePath::model()->getPath(191);
            $pic=$basepath->F_WWWPATH.$model->service_ico;
            $title=$model->service_name;
            $content='【得闲体育】您报名参与的“'.$model->service_name.'”，请您按时签到，签到验证码'.$model->sign_code.'。';
            $content_html = '<font>'.$model->service_data_name.'</font><br><font>签到验证码：'.$model->sign_code.'，请按时签到。</font><br><font>点击本条信息进入详情界面</font><br>';
            $url='';
            $type_id=23;
            $datas=array(array('order_num'=>$model->order_num));
            $sendArr=array('type'=>'【动动约签到通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'content_html'=>$content_html,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
               game_audit($model->supplier_id,$model->gfid,$sendArr);
        };
        show_status($st,'成功',Yii::app()->request->urlReferrer,'失败');
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        $modelName = $this->model;
        $setdata=0;
		if ($_POST['submitType'] == 'shenhe') {
			$model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else if ($_POST['submitType'] == 'quxiao') {
            $model->state = 374;
			if($model->order_type==353){ $setdata=1;}
        } else {
            $model->state = 721;
        }
        $st=$model->save();
        if($setdata==1){
			$this->update_set_data($model->service_data_id);
		}
      // $errors = array();
     
	  show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }
	
	public function update_set_data($set_id){
        $set_data=QmddServerSetData::model()->find('id='.$set_id);
		$set_data->order_gfid=0;
		$set_data->save();
    }
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    // 报名缴费通知
    public function actionPay_notice($keywords='',$game_id='',$data_id=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and order_type=351 and state=2 and is_pay=463 and servic_time_end>now()';
        $criteria->condition .= ' and ((shopping_order_num is not null and shopping_order_num<>""))';  //  or (buy_price=0 or buy_price is null)
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'gf_name,gf_account',$keywords,'');
        $criteria->order = 'udate';
     	$data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
        $col = get_where_club_project('supplier_id').' and order_type=351 and state=2 and is_pay=463';  //  and servic_time_star>now()
        $col .= ' and ((shopping_order_num is null or shopping_order_num="") and (sending_notice_time is null or sending_notice_time="0000-00-00 00:00:00"))';
        $data['count1'] = $model->count($col);
		parent::_list($model,$criteria,'pay_notice',$data);
	}

    // 报名缴费待通知
    public function actionPay_stay_notice($keywords='',$game_id='',$data_id=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and order_type=351 and state=2 and is_pay=463';  //  and servic_time_star>now()
        $criteria->condition .= ' and ((shopping_order_num is null or shopping_order_num="") and (sending_notice_time is null or sending_notice_time="0000-00-00 00:00:00"))';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'gf_name,gf_account',$keywords,'');
        $criteria->order = 'udate DESC';
 		$data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		parent::_list($model,$criteria,'pay_stay_notice',$data);
    }

    // 缴费确认
    public function actionPay_confirm($keywords='',$game_id='',$data_id=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and order_type=351 and state=2 and is_pay=464 and pay_confirm=1';  //  and servic_time_star>now()
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'gf_account',$keywords,'');
        $criteria->order = 'sending_notice_time DESC';
        $data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and if_del=510');  //  and Signup_date_end>now()
        $data['count1'] = $model->count(get_where_club_project('supplier_id').' and order_type=351 and state=2 and is_pay=464 and pay_confirm=0');  //  and servic_time_star>now()
        parent::_list($model,$criteria,'pay_confirm',$data);
    }

    // 缴费待确认
    public function actionPay_stay_confirm($keywords='',$game_id='',$data_id=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and order_type=351 and state=2 and is_pay=464 and pay_confirm=0';  //  and servic_time_star>now()
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'gf_account',$keywords,'');
        $criteria->order = 'state_time';
        $data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and if_del=510');  //  and Signup_date_end>now()
        parent::_list($model,$criteria,'pay_stay_confirm',$data);
    }

    // 通知缴费
    public function actionNotice($id,$radio){
        $modelName = $this->model;
        $ex = explode(',',$id);
        $r = 0;
        foreach($ex as $d){
            $model = $this->loadModel($d, $modelName);
            $money = ($radio==0) ? $model->buy_price : '';
            $model->free_make = $radio;
            $model->free_money = $money;
            $model->is_pay = ($radio==0) ? 464 : $model->is_pay;
            $model->order_state = ($radio==0) ? 1462 : $model->order_state;
            $r = $model->save();
            $code = ($radio==1 && $money>0) ? 314 : 315;
            $this->save_shopping($model,$radio,$code,$model->buy_price);
            if($radio==0){
                $this->update_signlist($model);
            }
        }
        show_status($r,'发送成功',Yii::app()->request->urlReferrer,'发送失败');
    }

    // 取消通知
    public function actionUnnotice($id){
        $modelName = $this->model;
        $len = explode(',',$id);
        $sv = 0;
        foreach($len as $d){
            $model = $this->loadModel($d, $modelName);
            if($model->is_pay==463){
                Carinfo::model()->deleteAll('order_num="'.$model->shopping_order_num.'"');
                CardataCopy::model()->deleteAll('order_num="'.$model->shopping_order_num.'"');
                $model->shopping_order_num = '';
                $model->sending_notice_time = '';
                $sv = $model->save();
            }
        }
        show_status($sv,'撤销成功',Yii::app()->request->urlReferrer,'已支付，撤销失败',Yii::app()->request->urlReferrer);
    }

    // 免单更新支付状态
    function update_signlist($model){
        GameSignList::model()->updateAll(array('is_pay'=>464),'order_num="'.$model->order_num.'"');
        GameTeamTable::model()->updateAll(array('is_pay'=>464),'order_num="'.$model->order_num.'"');
    }

    // 确认缴费
    public function actionClickStar($id){
        $modelName = $this->model;
        $ex = explode(',',$id);
        $r = 0;
        foreach($ex as $d){
            $model = $this->loadModel($d, $modelName);
            $model->pay_confirm = 1;
            $model->pay_confirm_time = date('Y-m-d H:i:s');
            $model->order_state = 1170;
            $model->save();
            $game_list = GameList::model()->find('id='.$model->service_id);
            $game_data = GameListData::model()->find('id='.$model->service_data_id);
            $sign_list = GameSignList::model()->find(
                'sign_game_id='.$model->service_id.
                ' and order_num="'.$model->order_num.'"'.
                ' and sign_game_data_id='.$model->service_data_id.
                ' and sign_account="'.$model->gf_account.'" and if_del=510'
            );
            $game_table = GameTeamTable::model()->find(
                'game_id='.$model->service_id.
                ' and order_num="'.$model->order_num.'"'.
                ' and sign_game_data_id='.$model->service_data_id.
                ' and create_account="'.$model->gf_account.'" and state=2'
            );
            if(!empty($sign_list) && $game_data->game_player_team==665){
                $sign_list->updateByPk($sign_list->id,array('pay_confirm'=>1,'pay_confirm_time'=>$model->pay_confirm_time));
            }
            else if(!empty($game_table) && $game_data->game_player_team!=665){
                GameSignList::model()->updateAll(array('pay_confirm'=>1,'pay_confirm_time'=>$model->pay_confirm_time),'team_id='.$game_table->id);
                $game_table->updateByPk($game_table->id,array('pay_confirm'=>1,'pay_confirm_time'=>$model->pay_confirm_time));
            }
            if($game_data->game_player_team==665){
            	$foot=new GfUserFoot();
            	unset($foot->id);
            	$foot->GF_ID=$model->gfid;
            	$foot->content='报名参加了“'.$model->service_name.'”';
            	$foot->time=$model->pay_confirm_time;
            	$foot->save();
                $this->notice($model->gfid,$model->gf_account,$model->service_name,$model->service_data_id,$model->service_data_name,$model->order_num,$model->service_ico,315,1);
                $r++;
            }
            else{
                $sl = GameSignList::model()->findAll('team_id='.$game_table->id.' and order_num="'.$model->order_num.'"');
                if(!empty($sl))foreach($sl as $s){
	            	$foot=new GfUserFoot();
	            	unset($foot->id);
	            	$foot->GF_ID=$s->sign_gfid;
	            	$foot->content='报名参加了“'.$model->service_name.'”';
	            	$foot->time=$model->pay_confirm_time;
	            	$foot->save();
                    $this->notice($s->sign_gfid,$s->sign_account,$s->sign_game_name,$s->sign_game_data_id,$s->games_desc,$s->order_num,$game_list->game_small_pic,315,1);
                    $r++;
                }
            }

            // 赛事报名确认之后学员及归属单位兑换消费积分
            $credit_set=GfCredit::model()->find('object=1476 and item_type=351 and consumer_type=210');
            if(!empty($credit_set)){
                $total_money=$model->buy_price-$model->free_money;
                
                if(round($total_money/($credit_set->value/$credit_set->credit))>0){
                    $gl = new GfCreditHistory();
                    $gl->isNewRecord = true;
                    unset($gl->id);
                    $gl->object=209;
                    $gl->gf_id=$model->gfid;
                    $gl->get_object=209;
                    $gl->get_id=$model->gfid;
                    $gl->item_code=$credit_set->id;
                    $gl->service_source=$model->order_type_name;
                    $gl->order_num=$model->info_order_num;
                    $gl->add_or_reduce=1;
                    $gl->credit=round($total_money/($credit_set->value/$credit_set->credit));
                    $gl->add_time=date('Y-m-d H:i:s');
                    $gl->save();
                }

                $cList=ClubMemberList::model()->findAll('!isnull(club_id) and member_gfid='.$model->gfid.' and member_project_id='.$model->project_id);
                if(!empty($cList))foreach($cList as $t){
                    $club=ClubList::model()->find('id='.$t->club_id);
                    $cr=0;
                    if($club->club_type==8){
                        $cr=$total_money/($credit_set->sqdw_value/$credit_set->sqdw_gredit);
                    }elseif($club->club_type==9){
                        $cr=$total_money/($credit_set->sjyj_value/$credit_set->sjyj_gredit);
                    }elseif($club->club_type==189){
                        $cr=$total_money/($credit_set->zlhb_value/$credit_set->zlhb_gredit);
                    }
                    if(round($cr)>0){
                        $hl = new GfCreditHistory();
                        $hl->isNewRecord = true;
                        unset($hl->id);
                        $hl->object=502;
                        $hl->gf_id=$t->club_id;
                        $hl->get_object=209;
                        $hl->get_id=$model->gfid;
                        $hl->item_code=$credit_set->id;
                        $hl->service_source=$model->order_type_name;
                        $hl->order_num=$model->info_order_num;
                        $hl->add_or_reduce=1;
                        $hl->credit=round($cr);
                        $hl->add_time=date('Y-m-d H:i:s');
                        $hl->save();
                    }
                }
            }
        }
        show_status($r,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
	 * 生成购物车信息，
	 */
	function save_shopping($model,$radio,$code,$money){
        if($radio==1 && $money>0){
            $game_list = GameList::model()->find('id='.$model->service_id);
            $base_code = BaseCode::model()->find('f_id=351');
            $sign_level = ClubMemberList::model()->find('gf_account='.$model->gf_account.' and member_project_id='.$model->project_id.' and club_status=337');
            
	        $order_data=array('order_type'=>351
	        	,'buyer_type'=>210
		        ,'order_gfid'=>$model->gfid
		        ,'money'=>$model->buy_price
		        ,'order_money'=>$model->buy_price
		        ,'total_money'=>$model->buy_price
		        ,'effective_time'=>$game_list->effective_time);
			$add_order=Carinfo::model()->addOrder($order_data);
			if(empty($add_order['order_num'])){
				$sv=0;
			}else{
				$sv=1;
				GfServiceData::model()->updateByPk($model->id,array('shopping_order_num'=>$add_order['order_num'],'effective_time'=>$game_list->effective_time));
	            // 购物车详细
	            $cat_copy = new Cardata();
	            $cat_copy->isNewRecord = true;
	            unset($cat_copy->id);
	            $cat_copy->order_num = $add_order['order_num'];
	            $cat_copy->order_type = 351;
	            $cat_copy->order_type_name = $base_code->F_NAME;
	            $cat_copy->supplier_id = $game_list->game_club_id;
	            $cat_copy->buy_price = $model->buy_price;  // 商品单价
	            $cat_copy->buy_amount = $model->buy_price;  // 购买实际金额
	            $cat_copy->project_id = $model->project_id;
	            $cat_copy->project_name = $model->project_name;
	            $cat_copy->buy_level = $sign_level->project_level_id;
	            $cat_copy->buy_level_name = $sign_level->project_level_name;
	            $cat_copy->buy_count = 1;
	            $cat_copy->gfid = $model->gfid;
	            $cat_copy->gf_name = $model->gf_name;
	            $cat_copy->service_id = $game_list->id;
	            $cat_copy->service_code = $game_list->game_code;
	            $cat_copy->service_ico = $game_list->game_small_pic;
	            $cat_copy->service_name = $game_list->game_title;
	            $cat_copy->service_data_id = $model->service_data_id;
	            $cat_copy->service_data_name = $model->service_data_name;
	            $cat_copy->uDate = date('Y-m-d H:i:s');
	            $cat_copy->gf_club_id = $sign_level->club_id;
	            $cat_copy->gf_service_id = $model->id;
	            $cat_copy->effective_time = $game_list->effective_time;
	            $st=$cat_copy->save();
			}
            
        }

		// 加入购物车成功后发送缴费通知
        // $code = ($model->buy_price>0 && $radio==1) ? 314 : 315;
        $pic = BasePath::model()->get_www_path().$model->service_ico;
		$order_num = ($code==315) ? $model->order_num : $add_order['order_num'];
        $this->notice($model->gfid,$model->gf_account,$model->service_name,$model->service_data_id,$model->service_data_name,$order_num,$pic,$code,0,$radio,$money);
    }

	/**
	 * 发送缴费通知.
	 * 
	 * $gfid = 成员gfid.
	 * 
	 * $gf_account = 成员gf账号.
	 * 
	 * $service_name = 赛事名称.
	 * 
	 * $data_id = 竞赛项目id.
	 * 
	 * $data_name = 竞赛项目名称.
	 * 
	 * $order_num = 购物车订单号或服务流水号.
	 * 
	 * $pic = 赛事图标
	 * 
	 * 发314通知，前端直接跳转到订单详情界面去支付 发送购物车的order_num
	 * 
	 * 发315通知 type_id=23  前端跳转进入服务订单详情界面（赛事、裁判等）datas [{"order_num":"服务订单流水号"}] 发送服务订单号
	 * 
     * 314通知：
	 * 1、"type": "邀请函", //通知标题
	 * 2、"pic":"http://xxx.png" //图片
	 * 3、"title": "广州中数", //标题
	 * 4、"content":"内容",// 内容简要
	 * 5、"url":"http://gf41.net",//url内容链接
	 * 6、"type_id":”1”// 链接跳转类型，参考附件
	 * 7、"datas": [{"id":"91"}]// 链接类型对应内容，参考附件
	 * 8、"notify_type":"通知类型id"//目前仅type_id=10时使用
	 * {"type":"赛事通知","pic":"http://xxx.png","title":"XXXX赛事","content":"报名审核通过，快去选择项目报名吧","content_html":"通知内容，用HTML写可换行与样式","url":"http://gf41.net/xxx.html?gfid=1888",”type_id”:”3”, "datas": [{"id":"91"}]}
	 */
	function notice($gfid,$gf_account,$service_name,$data_id,$data_name,$order_num,$pic,$code,$mes=0,$radio=1,$money=0){
		$type_id = 23;
		$admin_id = get_session('admin_id');
        $type = ($mes==0) ? '【缴费通知消息】' : '【报名成功消息通知】';
        $ccos = ($mes==0) ? '恭喜您！您的赛事报名审核已通过' : '报名成功';
        $ccon = '点击本条信息进入详情界面';
		$content = '点击本条信息进入缴费界面';
        if($mes==0){
            $ccon=($radio==0) ? '报名费用为：'.$money.'/项目（已免单）。' : $content;
        }
        $s1='</font><br><font>';
		$content_html = '<font>'.$data_name.$s1.$ccos.$s1.$ccon.'</font>';
        $data= array(
            'type' => $type,
            'pic' => $pic,
            'title' => $service_name,
            'content' => $content,
            'content_html' => $content_html,
        );
        if($code==314){
            $data['order_num'] = $order_num; 
        }
		if($code==315){
            $data['datas'] =[array('order_num'=>$order_num)];
            $data['type_id']=$type_id;
		}
	
        new_message_send($code,$admin_id,$gfid,json_encode($data),0);
		GfServiceData::model()->updateAll(array('notice_content'=>$content_html,'sending_notice_time'=>date('Y-m-d H:i:s')),'service_data_id='.$data_id.' and gf_account="'.$gf_account.'"');
    }

    // 赛事列表 签到
    public function actionGame_list_sign($service_id,$service_data_id='',$keywords='',$service_state='',$back=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $gamelist = GameListData::model()->findAll('game_id='.$service_id.' and if_del=510');
        // $service_data_id = empty($service_data_id) ? 0 : $service_data_id;
        $service_data_id = (empty($service_data_id) && !empty($gamelist)) ? $gamelist[0]->id : $service_data_id;
        $criteria->condition = 'service_id='.$service_id.' and service_data_id='.$service_data_id;
        $criteria->condition = get_like($criteria->condition,'order_num,gf_name,contact_phone',$keywords,'');
        if(!empty($service_state)){
            $act = $service_state==1 ? 'sign_come<servic_time_end' : $service_state==3 ? 'sign_come>servic_time_end' : '(sign_come<"0000-00-00 00:00:01" or sign_come is null)';
            $criteria->condition .= ' and '.$act;
        }
        $criteria->order = 'field(sign_come,sign_come<servic_time_end,sign_come>servic_time_end,(sign_come<"0000-00-00 00:00:01" or sign_come is null))';
        $data = array();
        $data['data_list'] = $gamelist;
        $data['service_data_id'] = $service_data_id;
        parent::_list($model,$criteria,'game_list_sign',$data);
    }

    // 动动约签到-发送签到通知 signin_index界面
    public function actionSending_notice($id){
        $modelName = $this->model;
        $count = explode(',',$id);
        $admin_id = get_session('admin_id');
        $get_data = '';
        $s1='<font>【动动约签到通知】</font><br><font>服务流水号：';
        $s2='</font><br><font>预定服务时间：';
        $s3='</font><br><font>签到验证码<u>';
        $s4='</u>，使用服务时请提供验证码验证。</font><br><font>预定详情</font>';
        foreach($count as $d){
            $model = $this->loadModel($d, $modelName);
            $s0=$model->servic_time_star;
            $content_html =$s1.$model->order_num.$s2;
            $content_html .=substr($s0,0,10).' '.substr($s0,11,-3).'-'
            $content_html .=substr($model->servic_time_end,11,-3).$s3;
            $content_html .=$model->sign_code.$s4;
            $pic = BasePath::model()->get_www_path();

            $data = array(
                'type' => '【动动约签到通知】',
                'title' => $model->service_name,
                'pic' => $model->service_ico,
                'service_code' => $model->order_num,
                'service_type' => $model->order_type,
                'service_id' => $model->service_id,
                'service_data_id' => $model->service_data_id,
                'content' => '',
                'content_html' => $content_html,
            );
            $get_data = send_msg(335,$admin_id,$model->gfid,$data);
            $model->updateByPk($d,array('notice_content'=>$content_html,'sending_notice_time'=>date('Y-m-d H:i:s')));
        }
        if(!empty($get_data) && substr($get_data,8,12)=='发送成功'){
            echo 1;
        }
    }

    // 动动约签到管理 失效操作
    public function actionSave_invalid($id){
        $modelName = $this->model;     
        $sv = $modelName::model()->updateAll(array('is_invalid'=>2),'id in('.$id.')');
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }
}