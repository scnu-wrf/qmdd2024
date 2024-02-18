<?php

class ClubStoreTrainController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    // 发布培训
    public function actionIndex($train_type='', $train_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_state=721 and train_clubid='.get_session('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($train_type),' train_type1_id',$train_type,''); 
        if($train_classify!='' || $project_id!=''){
            $criteria->join = "JOIN club_train_data t2 on t2.train_id=t.id";
        }
        if($train_classify!=''){
            $criteria->join .= " and t2.type_id=".$train_classify;
        }
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'train_code,train_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        if($train_classify!='' || $project_id!=''){
            $criteria->group='t2.train_id';
        }
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['train_type'] = ClubStoreType::model()->findAll('f_id in(1504,1505) and if_del=510');
        $data['train_classify'] = ClubStoreType::model()->findAll('fater_id in('.($train_type==''?'-1':$train_type).') and if_del=510');
        parent::_list($model, $criteria, 'index', $data);
    }

    // 待审核列表
    public function actionIndex_submit($train_type='', $train_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_state=371 and train_clubid='.get_session('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($train_type),' train_type1_id',$train_type,''); 
        if($train_classify!='' || $project_id!=''){
            $criteria->join = "JOIN club_train_data t2 on t2.train_id=t.id";
        }
        if($train_classify!=''){
            $criteria->join .= " and t2.type_id=".$train_classify;
        }
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'train_code,train_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        if($train_classify!='' || $project_id!=''){
            $criteria->group='t2.train_id';
        }
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['train_type'] = ClubStoreType::model()->findAll('f_id in(1504,1505) and if_del=510');
        $data['train_classify'] = ClubStoreType::model()->findAll('fater_id in('.($train_type==''?'-1':$train_type).') and if_del=510');
        parent::_list($model, $criteria, 'index_submit', $data);
    }

    // 发布审核
    public function actionIndex_audit($state='', $train_type='', $train_classify='', $project_id='', $start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('train_clubid','');
        if($state==''){
            $criteria->condition .= ' and train_state in(2,373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }else{
            $criteria->condition .= ' and train_state='.$state;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($train_type),' train_type1_id',$train_type,''); 
        if($train_classify!='' || $project_id!=''){
            $criteria->join = "JOIN club_train_data t2 on t2.train_id=t.id";
        }
        if($train_classify!=''){
            $criteria->join .= " and t2.type_id=".$train_classify;
        }
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'train_code,train_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        if($train_classify!='' || $project_id!=''){
            $criteria->group='t2.train_id';
        }
        $data = array();
        $data['count1'] = $model->count(get_where_club_project('train_clubid','').' and train_state=371');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['train_type'] = ClubStoreType::model()->findAll('f_id in(1504,1505) and if_del=510');
        $data['train_classify'] = ClubStoreType::model()->findAll('fater_id in('.($train_type==''?'-1':$train_type).') and if_del=510');
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_audit', $data);
    }

    // 取消/审核未通过列表
    public function actionIndex_not_pass($start_date = '', $end_date = '', $train_type='', $train_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_state=373 and '.get_where_club_project('train_clubid');
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($train_type),' train_type1_id',$train_type,''); 
        if($train_classify!='' || $project_id!=''){
            $criteria->join = "JOIN club_train_data t2 on t2.train_id=t.id";
        }
        if($train_classify!=''){
            $criteria->join .= " and t2.type_id=".$train_classify;
        }
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'train_code,train_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        if($train_classify!='' || $project_id!=''){
            $criteria->group='t2.train_id';
        }
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['train_type'] = ClubStoreType::model()->findAll('f_id in(1504,1505) and if_del=510');
        $data['train_classify'] = ClubStoreType::model()->findAll('fater_id in('.($train_type==''?'-1':$train_type).') and if_del=510');
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_not_pass', $data);
    }

    // 培训列表
    public function actionIndexhd($index='', $start_date = '', $end_date = '', $train_type='', $train_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_state=2 and train_clubid='.get_session('club_id');
        if($index==1){
            $criteria->condition .= ' and (dispay_end_time>=now() or train_buy_end>=now() or train_end>=now())';
        }elseif($index==2){
            $criteria->condition .= ' and dispay_end_time<now() and train_buy_end<now() and train_end<now()';
            $start_date=empty($start_date)?date("Y-m-d", strtotime("-1 month")):$start_date;
            $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(train_start,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(train_start,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($train_type),' train_type1_id',$train_type,''); 
        if($train_classify!='' || $project_id!=''){
            $criteria->join = "JOIN club_train_data t2 on t2.train_id=t.id";
        }
        if($train_classify!=''){
            $criteria->join .= " and t2.type_id=".$train_classify;
        }
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'train_code,train_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        if($train_classify!='' || $project_id!=''){
            $criteria->group='t2.train_id';
        }
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['train_type'] = ClubStoreType::model()->findAll('f_id in(1504,1505) and if_del=510');
        $data['train_classify'] = ClubStoreType::model()->findAll('fater_id in('.($train_type==''?'-1':$train_type).') and if_del=510');
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'indexhd', $data);
    }

    // 培训查询
    public function actionIndexhv($index='', $start_date = '', $end_date = '', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_state=2 and '.get_where_club_project('train_clubid','');
        $start_date=empty($start_date)?date("Y-m-d"):$start_date;
        $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        if($index==1){
            $criteria->condition .= ' and (dispay_end_time>=now() or train_buy_end>=now() or t.train_end>=now())';
        }elseif($index==2){
            $criteria->condition .= ' and dispay_end_time<now() and train_buy_end<now() and t.train_end<now()';
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(t.train_start,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(t.train_start,10)<="' . $end_date . '"';
        }
        $criteria->join = "JOIN club_train_data t2 on t2.train_id=t.id";
        if($project_id!=''){
            $criteria->join .= " and t2.project_id=".$project_id;
        }
        $criteria->condition = get_like($criteria->condition,'train_code,train_title,train_club_code,train_clubname',$keywords,'');
        $criteria->order = 'uDate DESC';
        $criteria->group='t2.train_id';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'indexhv', $data);
    }

    // 信息更改
    public function actionIndex_change($start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'ClubChangeList';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and service_type=352 and '.get_where_club_project('club_id','');
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

	public function actionExchange($keywords = '',$club_id='') {
        $data = array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_state=2';
        if($club_id!=''){
            $criteria->condition .= ' and train_clubid='.$club_id;
        }else{
            $criteria->condition .= ' and '.get_where_club_project('train_clubid','');
        }
        $criteria->condition .= ' and (dispay_end_time>=now() or train_buy_end>=now() or train_end>=now())';

        $criteria->condition = get_like($criteria->condition,'train_code,train_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        parent::_list($model, $criteria, 'exchange', $data);          
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

    public function actionGetListData(){
        $data = ClubStoreType::model()->findAll('fater_id='.$_POST['id'].' and if_del=510');
        $ar = array();
        if(!empty($data))foreach($data as $key => $val){
            $ar[$key]['id'] = $val->id;
            $ar[$key]['classify'] = $val->classify;
        }
        echo CJSON::encode($ar);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('update');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['project'] = ClubProject::model()->getCode_id2(get_session('club_id'));
            $data['check_way'] = BaseCode::model()->getGameArrange2(791);
            $data['train_type'] = ClubStoreType::model()->getFater($_REQUEST['train_type1_id']);
            $data['store_rank'] = ClubStoreRank::model()->getFater();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(134);
           $model->train_description_temp=get_html($basepath->F_WWWPATH.$model->train_description, $basepath);
           $data['model'] = $model;
           if (!empty($model->train_pic)) {
               $data['train_pic'] = explode(',', $model->train_pic);
           }
           $data['project'] = ClubProject::model()->getCode_id2(get_session('club_id'));
           $data['check_way'] = BaseCode::model()->getGameArrange2(791);
           $data['list_data'] = ClubTrainData::model()->findAll('train_id='.$model->id);
           $data['train_type'] = ClubStoreType::model()->getFater($model->train_type1_id);
           $data['store_rank'] = ClubStoreRank::model()->getFater();
           $this->render('update', $data);
        } else {
          $this-> saveData($model,$_POST[$modelName]);
         }
    }
     
    function saveData($model,$post) {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        if ($_POST['submitType'] == 'genggai') {
            $model->change_time = date('Y-m-d H:i:s');
            $model->train_id = get_session('admin_id');
            $model->train_gfname = get_session('admin_name');
        }else{
            $model->train_state = get_check_code($_POST['submitType']);
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
            $model->train_state_adminid = get_session('admin_id');
            $model->train_state_adminname = get_session('admin_name');
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
            if($model->train_state==371){
                $this->change_data($model);
            }elseif($model->train_state==2 || $model->train_state==373){
                $model->save_set($model);
                
                if ($_POST['submitType'] != 'genggai') {
                    if($model->train_state==2){
                        $m_message=$model->train_title.'培训审核已通过';
                        $content=$model->train_title.'培训审核已通过';
                    }elseif($model->train_state==373){
                        $m_message=$model->train_title.'培训审核未通过';
                        $content=$model->train_title.'培训审核未通过';
                    }
                    $basepath=BasePath::model()->getPath(123); 
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;

                    $title='【审核通知】';
                    $url='';
                    $type_id=5;
                    $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
                    backstage_send_message(get_session('admin_id'),$model->train_club_code,$m_message,$title,315,'B'.$model->train_club_code,$sendArr);
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
            ClubTrainData::model()->deleteAll('id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
            MallPriceSetDetails::model()->deleteAll('service_data_id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
            MallPricingDetails::model()->deleteAll('service_data_id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
        }
        if(!empty($_POST['add_tag'])){
            foreach($_POST['add_tag'] as $v){
                $data=ClubTrainData::model()->find('id='.$v['data_id']);
                if(empty($data)){
                    $data=new ClubTrainData();
                    $data->isNewRecord = true;
                    unset($data->id);
                }
                $data->train_id = $model->id;
                $data->type_id = $v['type_id'];
                $data->project_id = $v['project_id'];
                $data->train_content = $v['train_content'];
                $data->train_money = $v['train_money'];
                $data->apply_number = $v['apply_number'];
                $data->apply_check_way = $v['apply_check_way'];
                $data->min_age = $v['min_age'];
                $data->max_age = $v['max_age'];
                if(!empty($v['train_time'])){
                    $data->train_time = $v['train_time'];
                }
                if(!empty($v['train_time_end'])){
                    $data->train_time_end = $v['train_time_end'];
                }
                if(!empty($v['train_identity_type'])){
                    $data->train_identity_type = $v['train_identity_type'];
                }
                if(!empty($v['train_identity_rank'])){
                    $data->train_identity_rank = $v['train_identity_rank'];
                }
                if(!empty($v['period'])){
                    $data->period = $v['period'];
                }
                $st=$data->save();
            }
        }
    }

    // 添加信息更改记录
    public function change_data($model){
        if($model->train_state==371){
            $cList=ClubChangeList::model()->find('service_type=352 and service_id='.$model->id);
        }
        if(empty($cList)){
            $cList=new ClubChangeList();
            $cList->isNewRecord = true;
            unset($cList->id);
        }
        $cList->service_type = 352;
        $cList->service_id = $model->id;
        $cList->code = $model->train_code;
        $cList->title = $model->train_title;
        $cList->logo = $model->train_logo;
        $cList->pic = $model->train_pic;
        $cList->club_id = $model->train_clubid;
        $cList->description = $model->train_description;
        $cList->type_id = $model->train_type1_id;
        $cList->if_live = $model->if_train_live;
        $cList->dispay_start_time = $model->dispay_start_time;
        $cList->dispay_end_time = $model->dispay_end_time;
        $cList->buy_start = $model->train_buy_start;
        $cList->buy_end = $model->train_buy_end;
        $cList->start_time = $model->train_start;
        $cList->end_time = $model->train_end;
        $cList->apply_way = $model->apply_way;
        $cList->address = $model->train_area;
        $cList->GPS = $model->train_address;
        $cList->men = $model->train_men;
        $cList->phone = $model->train_phone;
        $cList->organizational = $model->organizational;
        $cList->longitude = $model->longitude;
        $cList->latitude = $model->latitude;
        $cList->state = $model->train_state;
        $cList->change_adminid = get_session('admin_id');
        $cList->change_time = date('Y-m-d H:i:s');
        $st=$cList->save();
        
        if($st==1){
            $trainData=ClubTrainData::model()->findAll('train_id='.$model->id);
            foreach($trainData as $d){
                $cData=ClubChangeData::model()->find('change_id='.$cList->id.' and data_id='.$d->id);
                if(empty($cData)){
                    $cData=new ClubChangeData();
                    $cData->isNewRecord = true;
                    unset($cData->id);
                }
                $cData->change_id = $cList->id;
                $cData->data_id = $d->id;
                $cData->type_id = $d->type_id;
                $cData->project_id = $d->project_id;
                $cData->content = $d->train_content;
                $cData->money = $d->train_money;
                $cData->apply_number = $d->apply_number;
                $cData->apply_check_way = $d->apply_check_way;
                $cData->min_age = $d->min_age;
                $cData->max_age = $d->max_age;
                $cData->start_time = $d->train_time;
                $cData->end_time = $d->train_time_end;
                $cData->train_identity_type = $d->train_identity_type;
                $cData->train_identity_rank = $d->train_identity_rank;
                $cData->period = $d->period;
                $st=$cData->save();
            }
        }
    }

    // 培训收费方案
    public function actionIndex_pay_blueprint($start = '', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'MallPriceSet';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and pricing_type=352 and if_del=648';
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(star_time,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(star_time,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'event_code,event_title,supplier_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_pay_blueprint', $data);
    }

    // 培训收费方案详情
    public function actionPay_blueprint_details($id){
        $modelName = 'MallPriceSet';
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $data['mall_fee'] = ClubMembershipFee::model()->find('code="TS55"');
            $this->render('pay_blueprint_details',$data);
        }
    }

    // 报名费用统计
    public function actionIndex_pay_stat($start = '', $train_title='', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'train_clubid='.get_session('club_id').' and train_state=2';
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(train_buy_start,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(train_buy_start,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'train_title',$train_title,'');
        $criteria->condition = get_like($criteria->condition,'train_code,train_club_code,train_clubname',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_pay_stat', $data);
    }

    // 培训结算统计
    public function actionindex_stat($start = '', $train_title='', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 
        $criteria->condition = get_where_club_project('train_clubid').' and train_state=2';
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(train_buy_start,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(train_buy_start,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'train_title',$train_title,'');
        $criteria->condition = get_like($criteria->condition,'train_code,train_club_code,train_clubname',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_stat', $data);
    }

    public function actionGetRank($id){
        $data = ClubStoreRank::model()->findAll('fater_id='.$id.' and if_del=510');
        $ar = array();
        if(!empty($data))foreach($data as $key => $val){
            $ar[$key]['id'] = $val->id;
            $ar[$key]['code'] = $val->code;
            $ar[$key]['type_name'] = $val->type_name;
            $ar[$key]['rank_name'] = $val->rank_name;
        }
        echo CJSON::encode($ar);
    }

 //保存到素材管理	
public function save_gfmaterial($oldpic,$pic,$title){
	$logopath=BasePath::model()->getPath(49);
    $gfpic=GfMaterial::model()->findAll('club_id='.get_session('club_id').' AND v_type=252 AND v_pic="'.$pic.'"');
    $gfmaterial=new GfMaterial();
	if($oldpic!=$pic){
		if(empty($gfpic)){
			$gfmaterial->isNewRecord = true;
			unset($gfmaterial->id);
			$gfmaterial->gf_type=501;
			$gfmaterial->gfid=get_session('admin_id');
			$gfmaterial->club_id=get_session('club_id');
			$gfmaterial->v_type=252;
			$gfmaterial->v_title=$title;
			$gfmaterial->v_pic=$pic;
			$gfmaterial->v_file_path=$logopath->F_WWWPATH;
			$gfmaterial->save();
		}
	}     

  }
     
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        ClubTrainData::model()->deleteAll('train_id in('.$id.')');
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


    
    //直播关联列表
    public function actionIndex_video_live($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 't.train_clubid='.get_session('club_id').' and t.train_state=2 and !isnull(t.video_live_id)';
        $criteria->condition = get_like($criteria->condition,'t.train_title',$keywords,'');
		$criteria->join = "JOIN video_live t2 on find_in_set(t2.id ,t.video_live_id)";
        $criteria->select='t.id,t.train_title,t.video_live_id,t2.id video_id,t2.title video_title';
        $criteria->order = 't2.state_time';
        $data = array();
        parent::_list($model, $criteria, 'index_video_live', $data);
    }

    // 解除直播关联
    public function actionRelieve($id,$video_id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $id . ')';
        $train=$model->find($criteria);
        $arr=explode(",", $train->video_live_id);
        if(!is_array($arr)){
            return $arr;
        }
        foreach($arr as $k=>$v){
            if($v == $video_id){
                unset($arr[$k]);
            }
        }
        $v_id=implode(",", $arr);
        $count = $model->updateAll(array('video_live_id' => $v_id), $criteria);
        VideoLive::model()->updateAll(array('uDate' => date('Y-m-d H:i:s')), 'id='.$video_id);
        if ($count > 0) {
            ajax_status(1, '解除成功', get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '解除失败');
        }
    }

    public function actionAddForm(){
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $_POST['train_id'] . ')';
        $count = $model->updateAll(array('video_live_id' => $_POST['video_live_id']), $criteria);
        VideoLive::model()->updateAll(array('uDate' => date('Y-m-d H:i:s')), 'id in('.$_POST['video_live_id'].')');
        if($count>0){
            ajax_status(1, '关联成功', get_cookie('_currentUrl_'));
        }else{
            ajax_status(0, '关联成功');
        }
    }
}
