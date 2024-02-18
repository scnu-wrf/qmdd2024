<?php

class QmddGfSiteController extends BaseController {
    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
//场地登记列表
    public function actionIndex($keywords = '',$project = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
	    $cr='site_state in(721,371,1538,373)';
	    $cr.=' and user_club_id='.get_session('club_id');
	    if ($project>0) $cr.=' and find_in_set('.$project.',project_id)';
        $cr=get_like($cr,'t.site_code,site_name',$keywords,'');
        $criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['site_state'] = BaseCode::model()->getStateType();
		$data['project'] = ClubProject::model()->getProject(get_session('club_id'));
		parent::_list($model, $criteria, 'index', $data);
    }

	//审核列表
	public function actionIndex_pass($keywords = '',$start_date='',$end_date='',$project = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d');
        if ($start_date=='') $start_date=$now;
	    $cr='site_state in(2,373,1538)';
		//$cr.=' and if_del=510';
	    if ($project>0) $cr.=' and find_in_set('.$project.',project_id)';
        $cr=get_where($cr,$start_date,'reasons_time>=',$start_date.' 00:00:00',"'");
        $cr=get_where($cr,$end_date,'reasons_time<=',$end_date.' 23:59:59',"'");
        $cr=get_like($cr,'t.site_code,site_name',$keywords,'');
        $criteria->condition=$cr;
        //$criteria->group='t.site_code'; 
		$criteria->order = 'id DESC';
		$data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['num'] = $model->count('site_state=371');
        $data['project'] = ClubProject::model()->getProject(get_session('club_id'));
        //$data['site_envir'] = BaseCode::model()->getCode(667);
		parent::_list($model, $criteria, 'index_pass', $data);
    }
    //待审核列表
	public function actionIndex_check($keywords = '',$project = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		 $cr.=' and site_state=371';
	    if ($project>0) $cr.=' and find_in_set('.$project.',project_id)';
		//$cr=get_where($cr,!empty($site_state),'site_state',$site_state,'');
        $cr=get_like($cr,'t.site_code,site_name',$keywords,'');
        $criteria->condition=$cr;
        //$criteria->group='t.site_code';
		$criteria->order = 'id DESC';
		$data = array();
		$data['project'] = ClubProject::model()->getProject(get_session('club_id'));
		parent::_list($model, $criteria, 'index_check', $data);
    }
//审核未通过列表
    public function actionIndex_fail($keywords = '',$project = 0,$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
	
	    $cr=' site_state=373';
	    if ($project>0) $cr.=' and find_in_set('.$project.',project_id)';
        $cr=get_like($cr,'t.site_code,site_name',$keywords,'');
        $criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
		$data['project'] = ClubProject::model()->getProject(get_session('club_id'));
		parent::_list($model, $criteria, 'index_fail', $data);
    }
//场地列表
    public function actionIndex_list($keywords = '',$project = 0,$is_sale ='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN qmdd_server_sourcer on t.id = qmdd_server_sourcer.s_name_id and qmdd_server_sourcer.t_typeid=1";
		$cr='t.if_del=510';
	    $cr.=' and t.site_state=2';
	    $cr.=' and t.user_club_id='.get_session('club_id');
	    if ($project>0) $cr.=' and find_in_set('.$project.',t.project_id)';
	    if ($is_sale==648) $cr.=' and qmdd_server_sourcer.state<>2';
	    if ($is_sale==649) $cr.=' and qmdd_server_sourcer.state=2';
        $cr=get_like($cr,'t.site_code,t.site_name',$keywords,'');
        $criteria->condition=$cr;
		$criteria->order = 't.id DESC';
		$data = array();
		$data['project'] = ClubProject::model()->getProject(get_session('club_id'));
		$data['is_sale'] = BaseCode::model()->getCode(647);
		parent::_list($model, $criteria, 'index_list', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['site_prove'] = array();
			$data['project'] = array();
			$data['parent'] = array();

            $this->render('update', $data);

        }else{
            $this-> saveData($model,$_POST[$modelName]);

        }
    }



    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->site_pic;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['project']= ($model->project_ids !='') ? ProjectList::model()->findAll('id in (' . $model->project_ids . ')') : array();
            $data['model']->project_id=explode(',',$data['model']->project_id); //把字符串打散为数组
			$data['parent']= ($model->site_parent !='') ? QmddGfSite::model()->findAll('id in (' . $model->site_parent . ')') : array();
            $this->render('update', $data);

        } else {
			$this-> saveData($model,$_POST[$modelName]);
        }
    }
//场地审核-详情
	public function actionUpdate_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['project']= ($model->project_ids !='') ? ProjectList::model()->findAll('id in (' . $model->project_ids . ')') : array();
            $data['model']->project_id=explode(',',$data['model']->project_id); //把字符串打散为数组
			$data['parent']= ($model->site_parent !='') ? QmddGfSite::model()->findAll('id in (' . $model->site_parent . ')') : array();

            $this->render('update_check', $data);

        } else {
			$model->attributes =$_POST[$modelName];
			$st=0;
			$state=get_check_code($_POST['submitType']);
			$admin_id = get_session('admin_id');
            $gfaccount = get_session('gfaccount');
            $admin_nick = get_session('admin_name');
            $msg=$model->reasons_for_failure;
			$now=date('Y-m-d H:i:s');
            if($state==721){
                QmddGfSite::model()->updateAll(array('site_state'=>$state),'id='.$model->id);
                $st++;
                $s='撤销成功';$f='撤销失败';
            } else{
                QmddGfSite::model()->updateAll(
                    array('site_state'=>$state,
                        'reasons_time'=>$now,
                        'reasons_for_failure'=>$msg,
                        'reasons_adminID'=>$admin_id,
                        'reasons_gfaccount'=>$gfaccount,
                        'reasons_adminname'=>$admin_nick,
                    ),'id='.$model->id);
                if($state==2) $this->Save_Sourcer($model->id);
                $st++;
                $s='操作成功';$f='操作失败';
            }
            show_status($st,$s,get_cookie('_currentUrl_'),$f);
        }
    }
   //场地列表-详情
	public function actionUpdate_list($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['project']= ($model->project_ids !='') ? ProjectList::model()->findAll('id in (' . $model->project_ids . ')') : array();
            $data['model']->project_id=explode(',',$data['model']->project_id); //把字符串打散为数组
			$data['parent']= ($model->site_parent !='') ? QmddGfSite::model()->findAll('id in (' . $model->site_parent . ')') : array();

            $this->render('update_check', $data);

        } else {
			$model->attributes =$_POST[$modelName];
			$state=get_check_code($_POST['submitType']);
			$st=0;
			$site_parent=$model->site_parent;
            if($state!=''){
                QmddGfSite::model()->updateAll(array('site_parent'=>$site_parent),'id='.$model->id);
                $st++;
                $s='保存成功';$f='保存失败';
            }
            show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        $model->project_id=gf_implode(',',$model->project_id); //把数组元素组合为一个字符串
        if($_POST['submitType']=='shenhe'){
           $model->apply_time=date('Y-m-d h:i:s');
       }
		$arr= array();
		$model->site_state =get_check_code($_POST['submitType']);
		$gfsite= GfSite::model()->find('id='.$post['site_id']);
		$project_list= GfSiteProject::model()->findAll('site_id='.$gfsite->id);
		if(!empty($project_list)) foreach ($project_list as $v){
			$arr[]=$v->project_id;
		}
		$project=implode(',', $arr);
		$model->site_date_start=$gfsite->site_date_start;
		$model->site_date_end=$gfsite->site_date_end;
		$model->site_area=$gfsite->site_area;
		$model->site_envir=$gfsite->site_envir;
		$model->site_facilities=$gfsite->site_facilities;
		$model->site_level=$gfsite->site_level;
		$model->site_belong=$gfsite->site_belong;
		$model->belong_id=$gfsite->belong_id;
		$model->belong_name=$gfsite->belong_name;
		$model->rent=$gfsite->rent;
		$model->site_belong=$gfsite->site_belong;
		$model->belong_id=$gfsite->belong_id;
		$model->belong_name=$gfsite->belong_name;
		$model->rent=$gfsite->rent;
		$model->project_ids=$project;

		$model->contact_phone=$gfsite->contact_phone;
		$model->site_address=$gfsite->site_address;
		$model->site_location=$gfsite->site_location;
		$model->site_longitude=$gfsite->site_longitude;
		$model->site_latitude=$gfsite->site_latitude;
		$model->area_country=$gfsite->area_country;
		$model->area_province=$gfsite->area_province;
		$model->area_city=$gfsite->area_city;
		$model->area_district=$gfsite->area_district;
		$model->area_township=$gfsite->area_township;
		$model->area_street=$gfsite->area_street;
        $st=$model->save();

        if($st==1){
            $this->save_sites($model->id,$post['sites_list']);
            $model->save();
        }

        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

	 public function actionSelect_site($site_id) {
		$arr = array();
		$parr = array();
		$r=0;
		$person=GfSite::model()->find('id='.$site_id);
		if(!empty($person)){
			$project=GfSiteProject::model()->findAll('site_id='.$person->id);
			if(!empty($project)) foreach($project as $p){
				$projectname=ProjectList::model()->find('id='.$p->project_id);
				//$parr[]=$projectname->project_name;
				$parr[$r]['project_id'] = $projectname->id;
                $parr[$r]['project_name'] = $projectname->project_name;
				$r=$r+1;
			}
			//$pn=implode(',', $parr);
		}
		$basepath = BasePath::model()->getPath(171);
		if(!empty($person)){
			$arr['site_code'] = $person->site_code;
			$arr['contact_phone'] = $person->contact_phone;
			$arr['site_name'] = $person->site_name;
			$arr['site_date_start'] = $person->site_date_start;
			$arr['site_date_end'] = $person->site_date_end;
			$arr['site_prove'] = explode(',', $person->site_prove);
			$arr['site_level_name'] = $person->site_level_name;
			$arr['site_address'] = $person->site_address;
			$arr['site_location'] = $person->site_location;
			$arr['site_description'] = get_html($basepath->F_WWWPATH.$person->site_description, $basepath);
			$arr['site_pic'] = $person->site_pic;
			$arr['project'] = $parr;
			ajax_exit($arr);
		}
	}
	public function Save_Sourcer($id){
		$model= QmddGfSite::model()->find('id='.$id);
		$sourcer=QmddServerSourcer::model()->find('t_typeid=1 AND s_name_id='.$id);
		if(empty($sourcer)){
			$sourcer = new QmddServerSourcer();
			$sourcer->isNewRecord = true;
			unset($sourcer->id);
		}
		$sourcer->t_typeid=1;
		$sourcer->s_name_id=$id;
		$sourcer->site_id=$model->site_id;
		$sourcer->site_parent=$model->site_parent;

		$sourcer->club_id=$model->user_club_id;
		$sourcer->s_code=$model->site_code;
		$sourcer->s_name=$model->site_name;
		$sourcer->server_name=$model->server_name;
		$sourcer->s_levelid=$model->site_level;
		$sourcer->s_levelname=$model->site_level_name;
		$sourcer->t_stypeid=14;
		$sourcer->if_del=$model->if_del;
		$sourcer->area_country=$model->area_country;
		$sourcer->area_province=$model->area_province;
		$sourcer->area_city=$model->area_city;
		$sourcer->area_district=$model->area_district;
		$sourcer->area_township=$model->area_township;
		$sourcer->area_street=$model->area_street;
		$sourcer->latitude=$model->site_latitude;
		$sourcer->Longitude=$model->site_longitude;
		$sourcer->logo_pic=$model->site_pic;
		$sourcer->s_picture=$model->site_prove;
		$sourcer->description=$model->site_description;
		$sourcer->project_ids=$model->project_id;
		$sourcer->contact_number=$model->contact_phone;

		$sourcer->state=$model->site_state;
		$sourcer->reasons_adminID=$model->reasons_adminID;
		$sourcer->reasons_time=$model->reasons_time;
		$sourcer->reasons_for_failure=$model->reasons_for_failure;
		$sourcer->area=$model->site_address;
		$sourcer->area_location=$model->site_location;
		$sourcer->site_type=$model->site_type;
		$content = array(
				'site_area'=>$model->site_area,
				'site_envir'=>$model->site_envir,
				'site_facilities'=>$model->site_facilities,
				'site_belong'=>$model->site_belong,
				'belong_id'=>$model->belong_id,
				'belong_name'=>$model->belong_name,
				'rent'=>$model->rent,
				'register_time'=>$model->register_time,
			);
		$sourcer->json_data=json_encode($content);
		$sv=$sourcer->save();
	}
	public function actionSave_Sourcer($id){
		$modelName = $this->model;
        $model = $modelName::model();
		$sv=0;
		$this->Save_Sourcer($id);
		$sv=1;
		$action=$this->createUrl('qmddGfSite/index_list');
		show_status($sv,'设置成功',$action,'设置失败');
	}

	public function actionDel_Sourcer($id){
		$modelName = $this->model;
        $model = $modelName::model();
        //$model->updateByPk($id,array('is_sourcer'=>648));
		$sourcer=QmddServerSourcer::model()->find('t_typeid=1 AND s_name_id='.$id);
		if (empty($sourcer)) {
            ajax_status(0, '该项还没有设置为可售资源');
        }
		$sv=QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=1 AND s_name_id='.$id);
		$action=$this->createUrl('qmddGfSite/index_list');
		/*
		if($sv>0) {
			ajax_status(1, '取消成功');
		} else {
            ajax_status(0, '取消失败');
        }
        */
		show_status($sv,'取消成功',$action,'取消失败');
	}
//撤销审核
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('site_state'=>721));
                $count++;

        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }

    // 保存场地信息
    public function save_sites($id, $sites_list) {
        if (isset($_POST['sites_list'])) foreach ($_POST['sites_list'] as $v) {
            if ($v['site_name'] == '' || $v['site_type'] =='' || $v['projct_id'] =='') {
                continue;
            }
            if ($v['id'] == 'null') {
                $sites = new QmddGfSiteSites();
                $sites->isNewRecord = true;
                unset($sites->id);
            } else{
                $sites = QmddGfSiteSites::model()->find('id='.$v['id']);
            }
            if (empty($sites->site_code)) {
                // 生成场地编号
                $resource_code = '';
                $live= GfSite::model()->find('id='.$id); // 获取数据库场馆id
                ////////////////////进行中////////////////////
                $resource_code=$live->code;
                $code_num ='01';
                $live_program=VideoLivePrograms::model()->find('live_id=' . $id . ' and program_code is not null order by program_code DESC');
                if (!empty($live_program)) {
                    $num=intval(substr($live_program->program_code, -2));
                    $code_num = substr('00' . strval($num + 1), -2);
                }
                ////////////////////进行中////////////////////
                $resource_code.=$code_num;
                $sites->site_code = $resource_code;
            }
        }
    }


	//逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->updateAll(array('if_del'=>509),'id in('.$id.')');
		if(!empty($count)) {
			foreach ($club as $d) {
				QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=1 and s_name_id='.$d);
			}
			ajax_status(1, '删除成功');
		} else {
            ajax_status(0, '删除失败');
        }
  }

    //详情页面内删除功能
    public function actionFnDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $st=$model->updateAll(array('if_del'=>509),'id='.$id);
        show_status($st,'删除成功',get_cookie('_currentUrl_'),'删除失败');
    }


}
