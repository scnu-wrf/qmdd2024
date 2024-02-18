<?php

class ClubStoreCourseController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    
    // 课程发布
    public function actionIndex($project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=721 and course_club_id='.get_session('club_id');
        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index', $data);
    }

    // 待审核列表
    public function actionIndex_submit($course_type='', $course_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=371 and course_club_id='.get_session('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($course_type),' course_type_id',$course_type,''); 
        $criteria->condition=get_where($criteria->condition,!empty($course_classify),' course_type2_id',$course_classify,''); 
        $criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,''); 
        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['course_type'] = ClubStoreType::model()->findAll('f_id in(1506) and if_del=510');
        $data['course_classify'] = ClubStoreType::model()->findAll('fater_id in('.($course_type==''?'-1':$course_type).') and if_del=510');
        parent::_list($model, $criteria, 'index_submit', $data);
    }

    // 发布审核
    public function actionIndex_audit($state='', $course_type='', $course_classify='', $project_id='', $start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('course_club_id','');
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
        $criteria->condition=get_where($criteria->condition,!empty($course_type),' course_type_id',$course_type,''); 
        $criteria->condition=get_where($criteria->condition,!empty($course_classify),' course_type2_id',$course_classify,''); 
        $criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,''); 
        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['count1'] = $model->count(get_where_club_project('course_club_id','').' and state=371');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['course_type'] = ClubStoreType::model()->findAll('f_id in(1506) and if_del=510');
        $data['course_classify'] = ClubStoreType::model()->findAll('fater_id in('.($course_type==''?'-1':$course_type).') and if_del=510');
        parent::_list($model, $criteria, 'index_audit', $data);
    }

    // 取消/审核未通过列表
    public function actionIndex_not_pass($start_date = '', $end_date = '', $course_type='', $course_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=373 and '.get_where_club_project('course_club_id');
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($course_type),' course_type_id',$course_type,''); 
        $criteria->condition=get_where($criteria->condition,!empty($course_classify),' course_type2_id',$course_classify,''); 
        $criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,''); 
        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['course_type'] = ClubStoreType::model()->findAll('f_id in(1506) and if_del=510');
        $data['course_classify'] = ClubStoreType::model()->findAll('fater_id in('.($course_type==''?'-1':$course_type).') and if_del=510');
        parent::_list($model, $criteria, 'index_not_pass', $data);
    }

    // 课程列表
    public function actionIndexhd($index='', $start_date = '', $end_date = '', $course_type='', $course_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and course_club_id='.get_session('club_id');
        if($index==1){
            $criteria->condition .= ' and dispay_star_time<=now() and dispay_end_time>=now()';
            $start_date=empty($start_date)?date("Y-m-d", strtotime("-1 month")):$start_date;
            $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        }elseif($index==2){
            $criteria->condition .= ' and dispay_end_time<now()';
            $start_date=empty($start_date)?date("Y-m-d"):$start_date;
            $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(dispay_star_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(dispay_star_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($course_type),' course_type_id',$course_type,''); 
        $criteria->condition=get_where($criteria->condition,!empty($course_classify),' course_type2_id',$course_classify,''); 
        $criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,''); 
        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['course_type'] = ClubStoreType::model()->findAll('f_id in(1506) and if_del=510');
        $data['course_classify'] = ClubStoreType::model()->findAll('fater_id in('.($course_type==''?'-1':$course_type).') and if_del=510');
        parent::_list($model, $criteria, 'indexhd', $data);
    }

    // 各单位课程列表/各单位课程历史列表
    public function actionIndexhv($index='', $start_date = '', $end_date = '', $course_type='', $course_classify='', $project_id='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and '.get_where_club_project('course_club_id','');
        if($index==1){
            $criteria->condition .= ' and dispay_star_time<=now() and dispay_end_time>=now()';
            $start_date=empty($start_date)?date("Y-m-d", strtotime("-1 month")):$start_date;
            $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        }elseif($index==2){
            $criteria->condition .= ' and dispay_end_time<now()';
            $start_date=empty($start_date)?date("Y-m-d"):$start_date;
            $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(dispay_star_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(dispay_star_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($course_type),' course_type_id',$course_type,''); 
        $criteria->condition=get_where($criteria->condition,!empty($course_classify),' course_type2_id',$course_classify,''); 
        $criteria->condition=get_where($criteria->condition,!empty($project_id),' project_id',$project_id,''); 
        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['course_type'] = ClubStoreType::model()->findAll('f_id in(1506) and if_del=510');
        $data['course_classify'] = ClubStoreType::model()->findAll('fater_id in('.($course_type==''?'-1':$course_type).') and if_del=510');
        parent::_list($model, $criteria, 'indexhv', $data);
    }
    
    // 信息更改
    public function actionIndex_change($start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'ClubChangeList';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and service_type=1537 and '.get_where_club_project('club_id','');
        $criteria->condition .= ' and (dispay_end_time>=now() or buy_end>=now())';
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
        $criteria->condition = 'state=2';
        if($club_id!=''){
            $criteria->condition .= ' and course_club_id='.$club_id;
        }else{
            $criteria->condition .= ' and '.get_where_club_project('course_club_id','');
        }
        $criteria->condition .= ' and (dispay_end_time>=now() or market_time_end>=now())';

        $criteria->condition = get_like($criteria->condition,'course_code,course_title',$keywords,'');
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
    
    // 培训视频收费方案
    public function actionIndex_pay_blueprint($start = '', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'MallPriceSet';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and pricing_type=1537 and if_del=648';
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
            $data['mall_fee'] = ClubMembershipFee::model()->find('code="TS58"');
            $this->render('pay_blueprint_details',$data);
        }
    }

    // 课程评价列表
    public function actionIndex_evaluate($star='',$end='',$keywords = '') {
        $model = QmddAchievemenData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.get_session('club_id').' and order_type=1537';
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

    // 课程评价详情
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
    
    // 报名费用统计
    public function actionIndex_pay_stat($start = '', $course_title='', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'course_club_id='.get_session('club_id').' and state=2';
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(dispay_star_time,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(dispay_star_time,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'course_title',$course_title,'');
        $criteria->condition = get_like($criteria->condition,'course_code,course_club_code,course_club_name',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_pay_stat', $data);
    }

    // 报名费用明细
    public function actionPay_stat_data($club_id='', $start_date = '', $end_date = '', $title='', $keywords = '') {
        $model = GfServiceData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.$club_id;
        $criteria->condition .= ' and order_type=1537 and state=2 and is_pay=464 and pay_confirm=1';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pay_confirm_time,10)<="' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($title),'service_id',$title,'');
        $criteria->condition=get_like($criteria->condition,'info_order_num,gf_account,gf_name',$keywords,'');
        $criteria->order = 'uDate DESC';
		$data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['course_list'] = ClubStoreCourse::model()->findAll('state=2 and '.get_where_club_project('course_club_id'));
        parent::_list($model, $criteria, 'pay_stat_data', $data);
    }

    // 培训结算统计
    public function actionindex_stat($start = '', $course_title='', $end = '',$keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 
        $criteria->condition = get_where_club_project('course_club_id').' and state=2';
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(dispay_star_time,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(dispay_star_time,10)<="' . $end . '"';
        }
        $criteria->condition = get_like($criteria->condition,'course_title',$course_title,'');
        $criteria->condition = get_like($criteria->condition,'course_code,course_club_code,course_club_name',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_stat', $data);
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
        $criteria->condition .= ' and order_type=1537 and state=2 and is_pay=464 and pay_confirm=1';
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
        $data['course_list'] = ClubStoreCourse::model()->findAll('state=2 and '.get_where_club_project('course_club_id'));
        parent::_list($model, $criteria, 'index_stat_data', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(300);
            $model->explain_temp=get_html($basepath->F_WWWPATH.$model->explain, $basepath);
            $data['model'] = $model;
            $data['project'] = ClubProject::model()->getCode_id2(get_session('club_id'));
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
			$basepath = BasePath::model()->getPath(300);
            $model->explain_temp=get_html($basepath->F_WWWPATH.$model->explain, $basepath);
            $data['model'] = $model;
            $data['project'] = ClubProject::model()->getCode_id2(get_session('club_id'));
            if (!empty($model->course_big_pic)) {
                $data['course_big_pic'] = explode(',', $model->course_big_pic);
            }
            $data['list_data'] = ClubStoreVideo::model()->findAll('course_id='.$model->id);
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
                        $m_message=$model->course_title.'活动审核已通过';
                        $content=$model->course_title.'活动审核已通过';
                    }elseif($model->state==373){
                        $m_message=$model->course_title.'活动审核未通过';
                        $content=$model->course_title.'活动审核未通过';
                    }
                    $basepath=BasePath::model()->getPath(123); 
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;

                    $title='【审核通知】';
                    $url='';
                    $type_id=5;
                    $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
                    backstage_send_message(get_session('admin_id'),$model->course_club_code,$m_message,$title,315,'B'.$model->course_club_code,$sendArr);
                }else{
                    $this->change_data($model);
                }
            }
        }
	    show_status($st, $yes, $url, $no); 
    }

    // 添加信息更改记录
    public function change_data($model){
        if($model->state==371){
            $cList=ClubChangeList::model()->find('service_type=1537 and service_id='.$model->id);
        }
        if(empty($cList)){
            $cList=new ClubChangeList();
            $cList->isNewRecord = true;
            unset($cList->id);
        }
        $cList->service_type = 1537;
        $cList->service_id = $model->id;
        $cList->code = $model->course_code;
        $cList->title = $model->course_title;
        $cList->logo = $model->course_small_pic;
        $cList->pic = $model->course_big_pic;
        $cList->club_id = $model->course_club_id;
        $cList->description = $model->explain;
        $cList->type_id = $model->course_type_id;
        $cList->type2_id = $model->course_type2_id;
        $cList->if_live = $model->is_online;
        $cList->dispay_start_time = $model->dispay_star_time;
        $cList->dispay_end_time = $model->dispay_end_time;
        $cList->buy_start = $model->market_time;
        $cList->buy_end = $model->market_time_end;
        $cList->state = $model->state;
        $cList->change_adminid = get_session('admin_id');
        $cList->change_time = date('Y-m-d H:i:s');
        $cList->money = $model->course_money;
        $cList->grade = $model->course_grade;
        $cList->project_id = $model->project_id;
        $st=$cList->save();
        
        if($st==1){
            $courseVideo=ClubStoreVideo::model()->findAll('course_id='.$model->id);
            foreach($courseVideo as $d){
                $cData=ClubChangeData::model()->find('change_id='.$cList->id.' and data_id='.$d->id);
                if(empty($cData)){
                    $cData=new ClubChangeData();
                    $cData->isNewRecord = true;
                    unset($cData->id);
                }
                $cData->change_id = $cList->id;
                $cData->data_id = $d->id;
                $cData->video_pic = $d->video_pic;
                $cData->video_title = $d->video_title;
                $cData->video_duration = $d->video_duration;
                $cData->video_id = $d->video_id;
                $st=$cData->save();
            }
        }
    }
    
    public function save_data($model){
        $modelName = $this->model;
        if(!empty($_POST[$modelName]['remove_data_ids'])){
            ClubStoreVideo::model()->deleteAll('id in (' . $_POST[$modelName]['remove_data_ids'] . ')');
        }
        if(!empty($_POST['add_tag'])){
            foreach($_POST['add_tag'] as $v){
                $data=ClubStoreVideo::model()->find('id='.$v['data_id']);
                if(empty($data)){
                    $data=new ClubStoreVideo();
                    $data->isNewRecord = true;
                    unset($data->id);
                }
                $data->course_id = $model->id;
                $data->video_pic = $v['video_pic'];
                $data->video_title = $v['video_title'];
                $data->video_duration = $v['video_duration'];
                $data->video_id = $v['video_id'];
                $st=$data->save();
            }
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

    //逻辑删除
    public function actionDelete($id) {
        
        ClubStoreVideo::model()->deleteAll('course_id in('.$id.')');
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
}
