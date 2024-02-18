<?php

class BoutiqueVideoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
	
	//发布视频
	public function actionPublish_index($video_classify = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and live_program_id is null and state<>2';
        $criteria->condition .=' and club_id='.get_SESSION('club_id');
		if(!empty($video_classify)){
			$criteria->condition .=' and '.$video_classify.' in (publish_classify)';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='id';
        $criteria->order = 'id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        parent::_list($model, $criteria, 'publish_index', $data, 10);
    }
	//发布视频-添加
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
            $model->video_source_id = '';
			$data['project_list'] = array();
            $data['programs'] = array();
            $this->render('create', $data);
        } else {
			$this-> saveData($model,$_POST[$modelName]);           
        }
    }
	//发布视频-编辑
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	//发布视频-详情（审核未通过）
    public function actionUpdate_audit_fail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}  
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_audit_fail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	//发布视频-修改
    public function actionUpdate_audit_return($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}  
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_audit_return', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	//发布视频-详情（待审核）
    public function actionUpdate_audit_submit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}  
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_audit_submit', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//发布审核
	public function actionAudit_list($video_classify = '', $keywords = '',$start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 't.if_del=648 and live_program_id is null';
		$criteria->condition .=' and t.state in (2,373,1538)';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($video_classify)){
			$criteria->condition .=' and '.$video_classify.' in (video_classify)';
		}
		if(!empty($start_date)){
			$criteria->condition.=' and state_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and state_time<="'.$end_date.' 23:59:59"';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='t.id';
        $criteria->order = 't.id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['num'] = $model->count('t.if_del=648 and t.state=371 and live_program_id is null');
        parent::_list($model, $criteria, 'audit_list', $data,10);
    }
	//发布审核-查看
    public function actionAudit_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('audit_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//发布审核-待审核
	public function actionSubmit_list($video_classify = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 't.if_del=648 and t.state=371 and live_program_id is null';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($video_classify)){
			$criteria->condition .=' and '.$video_classify.' in (video_classify)';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='t.id';
        $criteria->order = 't.id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        parent::_list($model, $criteria, 'submit_list', $data,10);
    }
	//发布审核-待审核-审核
    public function actionSubmit_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('submit_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//审核未通过列表
	public function actionAudit_fail_list($video_classify = '', $keywords = '',$start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 't.if_del=648 and live_program_id is null';
		$criteria->condition .=' and t.state=373';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($video_classify)){
			$criteria->condition .=' and '.$video_classify.' in (video_classify)';
		}
        if(!empty($start_date)){
			$criteria->condition.=' and state_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and state_time<="'.$end_date.' 23:59:59"';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='t.id';
        $criteria->order = 't.id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['num'] = $model->count('t.if_del=648 and t.state=371 and live_program_id is null');
        parent::_list($model, $criteria, 'audit_fail_list', $data,10);
    }
	//审核未通过列表-查看
    public function actionAudit_fail_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}  
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('audit_fail_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//视频列表
    public function actionIndex($video_classify = '', $keywords = '',$start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
		$criteria->condition="club_id=".get_SESSION('club_id');
        $criteria->condition.= ' and if_del=648 and state=2 and down_type=0 and now() between video_start and video_end and live_program_id is null';
        if(!empty($start_date)){
			$criteria->condition.=' and state_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and state_time<="'.$end_date.' 23:59:59"';
		}
		if(!empty($video_classify)){
			$criteria->condition .=' and '.$video_classify.' in (video_classify)';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='id';
        $criteria->order = 'id DESC';
        $data = array();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');

        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index', $data, 10);
    }
	//视频列表-详情
    public function actionVideo_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('video_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//下架视频列表
    public function actionDown_index($video_classify = '',$down_type = '', $keywords = '', $start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and down_type in (1,2,3) and live_program_id is null';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($video_classify)){
			$criteria->condition .=' and '.$video_classify.' in (video_classify)';
		}
		if(!empty($down_type)){
			$criteria->condition .=' and down_type='.$down_type;
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		if(!empty($start_date)){
			$criteria->condition.=' and down_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and down_time<="'.$end_date.' 23:59:59"';
		}
		//$criteria->group='id';
        $criteria->order = 'id DESC';
        $data = array();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');

        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'down_index', $data, 10);
    }
	//下架视频列表-详情
    public function actionDown_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}  
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('down_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	//下架视频列表-下架选择
    public function actionDown_select($keywords = '') {
        $data = array();
		$modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and state=2 and down_type not in (1,2,3) and live_program_id is null';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
        parent::_list($model, $criteria, 'down_select', $data,10);
    }
	
	//各单位视频列表
    public function actionSearch_index($video_classify = '', $keywords = '', $club_name = '', $search = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		// if(empty($search)){
			// $criteria->condition = '1=0';
		// }else{
			$criteria->condition = 't.if_del=648 and state=2 and down_type not in (1,2,3) and now() between video_start and video_end and live_program_id is null';
			$criteria->condition .=' and '.get_where_club_project('club_id');
			if(!empty($video_classify)){
				$criteria->condition .=' and '.$video_classify.' in (video_classify)';
			}
			$criteria->condition=get_like($criteria->condition,'video_title,video_code,club_name',$keywords,'');
			$criteria->condition=get_like($criteria->condition,'club_name',$club_name,'');
			//$criteria->group='t.id';
			$criteria->order = 't.is_top DESC,t.id DESC';
		// }
        $data = array();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['base_path'] = BasePath::model()->getPath(143);
        $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');

        $data['video_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['video_classify'][$v->id] = $v->sn_name;
        }
		$project_list = ProjectList::model()->findAll("");
        foreach ($project_list as $v) {
            $data['project_list'][$v->id] = $v->project_name;
        }
        parent::_list($model, $criteria, 'search_index', $data,10);
    }
	//各单位视频列表-详情
    public function actionSearch_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$video_logo=$model->video_logo;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['member_type'] = BaseCode::model()->findAll('f_id in (209,210)');
			$data['model']->video_show=explode(',',$data['model']->video_show); //把字符串打散为数组
            $basepath = BasePath::model()->getPath(180);
            $model->video_intro_temp=get_html($basepath->F_WWWPATH.$model->video_intro, $basepath);
            // 获取项目
			if(!empty($model->project_list)){
				$data['project_list'] = ProjectList::model()->findAll('id in (' . $model->project_list . ')');  
			}else{
				$data['project_list'] = array();
			}  
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
            // 获取展示分类
            if (!empty($model->video_classify)) {
                $data['video_classify'] = VideoClassify::model()->findAll('id in (' . $model->video_classify . ')');
            } else {
                $data['video_classify'] = array();
            }
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id=' . $model->id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('search_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionClassify($base_f_id='', $keywords = '') {
        $data = array();
        $model = VideoClassify::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->select = 'id as select_id,sn_name as select_title';
        $criteria->condition=get_where($criteria->condition,!empty($base_f_id),' base_f_id',$base_f_id,'');
        if ($keywords != '') {
            $criteria->condition .= ' AND sn_name like "%' . $keywords . '%"';
        }
        parent::_list($model, $criteria, 'classify', $data,10);
    }
	function saveData($model,$post) {
        $model->check_save(1);
		$model->attributes =$post;
        $now=date('Y-m-d H:i:s');
		if ($_POST['submitType'] == 'shenhe') {
			$model->state = 371;
			$model->apply_time = $now;
			$model->video_publish_time = $now;
			$model->video_publish_gfid = get_session('admin_id');
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = empty($model->state)?721:$model->state;
			$model->video_publish_time = $now;
			$model->video_publish_gfid = get_session('admin_id');
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
			$model->state_time = $now;
			$model->admin_id = get_session('admin_id');
			$model->admin_nick = get_session('admin_name');
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
			$model->state_time = $now;
			$model->admin_id = get_session('admin_id');
			$model->admin_nick = get_session('admin_name');
        } else if ($_POST['submitType'] == 'tuihui') {
			$model->state = 1538;
			$model->state_time = $now;
			$model->admin_id = get_session('admin_id');
			$model->admin_nick = get_session('admin_name');
		} else {
            $model->state = 721;
        }
		if(isset($post['video_show']))
			$model->video_show=gf_implode(',',$post['video_show']);
        $sv=$model->save();
		if($sv==1){
			if ($_POST['submitType'] == 'shenhe'||$_POST['submitType'] == 'baocun') {
				$this->save_programs($model->id);
				$this->save_project_list($model->id,$post['project_list']);
				if(!empty($model->video_logo)){
					$video_logo=0;
					$this->save_gfmaterial($video_logo,$model->video_logo,$model->video_title);
				}
			}
			BoutiqueVideoSeries::model()->updateAll(array('state'=>$model->state, 'state_time'=>$now, 'admin_id'=>$model->admin_id, 'reasons_for_failure'=>$model->reasons_for_failure),'video_id='.$model->id);
		}
        show_status($sv,'操作成功', get_cookie('_currentUrl_'),'操作失败'); 
    }
	
	public function save_project_list($id,$project_list){       
		//删除原有项目
		BoutiqueVideoProject::model()->deleteAll('boutique_video_id='.$id);
		if(!empty($project_list)){
			$model2 = new BoutiqueVideoProject();
			$club_list_pic = array();
			$club_list_pic = explode(',', $project_list);
			$club_list_pic = array_unique($club_list_pic);
			foreach ($club_list_pic as $v) {
				$model2->isNewRecord = true;
				unset($model2->id);
				$model2->boutique_video_id =$id;
				$model2->project_id = $v;
				$model2->save();
			}
		}
	}
	//保存到素材管理	
	public function save_gfmaterial($oldpic,$pic,$title){  
		$logopath=BasePath::model()->getPath(143);
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
	//保存视频分集
    public function save_programs($id){
        BoutiqueVideoSeries::model()->updateAll(array('video_duration'=>'-1'),'video_id='.$id);//做临时删除标识
        //保存节目
        if (isset($_POST['programs_list'])) foreach ($_POST['programs_list'] as $v) {
			if ($v['id']=='null') {
				if(empty($publish->id)){
					$publish = new VideoSeries(); 
					$publish->isNewRecord = true;
					unset($publish->id);
					$publish->video_id=$id;
					$publish->save();
				}
                $programs = new BoutiqueVideoSeries(); 
                $programs->isNewRecord = true;
                unset($programs->id);
				$programs->series_publish_id = $publish->id;
            } else{
                $programs=BoutiqueVideoSeries::model()->find('id='.$v['id']);
				$publish = VideoSeries::model()->find('id='.$programs->series_publish_id);
            } 
            if (empty($programs->video_series_code)) {
                // 生成节目单编号
                $service_code = '';
                $live= BoutiqueVideo::model()->find('id='.$id);
                $service_code=$live->video_code;
                $code_num ='01';
                $live_program=BoutiqueVideoSeries::model()->find('video_id=' . $id . ' and video_series_code is not null order by id DESC');
                if (!empty($live_program)) {
                    $num=intval(substr($live_program->video_series_code, -2));
                    $code_num = substr('00' . strval($num + 1), -2);
                }
                $service_code.='-'.$code_num;
                $programs->video_series_code = $service_code;
            }
            $programs->video_id = $id;
            $programs->club_id = get_session('club_id');
            $programs->video_series_title = $v['video_series_title'];
            $programs->video_series_num = $v['video_series_num'];
            $programs->video_duration = $v['video_duration'];
            $programs->video_format = $v['video_format'];
            $programs->video_source_id = $v['video_source_id'];
            $programs->programs_list = 1;
            $programs->save();
        }
        BoutiqueVideoSeries::model()->deleteAll('video_duration="-1"');
    }
	
    // public function actionDelete($id) {
        // parent::_clear($id);
    // }

    //逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $lode = explode(',', $id);
        $count = 0;
		foreach ($lode as $d) {
			$model->updateByPk($d,array('if_del'=>649,'if_del_time'=>date('Y-m-d H:i:s'),'if_del_admin'=>get_session('admin_id')));
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
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
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
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
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 

	//置顶
    public function actionIstop($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        $now=date('Y-m-d H:i:s');
        foreach ($club as $d) {
			$model->updateByPk($d,array('is_top'=>1,'is_top_time'=>$now));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    }
	//取消置顶
    public function actionNotop($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
			$model->updateByPk($d,array('is_top'=>0));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	//下架视频
    public function actionDowntype($id,$down_type=1) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        $now=date('Y-m-d H:i:s');
        foreach ($club as $d) {
			$model->updateByPk($d,array('down_type'=>$down_type,'down_time'=>$now,'down_admin_id'=>get_session('admin_id'),'down_admin_nick'=>(get_session('lang_type')==1?(get_session('club_code') .'#'. get_session('gfaccount')):(get_session('gfaccount')))));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	//撤销申请
    public function actionChexiao($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
			$model->updateByPk($d,array('state'=>721));
			BoutiqueVideoSeries::model()->updateAll(array('state'=>721),'video_id='.$d);
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	// 获取服务器时间
    public function actionGet_date(){
        $date=date("Y-m-d H:i:s");
        echo $date;
    }
}
