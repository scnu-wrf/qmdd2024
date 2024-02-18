<?php

class BoutiqueVideoSeriesController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
	
	//发布视频分集
	public function actionPublish_index($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->join ='left join boutique_video on boutique_video.id=t.video_id';
        $criteria->condition = 't.if_del=648 and t.state<>2 and boutique_video.state=2';
        $criteria->condition .=' and t.club_id='.get_SESSION('club_id');
		$criteria->condition=get_like($criteria->condition,'t.video_title,t.video_code',$keywords,'');
		//$criteria->group='t.series_publish_id';
        $criteria->order = 't.id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(143);
        parent::_list($model, $criteria, 'publish_index', $data, 10);
    }
	
    //视频分集列表
    public function actionIndex($publish_classify = '', $keywords = '',$start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 't.if_del=648 and t.state=2 and t.down_type=0';
        $criteria->condition .=' and t.club_id='.get_SESSION('club_id');
		if(!empty($start_date)){
			$criteria->condition.=' and t.state_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and t.state_time<="'.$end_date.' 23:59:59"';
		}
		if(!empty($publish_classify)){
			$criteria->condition .=' and boutique_video.publish_classify='.$publish_classify;
		}
		$criteria->condition=get_like($criteria->condition,'t.video_title,t.video_series_code',$keywords,'');
		//$criteria->group='t.id';
		$criteria->join='left join boutique_video on boutique_video.id=t.video_id';
        $criteria->order = 't.video_id DESC,t.video_series_num,t.id';
        $data = array();
        $data['publish_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['publish_classify'][$v->id] = $v->sn_name;
        }
		$data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index', $data, 10);
    }
	//视频分集列表-详情
    public function actionVideo_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // 获取发布分类
            if (!empty($model->publish_classify)) {
                $data['publish_classify'] = VideoClassify::model()->findAll('id in (' . $model->publish_classify . ')');
            } else {
                $data['publish_classify'] = array();
            }
			$model->programs_list = 1;
            $this->render('video_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate() {
		$modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['programs'] = array();
            $this->render('create_program', $data);
        } else {
            $this->save_programs($_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
			if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_program', $data);
        } else{
            $this->save_programs($_POST[$modelName]);
        }
    }

    public function actionUpdate_audit_submit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
			$data["live_list"]=BoutiqueVideo::model()->findAll('state=2 and is_uplist=1 and down_type=0 and club_id=' . get_session('club_id')." order by id desc LIMIT 0,10");
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
			if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_audit_submit', $data);
        } else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_audit_fail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
			$data["live_list"]=BoutiqueVideo::model()->findAll('state=2 and is_uplist=1 and down_type=0 and club_id=' . get_session('club_id')." order by id desc LIMIT 0,10");
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
			if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_audit_fail', $data);
        } else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_audit_return($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
			$data["live_list"]=BoutiqueVideo::model()->findAll('state=2 and is_uplist=1 and down_type=0 and club_id=' . get_session('club_id')." order by id desc LIMIT 0,10");
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
			if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update_audit_return', $data);
        } else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
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
	
	//发布审核
	public function actionAudit_list($keywords = '',$start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648';
		$criteria->condition .=' and state in (2,373,1538)';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($start_date)){
			$criteria->condition.=' and state_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and state_time<="'.$end_date.' 23:59:59"';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_series_code',$keywords,'');
		//$criteria->group='series_publish_id';
        $criteria->order = 'series_publish_id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['num'] = $model->findBySql('SELECT count(a.id) as submit_count from (SELECT * from boutique_video_series where if_del=648 and state=371 GROUP BY series_publish_id) a')->submit_count;
        parent::_list($model, $criteria, 'audit_list', $data,10);
    }
	//发布审核-查看
    public function actionAudit_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('audit_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//发布审核-待审核
	public function actionSubmit_list($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and state=371';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		$criteria->condition=get_like($criteria->condition,'video_series_title,video_series_code',$keywords,'');
		//$criteria->group='series_publish_id';
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'submit_list', $data,10);
    }
	//发布审核-待审核-审核
    public function actionSubmit_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('submit_detail', $data);
        } else {
            $model->attributes =$_POST[$modelName];
			if ($_POST['submitType'] == 'tongguo') {
                $state = 2;
            } else if ($_POST['submitType'] == 'butongguo') {
                $state = 373;
            } else if ($_POST['submitType'] == 'tuihui') {
                $state = 1538;
            }
            $st=0;
            $now=date('Y-m-d H:i:s');
            if($state!=''){
				BoutiqueVideoSeries::model()->updateAll(array('state'=>$state, 'state_time'=>$now, 'admin_id'=>get_session('admin_id'), 'reasons_for_failure'=>$model->reasons_for_failure),'video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
                $st++;
            }
            show_status($st,'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }
    }
	
	//分集未通过列表
	public function actionAudit_fail_list($keywords = '',$start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648';
		$criteria->condition .=' and state=373';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($start_date)){
			$criteria->condition.=' and state_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and state_time<="'.$end_date.' 23:59:59"';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='series_publish_id';
        $criteria->order = 'series_publish_id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'audit_fail_list', $data,10);
    }
	//分集未通过列表-详情
    public function actionAudit_fail_detail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // 获取节目
            $data['programs'] = BoutiqueVideoSeries::model()->findAll('video_id='.$model->video_id.' and series_publish_id='.$model->series_publish_id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('audit_fail_detail', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	//视频分集下架列表
    public function actionDown_index($keywords = '', $start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and down_type in (1,2,3)';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		if(!empty($start_date)){
			$criteria->condition.=' and down_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and down_time<="'.$end_date.' 23:59:59"';
		}
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		//$criteria->group='id';
        $criteria->order = 'id DESC';
        $data = array();
        $data['publish_classify'] = array();
        $classify = VideoClassify::model()->getCode(365);
        foreach ($classify as $v) {
            $data['publish_classify'][$v->id] = $v->sn_name;
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'down_index', $data, 10);
    }
	//视频分集下架列表-下架选择
    public function actionDown_select($keywords = '') {
        $data = array();
		$modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and state=2 and down_type not in (1,2,3)';
        $criteria->condition .=' and '.get_where_club_project('club_id');
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
        parent::_list($model, $criteria, 'down_select', $data,10);
    }
    
	function saveData($model,$post) {
		$model->attributes =$post;
        $now=date('Y-m-d H:i:s');
        $sv=$model->save();
        show_status($sv,'操作成功', get_cookie('_currentUrl_'),'操作失败'); 
    }
	
	//保存节目单
    public function save_programs($post){
		$video_id=$post["video_id"];
		$series_publish_id=$post["series_publish_id"];
		if(!empty($video_id)){
			if(!empty($series_publish_id)){
				BoutiqueVideoSeries::model()->updateAll(array('video_duration'=>'-1'),'video_id='.$video_id.' and series_publish_id='.$series_publish_id);//做临时删除标识
			}
			if (isset($_POST['programs_list'])) {
				foreach ($_POST['programs_list'] as $v) {
					if ($v['id']=='null') {
						if(empty($series_publish_id)){
							$publish = new VideoSeries(); 
							$publish->isNewRecord = true;
							unset($publish->id);
							$publish->video_id=$video_id;
							$publish->save();
							$series_publish_id=$publish->id;
						}
						$programs = new BoutiqueVideoSeries(); 
						$programs->isNewRecord = true;
						unset($programs->id);
						$programs->series_publish_id = $series_publish_id;
					} else{
						$programs=BoutiqueVideoSeries::model()->find('id='.$v['id']);
					}
					if (empty($programs->video_series_code)) {
						// 生成节目单编号
						$service_code = '';
						$live= BoutiqueVideo::model()->find('id='.$video_id);
						$service_code=$live->video_code;
						$code_num ='01';
						$live_program=BoutiqueVideoSeries::model()->find('video_id=' . $video_id . ' and video_series_code is not null order by id DESC');
						if (!empty($live_program)) {
							$num=intval(substr($live_program->video_series_code, -2));
							$code_num = substr('00' . strval($num + 1), -2);
						}
						$service_code.='-'.$code_num;
						$programs->video_series_code = $service_code;
					}
					$programs->video_id = $video_id;
					$programs->video_series_title = $v['video_series_title'];
					$programs->video_series_num = $v['video_series_num'];
					$programs->video_duration = $v['video_duration'];
					$programs->video_format = $v['video_format'];
					$programs->video_source_id = $v['video_source_id'];
					$programs->programs_list = 1;
					$programs->club_id=get_session('club_id');
					$programs->is_uplist=$post['is_uplist'];
					$now=date('Y-m-d H:i:s');
					if ($_POST['submitType'] == 'shenhe') {
						$programs->state = 371;
						$programs->apply_time = $now;
						$programs->publish_time = $now;
						$programs->publish_id = get_session('admin_id');
					} else if ($_POST['submitType'] == 'baocun') {
						$programs->state = 721;
						$programs->publish_time = $now;
						$programs->publish_id = get_session('admin_id');
					} else if ($_POST['submitType'] == 'tongguo') {
						$programs->state = 2;
						$programs->state_time = $now;
						$programs->admin_id = get_session('admin_id');
						$programs->admin_nick = get_session('admin_name');
					} else if ($_POST['submitType'] == 'butongguo') {
						$programs->state = 373;
						$programs->state_time = $now;
						$programs->admin_id = get_session('admin_id');
						$programs->admin_nick = get_session('admin_name');
					} else {
						$programs->state = 721;
						$programs->publish_time = $now;
						$programs->publish_id = get_session('admin_id');
					}
					$sv=$programs->save();
				}
			}
		}
        
        BoutiqueVideoSeries::model()->deleteAll('video_duration="-1"');
        show_status($sv,'操作成功', get_cookie('_currentUrl_'),'操作失败');
    }
	
    //视频列表-视频分集
    public function actionVideo_series_list($video_id = '',$club=0,$down=0) {
        $data = array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648 and state=2 and down_type=0';
        $criteria->condition .= ' and video_id='.$video_id;
        parent::_list($model, $criteria, 'video_series_list', $data, 10);
    }
	
	//添加视频分集视频-视频列表
    public function actionCustomer_service_list($keywords = '',$club_id="") {
		$data = array();
        $model = BoutiqueVideo::model();
        $criteria = new CDbCriteria;
		$criteria->condition="club_id=".get_SESSION('club_id');
		$criteria->condition.=" and down_type=0 and if_del=648 and state=2 and live_program_id is null";
		$criteria->condition=get_like($criteria->condition,'video_title,video_code',$keywords,'');
		$criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'customer_service_list', $data,10);
    }
	//撤销申请
    public function actionChexiao($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
			$model->updateByPk($d,array('state'=>721));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	//下架视频分集
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
	//修改分集排序
    public function actionChangeSeries_num($id,$video_series_num) {
        $modelName = $this->model;
        $model = $modelName::model();
		$sv=$model->updateByPk($id,array('video_series_num'=>$video_series_num));
        if ($sv > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	
}
