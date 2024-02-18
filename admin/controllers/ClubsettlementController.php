<?php

class ClubsettlementController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	
    public function actionIndex($project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=721 and activity_club_id='.get_session('club_id');
        $criteria->join = "JOIN activity_list_data t2 on t2.activity_id=t.id";
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'activity_code,activity_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $criteria->group='t2.activity_id';
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionIndex_submit($project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=371 and activity_club_id='.get_session('club_id');
        $criteria->join = "JOIN activity_list_data t2 on t2.activity_id=t.id";
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'activity_code,activity_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $criteria->group='t2.activity_id';
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_submit', $data);
    }

    public function actionIndex_audit($state='',$project_id='', $start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('activity_club_id','');
        if($state==''){
            $criteria->condition .= ' and state in(2,373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }else{
            $criteria->condition .= ' and state='.$state;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
        }
        $criteria->join = "JOIN activity_list_data t2 on t2.activity_id=t.id";
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'activity_code,activity_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $criteria->group='t2.activity_id';
        $data = array();
        $data['count1'] = $model->count(get_where_club_project('activity_club_id','').' and state=371');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_audit', $data);
    }


    // 信息更改
    public function actionIndex_change($start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'ClubChangeList';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and service_type=354 and '.get_where_club_project('club_id','');
        $criteria->condition .= ' and (dispay_end_time>=now() or buy_end>=now() or end_time>=now())';
        if ($start_date != '') {
            $criteria->condition.=' and left(change_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(change_time,10)<="' . $end_date . '"';
        }
        $criteria->condition = get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'change_time DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_change', $data);
    }
    public function actionUpdate_1($id) {
        $modelName = 'ClubChangeList';
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(297);
           $model->description_temp=get_html($basepath->F_WWWPATH.$model->description_temp, $basepath);
           $data['model'] = $model;
           if (!empty($model->pic)) {
               $data['pic'] = explode(',', $model->pic);
           }
           $data['list_data'] = ClubChangeData::model()->findAll('change_id='.$model->id);
           $this->render('update_1', $data);
        } else {
          $this-> saveData($model,$_POST[$modelName]);
         }
    }

	public function actionExchange($keywords = '',$club_id='') {
        $data = array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2';
        if($club_id!=''){
            $criteria->condition .= ' and activity_club_id='.$club_id;
        }else{
            $criteria->condition .= ' and '.get_where_club_project('activity_club_id','');
        }
        $criteria->condition .= ' and (dispay_end_time>=now() or sign_up_date_end>=now() or activity_time_end>=now())';

        $criteria->condition = get_like($criteria->condition,'activity_code,activity_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        parent::_list($model, $criteria, 'exchange', $data);          
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(292);
            $model->explain_temp=get_html($basepath->F_WWWPATH.$model->explain, $basepath);
            $data['model'] = $model;
            $data['project'] = ClubProject::model()->getCode_id2(get_session('club_id'));
            $data['check_way'] = BaseCode::model()->getGameArrange2(791);
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST);
			
        }
    }
        
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(292);
            $model->explain_temp=get_html($basepath->F_WWWPATH.$model->explain, $basepath);
            $data['model'] = $model;
            if (!empty($model->activity_big_pic)) {
                $data['activity_big_pic'] = explode(',', $model->activity_big_pic);
            }
            $data['project'] = ClubProject::model()->getCode_id2(get_session('club_id'));
            $data['check_way'] = BaseCode::model()->getGameArrange2(791);
            $data['list_data'] = ActivityListData::model()->findAll('activity_id='.$model->id);
            $this->render('update', $data);
            
        } else {
			$this-> saveData($model,$_POST);
        }
    }

	function saveData($model,$post) {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        if ($_POST['submitType'] == 'genggai') {
            $model->change_time = date('Y-m-d H:i:s');
            $model->change_adminid = get_session('admin_id');
            $model->change_adminname = get_session('admin_name');
        }else{
            $model->state = get_check_code($_POST['submitType']);
        }
        $url=get_cookie('_currentUrl_');
		if ($_POST['submitType'] == 'shenhe') {
            $yes='提交审核成功';
            $no='提交审核失败';
        } else if ($_POST['submitType'] == 'baocun') {
            $yes='保存成功';
            $no='保存失败';
        } else if ($_POST['submitType'] == 'quxiao') {
            $yes='撤销成功';
            $no='撤销失败';
        } else if ($_POST['submitType'] == 'tongguo' || $_POST['submitType'] == 'butongguo') {
            $yes='操作成功';
            $no='操作失败';
            $model->audit_time = date('Y-m-d H:i:s');
            $model->adminid = get_session('admin_id');
            $model->adminname = get_session('admin_name');
        } else if ($_POST['submitType'] == 'cxbj') {
            $yes='重新编辑成功';
            $no='重新编辑失败';
            $url = Yii::app()->request->urlReferrer;
        } else {
            $yes='操作成功';
            $no='操作失败';
        }
        $st=$model->save();
        if($st==1){
            $this->save_data($model);
            if($model->state==371){
                $this->change_data($model);
            }elseif($model->state==2 || $model->state==373){
                $model->save_set($model);
                
                if ($_POST['submitType'] != 'genggai') {
                    if($model->state==2){
                        $m_message=$model->activity_title.'活动审核已通过';
                        $content=$model->activity_title.'活动审核已通过';
                    }elseif($model->state==373){
                        $m_message=$model->activity_title.'活动审核未通过';
                        $content=$model->activity_title.'活动审核未通过';
                    }
                    $basepath=BasePath::model()->getPath(123); 
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;

                    $title='【审核通知】';
                    $url2='';
                    $type_id=5;
                    $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url2,'type_id'=>$type_id);
                    backstage_send_message(get_session('admin_id'),$model->activity_club_code,$m_message,$title,315,'B'.$model->activity_club_code,$sendArr);
                }else{
                    $this->change_data($model);
                }
            }
        }
	    show_status($st, $yes, $url, $no); 
    }
    
    public function save_data($model){
        $modelName = $this->model;
        if(!empty($_POST[$modelName]['remove_data_ids'])){
            ActivityListData::model()->deleteAll('id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
            MallPriceSetDetails::model()->deleteAll('service_data_id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
            MallPricingDetails::model()->deleteAll('service_data_id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
        }
        if(!empty($_POST['add_tag'])){
            foreach($_POST['add_tag'] as $v){
                $data=ActivityListData::model()->find('id='.$v['data_id']);
                if(empty($data)){
                    $data=new ActivityListData();
                    $data->isNewRecord = true;
                    unset($data->id);
                }
                $data->activity_id = $model->id;
                $data->project_id = $v['project_id'];
                $data->activity_content = $v['activity_content'];
                $data->activity_money = $v['activity_money'];
                $data->apply_number = $v['apply_number'];
                $data->apply_check_way = $v['apply_check_way'];
                $data->min_age = $v['min_age'];
                $data->max_age = $v['max_age'];
                $data->activity_time = $v['activity_time'];
                $data->activity_time_end = $v['activity_time_end'];
                $st=$data->save();
            }
        }
    }
    
    // 添加信息更改记录
    public function change_data($model){
        if($model->state==371){
            $cList=ClubChangeList::model()->find('service_type=352 and service_id='.$model->id);
        }
        if(empty($cList)){
            $cList=new ClubChangeList();
            $cList->isNewRecord = true;
            unset($cList->id);
        }
        $cList->service_type = 354;
        $cList->service_id = $model->id;
        $cList->code = $model->activity_code;
        $cList->title = $model->activity_title;
        $cList->logo = $model->activity_small_pic;
        $cList->pic = $model->activity_big_pic;
        $cList->club_id = $model->activity_club_id;
        $cList->description = $model->explain;
        $cList->if_live = $model->activity_online;
        $cList->dispay_start_time = $model->dispay_star_time;
        $cList->dispay_end_time = $model->dispay_end_time;
        $cList->buy_start = $model->sign_up_date;
        $cList->buy_end = $model->sign_up_date_end;
        $cList->start_time = $model->activity_time;
        $cList->end_time = $model->activity_time_end;
        $cList->apply_way = $model->activity_apply_way_referee;
        $cList->address = $model->activity_address;
        $cList->GPS = $model->navigatio_address;
        $cList->men = $model->local_men;
        $cList->phone = $model->local_and_phone;
        $cList->organizational = $model->organizational;
        $cList->longitude = $model->Longitude;
        $cList->latitude = $model->latitude;
        $cList->state = $model->state;
        $cList->change_adminid = get_session('admin_id');
        $cList->change_time = date('Y-m-d H:i:s');
        $st=$cList->save();
        
        if($st==1){
            $activityData=ActivityListData::model()->findAll('activity_id='.$model->id);
            foreach($activityData as $d){
                $cData=ClubChangeData::model()->find('change_id='.$cList->id.' and data_id='.$d->id);
                if(empty($cData)){
                    $cData=new ClubChangeData();
                    $cData->isNewRecord = true;
                    unset($cData->id);
                }
                $cData->change_id = $cList->id;
                $cData->data_id = $d->id;
                $cData->project_id = $d->project_id;
                $cData->content = $d->activity_content;
                $cData->money = $d->activity_money;
                $cData->apply_number = $d->apply_number;
                $cData->apply_check_way = $d->apply_check_way;
                $cData->min_age = $d->min_age;
                $cData->max_age = $d->max_age;
                $cData->start_time = $d->activity_time;
                $cData->end_time = $d->activity_time_end;
                $st=$cData->save();
            }
        }
    }
    


    // 活动结算统计
    public function actionindex_stat($start = '', $activity_title='', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 
        $criteria->condition = get_where_club_project('activity_club_id').' and state=2';
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(sign_up_date,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(sign_up_date,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'activity_title',$activity_title,'');
        $criteria->condition = get_like($criteria->condition,'activity_code,activity_club_code,activity_club_name',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_stat', $data);
    }

    //逻辑删除
    public function actionDelete($id) {
        
        ActivityListData::model()->deleteAll('activity_id in('.$id.')');
        parent::_clear($id);
    }   

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

