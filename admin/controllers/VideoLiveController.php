<?php

class VideoLiveController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
//直播发布申请列表
    public function actionIndex($keywords = '',$type = '') {
         set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='club_id='.get_session('club_id');
        $cr.=' and if_del=648 and live_state in(721,371,2,373) and state in(1362,1365)';
        $cr=get_where($cr,!empty($type),' live_type',$type,'');
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='id DESC';
        $data = array();
        $data['live_type'] = VideoClassify::model()->getCode(366);
        $data['base_path'] = BasePath::model()->getPath(141);
        parent::_list($model, $criteria, 'index', $data);
    }

//数据待审核列表
    public function actionSubmit_list($keywords = '') {
         set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('club_id','');
        $cr.=' and if_del=648 and live_state=371 and state in (1362,1365)'; 
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='apply_time ASC';
        $data = array();
        parent::_list($model, $criteria, 'submit_list', $data);
    }
//直播发布已审核列表
    public function actionIndex_pass($keywords = '',$start_date='',$end_date='') {
         set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		if(empty($start_date)){
			$start_date=date("Y-m-d");
		}
		if(empty($end_date)){
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('club_id','');
        $cr.=' and if_del=648 and live_state in(2,373)';
		$cr.=' and live_state_time>="'.$start_date.' 00:00:00" and live_state_time<="'.$end_date.' 23:59:59"';
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='live_state_time DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['num'] = $model->count('if_del=648 and live_state=371 and state in (1362,1365)');
        parent::_list($model, $criteria, 'index_pass', $data);
    }
//待备案列表
    public function actionCheckin_list($keywords = '') {
         set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('club_id','');
        $cr.=' and if_del=648 and live_state=2 and state=1362'; 
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='live_state_time ASC';
        $data = array();
        parent::_list($model, $criteria, 'checkin_list', $data);
    }
//直播发布备案列表
    public function actionIndex_checked($keywords = '',$start_date='',$end_date='') {
         set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($start_date)){
			$start_date=date("Y-m-d");
		}
		if(empty($end_date)){
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('club_id','');
        $cr.=' and if_del=648 and live_state=2 and state in(1364,1365,1366)';
		$cr.=' and state_time>="'.$start_date.' 00:00:00" and state_time<="'.$end_date.' 23:59:59"';
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['num'] = $model->count('if_del=648 and live_state=2 and state=1362');
        parent::_list($model, $criteria, 'index_checked', $data);
    }

//直播节目列表

    public function actionIndex_live($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->join = "JOIN video_live_programs on t.id=video_live_programs.live_id";
        $cr='club_id='.get_session('club_id');
        $cr.= ' and if_del=648 and live_state=2 and state=1364 and live_end>"'.$now.'"';
        $cr.=' and video_live_programs.program_end_time>"' . $now . '"';
        $cr=get_like($cr,'t.title,t.code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order ='video_live_programs.program_time ASC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        parent::_list($model, $criteria, 'index_live', $data);
    }
//备案审核未通过列表
    public function actionIndex_fail($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('club_id','');
        $cr.=' and (live_state=373 or state=1366)';
        $cr.=' and if_del=648';
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        parent::_list($model, $criteria, 'index_fail', $data);
    }

//直播推流地址设置列表
    public function actionIndex_rtmp($keywords = '',$star='',$end='') {
         $this->ShowView($keywords,$star,$end,'live_state=2','state=1364 and live_source_RTMP<>""',1,'index_rtmp');
    }
//直播推流地址设置-待配置列表
    public function actionIndex_installrtmp($keywords = '') {
         $this->ShowView($keywords,'','','live_state=2','state=1364 and (live_source_RTMP="" or live_source_RTMP is null)',0,'index_installrtmp');
    }
    public function ShowView($keywords = '',$star='',$end='',$live_state,$state,$for=0,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $nowday=date('Y-m-d');
        if ($star=='' && $for==1) $star=$nowday;
        $criteria->join = "JOIN video_live_programs on t.id=video_live_programs.live_id";
        $cr=get_where_club_project('club_id','');
        $cr.=' and if_del=648 and '.$state.' and '.$live_state;
        $cr.=' and video_live_programs.program_end_time>"' . $now . '"';
        $cr=get_where($cr,$star,'t.live_source_time>=',$star.' 00:00:00',"'");
        $cr=get_where($cr,$end,'t.live_source_time<=',$end.' 23:59:59',"'");
        $cr=get_like($cr,'t.title,t.code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order ='program_time ASC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        $cu = new CDbCriteria;
        $cu->join = "JOIN video_live_programs on t.id=video_live_programs.live_id";
        $cu->condition=' if_del=648 and live_state=2 and state=1364 and (live_source_RTMP="" or live_source_RTMP is null) and video_live_programs.program_end_time>"' . $now . '"';
        $cu->group='t.id';
        $data['num'] = $model->count($cu);
        $data['star'] = $star;
        $data['end'] = $end;
        parent::_list($model, $criteria, $viewfile, $data);
    }

//各单位直播查询列表
    public function actionIndex_club($keywords = '',$type = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->join = "JOIN video_live_programs on t.id=video_live_programs.live_id";
        $cr=get_where_club_project('club_id','');
        $cr.= ' and if_del=648 and live_state=2 and state=1364 and live_end>"'.$now.'"';
        $cr.=' and video_live_programs.program_end_time>"' . $now . '"';
        $cr=get_where($cr,!empty($type),' live_type',$type,'');
        $cr=get_like($cr,'t.title,t.code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order ='video_live_programs.program_time ASC';
        $data = array();
        $data['live_type'] = VideoClassify::model()->getCode(366);
        $data['base_path'] = BasePath::model()->getPath(141);
        parent::_list($model, $criteria, 'index_club', $data);
    }
//各单位历史直播查询列表
    public function actionIndex_gf($keywords = '',$type = '',$is_uplist = '') {
         set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->join = "JOIN video_live_programs on t.id=video_live_programs.live_id";
        $cr=get_where_club_project('club_id','');
        $cr.= ' and if_del=648 and live_state=2 and state=1364';
        $cr.=' and video_live_programs.program_end_time<"' . $now . '"';
        $cr=get_where($cr,!empty($type),' live_type',$type,'');
        if ($is_uplist != '') $cr.=' AND is_uplist=' . $is_uplist;
        $cr=get_like($cr,'t.title,t.code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order ='id DESC';
        $data = array();
        $data['live_type'] = VideoClassify::model()->getCode(366);
        $data['base_path'] = BasePath::model()->getPath(141);
        parent::_list($model, $criteria, 'index_gf', $data);
    }
//历史直播列表
    public function actionIndex_log($keywords = '',$type = '',$is_uplist = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->join = "JOIN video_live_programs on t.id=video_live_programs.live_id";
        $cr=get_where_club_project('club_id','');
        $cr.= ' and if_del=648 and live_state=2 and state=1364';
        $cr.=' and video_live_programs.program_end_time<"' . $now . '"';
        $cr=get_where($cr,!empty($type),' live_type',$type,'');
        if ($is_uplist != '') $cr.=' AND is_uplist=' . $is_uplist;
        $cr=get_like($cr,'t.title,t.code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order ='id DESC';
        $data = array();
        $data['live_type'] = VideoClassify::model()->getCode(366);
        parent::_list($model, $criteria, 'index_log', $data);
    }
    function get_td($pname,$pclass=""){
           $s1=($pclass=="") ?'<tr>' :' class="'.$pclass.'firstRow">';
           $s1.='<td'.(($pclass=="") ?' width="20%"' : '').'valign="top" style="word-break: break-all;">';
           $s1.=$pname.'名单：</td><td valign="top"></td></tr>';
      return $s1;
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['project_list'] = array();
            $data['club_list'] = array();
            $data['programs'] = array();
            $data['flag'] = 0;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
            $data['cut_type'] = BaseCode::model()->findAll('f_id in (252,253)');
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);           
        }
    }
//直播申请详情
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {

            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
            $data['cut_type'] = BaseCode::model()->findAll('f_id in (252,253)');
            $basepath = BasePath::model()->getPath(131);
            $model->intro_temp=get_html($basepath->F_WWWPATH.$model->intro, $basepath);
            // 获取项目
            if ($model->project_list!='') {
                $data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');
                //$data['project_list'] = VideoLiveProject::model()->findAll('video_live_id='.$model->id);
            } else {
                $data['project_list'] = array();
            }
            // 获取节目
            $data['programs'] = VideoLivePrograms::model()->findAll('live_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $data['flag'] = 1;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);

        }
    }

//数据待审核详情
    public function actionUpdate_submit($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['project_list'] = array();
            $data['programs'] = array();
            // 获取项目
            if ($model->project_list!='') {
                $data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');
                //$data['project_list'] = VideoLiveProject::model()->findAll('video_live_id='.$model->id);
            } else {
                $data['project_list'] = array();
            }
            $data['programs'] = VideoLivePrograms::model()->findAll('live_id=' . $model->id);
            $basepath = BasePath::model()->getPath(131);
            $model->intro_temp=get_html($basepath->F_WWWPATH.$model->intro, $basepath);
            $this->render('update_submit', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $live_state=get_check_code($_POST['submitType']);
            $st=0;
            $now=date('Y-m-d H:i:s');
			$post=$_POST[$modelName];
            if($live_state!=''){
				VideoLive::model()->updateAll(array(
					'live_state'=>$live_state,
					'state'=>1362, 
					'live_state_time'=>$now, 
					'live_state_reasons_for_failure'=>$post["live_state_reasons_for_failure"], 
					'live_state_admin_id'=>get_session('admin_id'), 
					'live_state_admin_nick'=>get_session('admin_name')),
					'id='.$model->id
				);
                $st++;
            }
            
            show_status($st,'已审核',get_cookie('_currentUrl_'),'审核失败');
        }
    }

    //待备案详情
    public function actionUpdate_checkin($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['project_list'] = array();
            $data['programs'] = array();
            // 获取项目
            if ($model->project_list!='') {
                $data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');
                //$data['project_list'] = VideoLiveProject::model()->findAll('video_live_id='.$model->id);
            } else {
                $data['project_list'] = array();
            }
            $data['programs'] = VideoLivePrograms::model()->findAll('live_id=' . $model->id);
            $basepath = BasePath::model()->getPath(131);
            $model->intro_temp=get_html($basepath->F_WWWPATH.$model->intro, $basepath);
            $this->render('update_checkin', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $is_online=0;
            $is_talk=0;
            $open_comments=0;
            if ($_POST['submitType'] == 'tongguo') {
                $state = 1364;
                $is_online=1;
                $is_talk=1;
                $open_comments=1;
            } else if ($_POST['submitType'] == 'butongguo') {
                $state = 1365;
            } else if ($_POST['submitType'] == 'zhongzhi') {
                $state = 1366;
            } else {
                $state = 1362;
            }
            $st=0;
            $now=date('Y-m-d H:i:s');
			$post=$_POST[$modelName];
            if($state!=''){
                $checkin_code=$model->checkin_code;
                $checkin_img=$model->checkin_img;
                VideoLive::model()->updateAll(
                    array(
                        'state'=>$state,
                        'is_online'=>$is_online,
                        'is_talk'=>$is_talk,
                        'open_comments'=>$open_comments,
                        'checkin_code'=>$checkin_code,
                        'checkin_img'=>$checkin_img,
                        'check_time'=>$now,
                        'reasons_for_failure'=>$post["reasons_for_failure"],
                        'admin_id'=>get_session('admin_id'),
                        'admin_nick'=>get_session('admin_name'),
                        'state_time'=>$now,
                ),'id='.$model->id);
                $st++;
            }
            
            show_status($st,'已提交',get_cookie('_currentUrl_'),'提交失败');
        }
    }

    //备案审核详情
    public function actionUpdate_checked($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['project_list'] = array();
            $data['programs'] = array();
            // 获取项目
            if ($model->project_list!='') {
                $data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');
                //$data['project_list'] = VideoLiveProject::model()->findAll('video_live_id='.$model->id);
            } else {
                $data['project_list'] = array();
            }
            $data['programs'] = VideoLivePrograms::model()->findAll('live_id=' . $model->id);
            $basepath = BasePath::model()->getPath(131);
            $model->intro_temp=get_html($basepath->F_WWWPATH.$model->intro, $basepath);
            $this->render('update_checked', $data);
        }

    }

    //直播节目详情
    public function actionUpdate_live($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['project_list'] = array();
            $data['programs'] = array();
            // 获取项目
            if ($model->project_list!='') {
                $data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');
                //$data['project_list'] = VideoLiveProject::model()->findAll('video_live_id='.$model->id);
            } else {
                $data['project_list'] = array();
            }
            $data['programs'] = VideoLivePrograms::model()->findAll('live_id=' . $model->id);
            $basepath = BasePath::model()->getPath(131);
            $model->intro_temp=get_html($basepath->F_WWWPATH.$model->intro, $basepath);
            $this->render('update_live', $data);
        }
    }
	//直播数据统计列表
    public function actionIndex_stat($keywords = '',$start_date='',$end_date='',$club_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($start_date)){
			$start_date=date("Y-m-d");
		}
		if(empty($end_date)){
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $cr='if_del=648 and live_state=2 and state in(1364)';
		if(empty(get_SESSION('use_club_id'))){
			if(!empty($club_id)){
				$cr.=' and club_id='.$club_id;
			}
		}else{
			$cr.=' and '.get_where_club_project('club_id','');
		}
		$cr.=' and state_time>="'.$start_date.' 00:00:00" and state_time<="'.$end_date.' 23:59:59"';
        $cr=get_like($cr,'title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['live_club_list'] = VideoLive::model()->findAllBySql('SELECT * FROM video_live where if_del=648 and live_state=2 and state in(1364) GROUP BY club_id order by club_name');
        parent::_list($model, $criteria, 'index_stat', $data);
    }

    //直播数据统计详情
    public function actionUpdate_stat($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->live_show=explode(',',$data['model']->live_show); //把字符串打散为数组
            $data['programs'] = VideoLivePrograms::model()->findAll('live_id=' . $model->id);
            $basepath = BasePath::model()->getPath(131);
            $this->render('update_stat', $data);
        }
    }
	
	//分享榜列表
    public function actionVideo_live_share_list($live_id=null) {
		$data = array();
        $model = VideoLiveStatus::model();
        $criteria = new CDbCriteria;
		$criteria->select='COUNT(*) as invite_count,userlist.GF_NAME,userlist.GF_ACCOUNT';
		$criteria->condition='t.m_type=33 and t.inviter_gfid<>0 and t.live_id='.$live_id;
		$criteria->join = 'join userlist on userlist.GF_ID=t.inviter_gfid';
		$criteria->order = 'invite_count DESC';
		$criteria->group = 't.inviter_gfid';
        parent::_list($model, $criteria, 'video_live_share_list', $data,10);
    }
	
	//礼物榜列表
    public function actionVideo_live_gift_list($live_id=null) {
		$data = array();
        $model = VideoLiveMessage::model();
        $criteria = new CDbCriteria;
		$criteria->select='sum(t.live_reward_num) as gift_num_amount,sum(t.live_reward_price*t.live_reward_num) as gift_price_amount,u.GF_NAME,u.GF_ACCOUNT';
		$criteria->condition='t.m_type=32 and t.live_id='.$live_id;
		$criteria->join = 'join userlist u on u.GF_ID=t.s_gfid';
		$criteria->order = 'gift_price_amount DESC,gift_num_amount DESC';
		$criteria->group = 's_gfid';
        parent::_list($model, $criteria, 'video_live_gift_list', $data);
    }
	
	//红包榜列表
    public function actionVideo_live_envelope_list($live_id=null) {
		$data = array();
        $model = VideoLiveMessage::model();
        $criteria = new CDbCriteria;
		$criteria->select='sum(t.live_reward_num) as gift_num_amount,sum(t.live_reward_price*t.live_reward_num) as gift_price_amount,u.GF_NAME,u.GF_ACCOUNT';
		$criteria->condition='t.m_type=40 and t.live_id='.$live_id;
		$criteria->join = 'join userlist u on u.GF_ID=t.s_gfid';
		$criteria->order = 'gift_price_amount DESC,gift_num_amount DESC';
		$criteria->group = 's_gfid';
        parent::_list($model, $criteria, 'video_live_envelope_list', $data);
    }
	//观看收费统计
    public function actionLive_pay_stat($keywords = '',$club_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='if_del=648 and live_state=2 and state in(1364) and (gf_price>0 or member_price>0)';
		if(empty(get_SESSION('use_club_id'))){
			if(!empty($club_id)){
				$cr.=' and club_id='.$club_id;
			}
		}else{
			$cr.=' and '.get_where_club_project('club_id','');
		}
        $cr=get_like($cr,'title,code',$keywords,'');
        $criteria->condition=$cr;
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(141);
        $data['live_club_list'] = VideoLive::model()->findAllBySql('SELECT * FROM video_live where if_del=648 and live_state=2 and state in(1364) GROUP BY club_id order by club_name');
        parent::_list($model, $criteria, 'live_pay_stat', $data);
    }
	//收费明细弹窗
    public function actionLive_pay_stat_detail($live_id=null) {
		$data = array();
        $modelName = 'MallSalesOrderData';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr='t.order_type=366 and t.service_id='.$live_id;
		$criteria->condition=$cr;
		$criteria->select='t.*,info.pay_supplier_type_name,info.order_gfaccount';
		$criteria->join ='join mall_sales_order_info info on info.order_num=t.order_num';
		$criteria->order ='t.id DESC';
        parent::_list($model, $criteria, 'live_pay_stat_detail', $data);
    }
	//观看收费明细
    public function actionLive_pay_list($keywords = '',$start_date='',$end_date='',$club_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
		if(empty($start_date)){
			$start_date=date("Y-m-d");
		}
		if(empty($end_date)){
			$end_date=date("Y-m-d");
		}
        $modelName = 'MallSalesOrderData';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='t.order_type=366';
		if(empty(get_SESSION('use_club_id'))){
			if(!empty($club_id)){
				$cr.=' and t.supplier_id='.$club_id;
			}
		}
		$cr.=' and t.order_Date>="'.$start_date.' 00:00:00" and t.order_Date<="'.$end_date.' 23:59:59"';
        $cr=get_like($cr,'service_code,service_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->select='t.*,info.pay_supplier_type_name,info.order_gfaccount,club_list.club_name';
		$criteria->join ='join mall_sales_order_info info on info.order_num=t.order_num join club_list on club_list.id=t.supplier_id';
        $criteria->order ='t.id DESC';
        $data = array();
		$data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['base_path'] = BasePath::model()->getPath(141);
        $data['live_club_list'] = VideoLive::model()->findAllBySql('SELECT * FROM video_live where if_del=648 and live_state=2 and state in(1364) GROUP BY club_id order by club_name');
        parent::_list($model, $criteria, 'live_pay_list', $data);
    }

     //查看推流地址
    public function actionAfter_RTMP($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            
            $this->render('after_RTMP', $data);
        }
    }

     //设置推流地址
    public function actionInstall_RTMP($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            
            $this->render('install_RTMP', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $st=0;
            if(!empty($model)){
                $live_source_secret=$model->live_source_secret;
                $live_source_time=date('Y-m-d H:i:s');
                $live_source_RTMP=$model->live_source_RTMP;
                $live_source_RTMP_H=$model->live_source_RTMP_H;
                $live_source_RTMP_N=$model->live_source_RTMP_N;
                $live_source_FLV_H=$model->live_source_FLV_H;
                $live_source_FLV_N=$model->live_source_FLV_N;
                $live_source_HLS_H=$model->live_source_HLS_H;
                $live_source_HLS_N=$model->live_source_HLS_N;
                $channelState=$model->channelState;
                $isRecord=$model->isRecord;
                VideoLive::model()->updateAll(
                    array(
                        'live_source_secret'=>$live_source_secret,
                        'live_source_time'=>$live_source_time,
                        'live_source_RTMP'=>$live_source_RTMP,
                        'live_source_RTMP_H'=>$live_source_RTMP_H,
                        'live_source_RTMP_N'=>$live_source_RTMP_N,
                        'live_source_FLV_H'=>$live_source_FLV_H,
                        'live_source_FLV_N'=>$live_source_FLV_N,
                        'live_source_HLS_H'=>$live_source_HLS_H,
                        'live_source_HLS_N'=>$live_source_HLS_N,
                        'channelState'=>$channelState,
                        'isRecord'=>$isRecord),'id='.$model->id);
                $st++;
            }
            
            show_status($st,'设置成功',get_cookie('_currentUrl_'),'设置失败');
        }
    }
     //回放设置
    public function actionPlayback($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            
            $this->render('playback', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $playback_is = $model->playback_is;
            $st=0;
            if($playback_is!=''){
            VideoLive::model()->updateAll(array('playback_is'=>$playback_is),'id='.$model->id);
                $st++;
            }
            
            show_status($st,'设置成功','','设置失败');
        }
    }

    function saveData($model,$post) {
       $model->attributes =$post;
       $model->live_state=get_check_code($_POST['submitType']);
       $model->live_show=gf_implode(',',$post['live_show']); //把数组元素组合为一个字符串
       if($_POST['submitType']=='shenhe'){
            $model->apply_time=date('Y-m-d H:i:s');
       }
       $sv=$model->save();
       if($sv==1){
            if ($model->channelState == 697) {
                    $model->updateByPk($model->id, array( 'is_rtmp' => 0));
                    $this->actionSetStatus($model->id, 0);
            }
           $this->save_project_list($model->id,$post['project_list']);
           $this->save_programs($model->id,$post['programs_list']);
           $model->live_state=get_check_code($_POST['submitType']);
           $model->save();
           // 是否直接直接生成直播频道
            if (isset($_POST['open_rtmp']) && $_POST['open_rtmp'] == 1) {
                $live_info = $this->GetVideoLiveInfo($model->id,$model->live_end);
                $model->updateByPk($model->id, array(
                    'live_source_RTMP' => $live_info['push_url'],
                    'live_source_RTMP_H' => $live_info['play_rtmp'],
                    'live_source_RTMP_N' => $live_info['play_rtmp_sd'],
                    'live_source_FLV_H' => $live_info['play_flv'],
                    'live_source_FLV_N' => $live_info['play_flv_sd'],
                    'live_source_HLS_H' => $live_info['play_hls'],
                    'live_source_HLS_N' => $live_info['play_hls_sd'],
                    'channel_id' => $live_info['channel_id'],
                    'is_rtmp' => 0,
                ));
                $this->actionSetStatus($model->id, 0);
            }

        }
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');     
    }

    public function save_project_list($id,$project_list){       
    //删除原有项目
    VideoLiveProject::model()->deleteAll('video_live_id=' . $id);
    if(!empty($project_list)){
        $project = new VideoLiveProject;
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_list);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $project->isNewRecord = true;
            unset($project->id);
            $project->video_live_id = $id;
            $project->project_id = $v;
            $project->save();
        }

    }
  }

    public function save_club_list($id,$club_list){       
    //删除原有推荐单位
        VideoLiveRecommend::model()->deleteAll('video_live_id=' . $id);
        if(!empty($club_list)){
            $club = new VideoLiveRecommend;
            $club_list_pic = array();
            $club_list_pic = explode(',', $club_list);
            $club_list_pic = array_unique($club_list_pic);
            foreach ($club_list_pic as $v) {
                $club->isNewRecord = true;
                unset($club->id);
                $club->video_live_id = $id;
                $club->recommend_club_id = $v;
                $club->save();
            }

        }
    }
	//保存节目单
    public function save_programs($id,$programs_list){
        $lprograms = VideoLivePrograms::model()->findAll("program_time>now() and IFNULL(record_task_id,'')<>'' and live_id=" . $id);
        //停止原节目直播任务
        if(!empty($lprograms)){
            foreach($lprograms as $lk=>$lv){
                $this->StopLiveRecord($lv['id'],$lv['record_task_id']);
            }
        }
        
        VideoLivePrograms::model()->updateAll(array('duration'=>'-1'),'live_id='.$id);//做临时删除标识
        //保存节目
        if (isset($_POST['programs_list'])) foreach ($_POST['programs_list'] as $v) {
            if ($v['title'] == '' || $v['program_time']=='' || $v['program_end_time']=='') {
                continue;
            }
           if ($v['id']=='null') {
                $programs = new VideoLivePrograms(); 
                $programs->isNewRecord = true;
                unset($programs->id);
            } else{
                $programs=VideoLivePrograms::model()->find('id='.$v['id']);
            } 
            if (empty($programs->program_code)) {
                // 生成节目单编号
                $service_code = '';
                $live= VideoLive::model()->find('id='.$id);
                $service_code=$live->code;
                $code_num ='01';
                $live_program=VideoLivePrograms::model()->find('live_id=' . $id . ' and program_code is not null order by program_code DESC');
                if (!empty($live_program)) {
                    $num=intval(substr($live_program->program_code, -2));
                    $code_num = substr('00' . strval($num + 1), -2);
                }
                $service_code.=$code_num;
                $programs->program_code = $service_code;
            }
                
            $programs->live_id = $id;
            $programs->title = $v['title'];
            $programs->program_time = $v['program_time'];
            $programs->program_end_time = $v['program_end_time'];
            $programs->duration = $v['duration'];
            $programs->programs_list = 1;
            $programs->save();
            if (strtotime($v['program_time'])>time()) {
//////////////////////////////创建直播任务/////////////////////////////////////////////////
                 $record_task_id=$this->CreateLiveRecord($id,$v['program_time'],$v['program_end_time']);
                 if(!empty($record_task_id)){
                     $programs->updateByPk($programs->id, array(
                         'record_task_id' => $record_task_id
                         ));
                 }
            }
        }
        VideoLivePrograms::model()->deleteAll('duration="-1"');
    }

	/**
	 * 开启关闭推流 Live_Channel_SetStatus
	 * 对一条直播流执行禁用、断流和允许推流操作。禁用，表示不能再继续使用该流id推流；如果正在推流，则推流会被中断，中断后不可再次推流。断流表示中断正在推的流，断流后可以再次推流。允许推流表示启用该流id，允许用该流id推流。
	 * Param.n.status	开关状态	int	0表示禁用； 1表示允许推流；2表示断流
	 */
    public function actionSetStatus($live_id, $status = 1) {
        $url = Yii::app()->params['QcloudLiveFcgi'];//'http://fcgi.video.qcloud.com/common_access';
        $time = time() + 30;
        $package = array(
            'appid' => Yii::app()->params['QcloudLiveAppid'],
            'interface' => 'Live_Channel_SetStatus',
            't' => $time,
            'sign' => md5(Yii::app()->params['QcloudLiveAuthKey'] . $time),
            'Param.s.channel_id' => Yii::app()->params['QcloudLiveBizid'],
            'Param.n.status' => $status,
        );
//'Param.s.channel_id' => Yii::app()->params['QcloudLiveBizid'] . '_' . $live_id,
        $rs = send_request($url, $package, 'GET');
        return $rs;
    }

    public function actionGetVideoLiveInfo($live_id,$endTime) {
        $data = array();
        $data['status'] = 1;
        $data['push_url'] = $this->getVideoLivePushUrl(Yii::app()->params['QcloudLiveBizid'], $live_id, Yii::app()->params['QcloudLiveAntiKey'], $endTime);
        $rs = $this->getVideoLivePlayUrl(Yii::app()->params['QcloudLiveBizid'], $live_id);
        $data['play_rtmp'] = $rs[0];
        $data['play_flv'] = $rs[1];
        $data['play_hls'] = $rs[2];
        $rs = $this->getVideoLivePlayUrl(Yii::app()->params['QcloudLiveBizid'], $live_id, 'sd');
        $data['play_rtmp_sd'] = $rs[0];
        $data['play_flv_sd'] = $rs[1];
        $data['play_hls_sd'] = $rs[2];
        ajax_exit($data);
    }

    public function actionGetPushUrl($live_id,$endTime) {
        $url = $this->getVideoLivePushUrl(Yii::app()->params['QcloudLiveBizid'], $live_id, Yii::app()->params['QcloudLiveAntiKey'], $endTime);
        dump($url);
    }

    public function actionGetPlayUrl($live_id) {
        $url = $this->getVideoLivePlayUrl(Yii::app()->params['QcloudLiveBizid'], $live_id);
        dump($url);
    }

    /**
     * 获取推流地址
     * 如果不传key和过期时间，将返回不含防盗链的url
     * @param bizId 您在腾讯云分配到的bizid
     * streamId 您用来区别不通推流地址的唯一id
     * key 安全密钥
     * time 过期时间 sample 2016-11-12 12:00:00
     * @return String url */
    private function getVideoLivePushUrl($bizId, $streamId, $key = null, $time = null) {

        if ($key && $time) {
            $txTime = strtoupper(base_convert(strtotime($time), 10, 16));
            //txSecret = MD5( KEY + livecode + txTime )
            //livecode = bizid+"_"+stream_id  如 8888_test123456
            $livecode = $bizId . "_" .md5(strtotime("now")."_". $streamId); //直播码
            $txSecret = md5($key . $livecode . $txTime);
            $ext_str = "?" . http_build_query(array(
                        "bizid" => $bizId,
                        "txSecret" => $txSecret,
                        "txTime" => $txTime
            ));
        }
        return "rtmp://" . $bizId . ".livepush.myqcloud.com/live/" . $livecode . (isset($ext_str) ? $ext_str : "");
    }

    /**
     * 获取播放地址
     * @param bizId 您在腾讯云分配到的bizid
     * streamId 您用来区别不通推流地址的唯一id
     * @return String url */
    private function getVideoLivePlayUrl($bizId, $streamId, $type = '') {
        $livecode = $bizId . "_" .md5(strtotime("now")."_". $streamId); //直播码
		$livecode_c = $bizId . "_" .md5(strtotime("now")."_". $streamId);
        if ($type == 'hd') {
            $livecode.='_900';
        } elseif ($type == 'sd') {
            $livecode.='_550';
        }
        return array(
            "rtmp://" . $bizId . ".liveplay.myqcloud.com/live/" . $livecode,
            "http://" . $bizId . ".liveplay.myqcloud.com/live/" . $livecode . ".flv",
            "http://" . $bizId . ".liveplay.myqcloud.com/live/" . $livecode . ".m3u8",
			$livecode_c
			
        );
    }

    private function GetVideoLiveInfo($live_id,$endTime) {
        $data = array();
        $data['status'] = 1;
        $data['push_url'] = $this->getVideoLivePushUrl(Yii::app()->params['QcloudLiveBizid'], $live_id, Yii::app()->params['QcloudLiveAntiKey'], $endTime);
        $rs = $this->getVideoLivePlayUrl(Yii::app()->params['QcloudLiveBizid'], $live_id);
        $data['play_rtmp'] = $rs[0];
        $data['play_flv'] = $rs[1];
        $data['play_hls'] = $rs[2];
        $rs = $this->getVideoLivePlayUrl(Yii::app()->params['QcloudLiveBizid'], $live_id, 'sd');
        $data['play_rtmp_sd'] = $rs[0];
        $data['play_flv_sd'] = $rs[1];
        $data['play_hls_sd'] = $rs[2];
		$data['channel_id'] = $rs[3];
		
        return $data;
    }
    
    /**
     * http://fcgi.video.qcloud.com/common_access  Live_Tape_Start：创建录制任务
     * 插入直播节目单是创建直播录制
     * @return $record_task_id
     */
	 /**********************************************************************************/
    private function CreateLiveRecord($live_id,$startTime,$endTime){
    	$txTime=time()+60;//1分钟内请求有效
    	$bizId=Yii::app()->params['QcloudLiveBizid'];
		$key=Yii::app()->params['QcloudLiveAuthKey'];
        $livecode = $bizId . "_" .md5(strtotime("now")); //直播码
		//$livecode = $bizId . "_" .md5(strtotime("now")."_". $live_id); //直播码
        $txSecret = md5($key  . $txTime);
        $package =  array(
			"appid" => Yii::app()->params['QcloudLiveAppid'],
            "interface" => "Live_Tape_Start",
            "t" => $txTime,
            "sign" => $txSecret,
            "Param.s.channel_id" => $livecode,
            "Param.s.start_time" => urlencode($startTime),
            "Param.s.end_time" => urlencode($endTime),
            "Param.s.file_format" => "mp4",
        );
        $rs = send_request(Yii::app()->params['QcloudLiveFcgi'], $package, 'GET');
        $task_id=$rs['ret']==0?$rs['output']['task_id']:"";
       // $record_task_id.=(empty($record_task_id)?"":",").$task_id;
//        $start=strtotime($startTime);
//        $end=strtotime($endTime);
//        $lend=$start;
//        $record_task_id="";
//        $tlen=3600;
//		while($end-$lend>$tlen){
//			$lend=$start+$tlen;
//			$package['Param.s.start_time']=urlencode(date($start));
//			$package['Param.s.end_time']=urlencode(date($lend));
//	        $start=$lend+1;
//	        $rs = send_request(Yii::app()->params['QcloudLiveFcgi'], $package, 'GET');
//	        $task_id=$rs['ret']==0?$rs['output']['task_id']:"";
//	        $record_task_id.=(empty($record_task_id)?"":",").$task_id;
//		}
        return $task_id;
    } 
	/************************************************************************************/
    /**
     * Live_Tape_Stop：结束录制任务
     * 参数名		参数含义	类型	备注
		ret		返回码	int	0:成功；其他值:失败
		message	错误信息	string	错误信息
	 * @return 1-成功，0-失败
     */
    private function StopLiveRecord($live_id,$task_id){
    	$txTime=time()+60;//1分钟内请求有效
    	$bizId=Yii::app()->params['QcloudLiveBizid'];
		$key=Yii::app()->params['QcloudLiveAuthKey'];
        $livecode = $bizId; //直播码
		//$livecode = $bizId . "_" . $live_id; //直播码
        $txSecret = md5($key  . $txTime);
        $package =  array(
			"appid" => Yii::app()->params['QcloudLiveAppid'],
            "interface" => "Live_Tape_Stop",
            "t" => $txTime,
            "sign" => $txSecret,
            "Param.s.channel_id" => $livecode,
            "Param.s.task_id" => $task_id,
        );
        $rs = send_request(Yii::app()->params['QcloudLiveFcgi'], $package, 'GET');
        return $rs['ret']==0&&isset($rs['message'])?1:0;
    }
	
////////////////////////////////////////生成得闲体育云频道////////////////////////////////////////////////
public function actionGetVideoLiveInfo_GF($live_id,$live_code) {
        $data = array();
        $server_name = $_SERVER['SERVER_NAME'];
        $live = 'live';
        if($server_name==wwwsportnet()) $live = 'live_R1';
        if($server_name=='oss.gfinter.net') $live = 'live_R2';
		if($live_code!=''){
			$code=md5($live_code);
			$datetime=date('Y-m-d H:i:s');
			$secret=md5(strtotime($datetime));
			$data['status'] = 1;
			$data['push_url_date'] = $datetime;
			$data['push_url_secret'] = $secret;
			$data['push_url'] = 'rtmp://livepush.gf41.net/'.$live.'/'.$code.'?pushId='.$live_id.'&Secret='.$secret;
			$data['play_rtmp'] = 'rtmp://livepush.gf41.net/'.$live.'/'.$code;  // 旧：liveplay.gf41.net
			$data['play_flv'] = '';
			$data['play_hls'] = 'https://liveplay.gf41.net/'.$live.'/'.$code.'/index.m3u8';
			$data['play_rtmp_sd'] = 'rtmp://livepush.gf41.net/'.$live.'_play/'.$code;
			$data['play_flv_sd'] = '';
			$data['play_hls_sd'] = 'https://liveplay.gf41.net/'.$live.'_play/'.$code.'/index.m3u8';
		} else {
			$data['status'] = 0;
		}
        
        ajax_exit($data);
    }

    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('if_del'=>649));
                $count++;
            
        }
        
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
//撤销审核
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('live_state'=>721));
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }
//下线处理
    public function actionDown($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('is_uplist'=>0));
                $count++;
            
        }
        
        if ($count > 0) {
            ajax_status(1, '下线成功');
        } else {
            ajax_status(0, '下线失败');
        }
    }
//上线处理
    public function actionOnline($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('is_uplist'=>1));
                $count++;
            
        }
        
        if ($count > 0) {
            ajax_status(1, '上线成功');
        } else {
            ajax_status(0, '上线失败');
        }
    }
    public function actionIndex_monitoring(){
        $modelName = $this->model;
        $model = $modelName::model();
        $data = array();
		$condition = get_where_club_project('club_id').' and video_live.if_del=648 and video_live.live_state=2 and video_live.state=1364 and video_live.is_uplist=1 group by video_live.id order by video_live.is_rtmp<>1,video_live.id DESC';
		$model = $modelName::model()->findAllBySql('select video_live.* from video_live join video_live_programs on video_live_programs.live_id=video_live.id and video_live_programs.program_end_time>date_add(now(),interval -5 minute) where '.$condition);
        $data['model']=$model;
        $this->render('index_monitoring',$data);
    } 

    public function actionCompany($id){
        $modelName = $this->model;
        $mainVideo =$this->loadModel($id, $modelName);
        $data = array();
        $data['mainVideo']=$mainVideo;
        $data['message']=new VideoLiveMessage();
        $data['rewardRecord']=VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type=32');
        $data['setRecord']=VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type=36');
        $data['model']=$modelName::model()->findAll('is_online=0');
        $this->render('company',$data);
    }

    public function actionPlatform($id=0){
        $modelName = $this->model;
		$condition = get_where_club_project('club_id').' and video_live.if_del=648 and video_live.live_state=2 and video_live.state=1364 and video_live.is_uplist=1 group by video_live.id order by video_live.is_rtmp<>1,video_live.id DESC';
        $one = $modelName::model()->findBySql('select video_live.* from video_live join video_live_programs on video_live_programs.live_id=video_live.id and video_live_programs.program_end_time>date_add(now(),interval -5 minute) where '.$condition);
        if(empty($id) && !empty($one))$id = $one->id;
        $mainVideo = $this->loadModel($id, $modelName);
        $data = array();
        $data['mainVideo'] = $mainVideo;
        $data['message'] = new VideoLiveMessage();
        $data['rewardRecord'] = VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type=32');
        $data['setRecord'] = VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type=36 and client_type=7 and live_reward_id=0');
        $data['programs'] = VideoLivePrograms::model()->findAllBySql('select video_live_programs.*,(case when video_live_programs.program_time<=now() and video_live_programs.program_end_time>now() then 1 when video_live_programs.program_end_time <=now() then 2 when video_live_programs.program_time<=now() and video_live_programs.program_end_time>now() then 2 else 0 end) as program_type from video_live_programs where live_id='.$id);
        $this->render('platform',$data);
    }

    public function actionPlatform_talk($id=0){
        $modelName = $this->model;
		$condition = get_where_club_project('club_id').' and video_live.if_del=648 and video_live.live_state=2 and video_live.state=1364 and video_live.is_uplist=1 group by video_live.id order by video_live.is_rtmp<>1,video_live.id DESC';
        $one = $modelName::model()->findBySql('select video_live.* from video_live join video_live_programs on video_live_programs.live_id=video_live.id and video_live_programs.program_end_time>date_add(now(),interval -5 minute) where '.$condition);
        if(empty($id) && !empty($one))$id = $one->id;
        $mainVideo = $this->loadModel($id, $modelName);
        $data = array();
        $data['mainVideo'] = $mainVideo;
        $data['message'] = new VideoLiveMessage();
		$Sensitive_condtion='live_id='.$id.' and m_type in (31) and sensitive_check_state=371 order by s_time';
        $data['talkSensitive'] = VideoLiveMessage::model()->findAll($Sensitive_condtion);
        $data['talkSensitiveCount'] = VideoLiveMessage::model()->count($Sensitive_condtion);
        $data['programs'] = VideoLivePrograms::model()->findAllBySql('select video_live_programs.*,(case when video_live_programs.program_time<=now() and video_live_programs.program_end_time>now() then 1 when video_live_programs.program_end_time <=now() then 2 when video_live_programs.program_time<=now() and video_live_programs.program_end_time>now() then 2 else 0 end) as program_type from video_live_programs where live_id='.$id);
        $this->render('platform_talk',$data);
    }

    public function actionRtmp_time($id){
        $modelName = $this->model;
        $model =$this->loadModel($id, $modelName);
        $is_rtmp = 0;
        if($model->is_rtmp==1){
            $is_rtmp = 1;
        }
        echo $is_rtmp;
    }

    public function actionReward_text($id){
        $data = array();
        $data['rewardRecord'] = VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type=32 order by s_time');
     
        $data['t_id'] = $id;
        $this->render('reward_text',$data);
    }

    public function actionTop_comment($id){
        $arr1 = array();
        // $data = VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type=32 order by s_time');
        $sql = 'select a.id,a.s_gfaccount,a.live_reward_gf_name,a.live_reward_actor_name,a.live_reward_name,a.live_reward_price ';
        $sql .= 'from (select b.* from video_live_realtime_interaction_message b where b.live_id='.$id.' and b.m_type=32 and b.s_time>date_add(now(), interval -30 minute) order by b.s_time desc) a order by a.s_time';
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($data))foreach($data as $key => $val){
            $arr1[$key]['id'] = $val['id'];
            $arr1[$key]['s_gfaccount'] = $val['s_gfaccount'];
            $arr1[$key]['f_name'] = !empty($val['live_reward_gf_name']) ? $val['live_reward_gf_name'] : $val['live_reward_actor_name'];
            $arr1[$key]['live_reward_name'] = $val['live_reward_name'];
            $arr1[$key]['live_reward_price'] = $val['live_reward_price'];
        }
        echo CJSON::encode($arr1);
    }

    public function actionTalk_text($id){
        $data = array();
        $data['talkRecord'] = VideoLiveMessage::model()->findAll('live_id='.$id.' and m_type in (31,38,39) and sensitive_check_state=2 order by if(isnull(sensitive_check_state_time),0,1),s_time');
        $data['t_id'] = $id;
        $this->render('talk_text',$data);
    }

    public function actionTalk_comment($id){
        $arr1 = array();
		$sql = 'select * from video_live_realtime_interaction_message where live_id='.$id.' and m_type in (31,38,39) and sensitive_check_state=2 and (s_time>date_add(now(), interval -30 minute) or sensitive_check_state_time>date_add(now(), interval -30 minute)) order by if(isnull(sensitive_check_state_time),0,1),s_time';
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($data))foreach($data as $key => $val){
            $arr1[$key]['id'] = $val['id'];
            $arr1[$key]['m_message'] = $val['m_message'];
            $arr1[$key]['m_type'] = $val['m_type'];
            $arr1[$key]['s_time'] = $val['s_time'];
        }
        echo CJSON::encode($arr1);
    }

    public function actionSensitive_text($id){
        $data = array();
		$sql = 'select a.*,b.live_im_key from video_live_realtime_interaction_message a left join video_live_programs b on b.id=a.live_program_id where a.live_id='.$id.' and a.m_type in (31) and a.sensitive_check_state=371 order by a.s_time';
        $data['talkSensitive'] = Yii::app()->db->createCommand($sql)->queryAll();
        $data['t_id'] = $id;
        $this->render('sensitive_text',$data);
    }

    public function actionSensitive_comment($id){
        $arr1 = array();
		$sql = 'select a.*,b.live_im_key from video_live_realtime_interaction_message a left join video_live_programs b on b.id=a.live_program_id where a.live_id='.$id.' and a.m_type in (31) and a.sensitive_check_state=371 and a.s_time>date_add(now(), interval -30 minute) order by a.s_time';
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($data))foreach($data as $key => $val){
            $arr1[$key]['id'] = $val['id'];
            $arr1[$key]['m_message'] = $val['m_message'];
            $arr1[$key]['m_type'] = $val['m_type'];
            $arr1[$key]['s_time'] = $val['s_time'];
            $arr1[$key]['live_program_id'] = $val['live_program_id'];
            $arr1[$key]['s_gfid'] = $val['s_gfid'];
            $arr1[$key]['s_gfaccount'] = $val['s_gfaccount'];
            $arr1[$key]['live_im_key'] = $val['live_im_key'];
        }
        echo CJSON::encode($arr1);
    }

    public function actionUpdateSensitiveState($id,$state,$admin_id,$admin_name) {
        $data=array();
        $modelName = VideoLiveMessage::model();
        $model =$this->loadModel($id, $modelName);
        $a=VideoLiveMessage::model()->updateAll(array("sensitive_check_state"=>$state,"sensitive_check_state_qmddid"=>$admin_id,"sensitive_check_state_qmddname"=>$admin_name),'id='.$id);
		if($a==1){
			$data["error"]=0;
		}else{
			$data["error"]=1;
		}
        echo CJSON::encode($data);
    }

    public function actionSendMessage($message,$target){
        $data=array();
		$sendArr = array('type'=>'系统通知','pic'=>'','title'=>'','content'=>$message,'url'=>'');
		video_message(36,get_session('admin_id'),$target,$sendArr);
        echo CJSON::encode($data);
    }

    public function actionUpdateState($id,$attr,$state) {
        $data=array();
        $modelName = $this->model;
        $model =$this->loadModel($id, $modelName);
        $stateName = ['关闭','打开','直播',"切播",'断流','打开'];
        VideoLive::model()->updateAll(array($attr=>$state),'id='.$id);
        $state1 = $state;
        if($attr=='line_show') $state1+=2;
        if($attr=='is_online') $state1+=4;
        $msg = $model->getAttributeLabel($attr).'变更为：'.$stateName[$state1];
        $data['message'] = $msg;
        $data['time'] = get_date();
        $info_arr = array($attr=>$state);
        $data['info_data'] = video_message(36,get_session('admin_id'),$id,$info_arr);

        echo CJSON::encode($data);
    }

    public function actionUpdateProgramState($id,$attr,$state) {
        $data=array();
        $modelName = VideoLivePrograms::model();
        $model =$this->loadModel($id, $modelName);
        VideoLivePrograms::model()->updateAll(array($attr=>$state),'id='.$id);
        $msg = '节目 "'.$model->title.'" 变更为：'.($state==649?'上线':'下线');
        $data['message'] = $msg;
        $data['time'] = get_date();
		$programs_change=array('online'=>($state==649?1:0),'program_id'=>$id,'program_title'=>$model->title);
        $info_arr = array('programs_change'=>$programs_change);
        $data['info_data'] = video_message(36,get_session('admin_id'),$model->live_id,$info_arr);
        echo CJSON::encode($data);
    }

    // 总监控返回视频
    public function actionMouseVideo($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $arr = array();
        $arr['logo'] = BasePath::model()->get_www_path().$model->logo;
        $arr['live_source_HLS_H'] = $model->live_source_HLS_H;
        echo CJSON::encode($arr);
    }
	
	//直播数据统计列表
    public function actionIndex_stats($keywords = '',$star='',$end='') {
         $this->ShowView($keywords,$star,$end,'live_state=2','state=1364 and live_source_RTMP<>""',0,'index_rtmp');
    }

    // public function actionIndex_details($keywords=''){
    //     set_cookie('_currentUrl_', Yii::app()->request->url);
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = get_where_club_project('club_id','');
    //     $criteria->condition = get_like($criteria->condition,'title,code',$keywords,'');
    //     $criteria->order ='id DESC';
    //     $data = array();
    //     parent::_list($model, $criteria, 'index_details', $data);
    // }

    // public function actionUpdate_details($id){
    //     $modelName = $this->model;
    //     $model = $this->loadModel($id, $modelName);
    //     $data = array();
    //     if(!Yii::app()->request->isPostRequest) {
    //         $data['model'] = $model;
    //         $this->render('update_details',$data);
    //     }
    //     else{
    //         $this->saveData($model,$_POST[$modelName]);
    //     }
    // }
}