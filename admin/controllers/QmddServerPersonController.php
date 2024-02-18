<?php

class QmddServerPersonController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
	}

    public function actionIndex($keywords = '',$project = '', $type_code = '',$auth_state='',$type_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = get_where_club_project('club_id').' and check_state not in(2) and if_del=506 and is_display=510';
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
		$criteria->condition = get_where($criteria->condition,!empty($auth_state),'auth_state',$auth_state,'');
		$criteria->condition = get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($type_code),'qualification_level',$type_code,'');
        $criteria->condition = get_like($criteria->condition,'qcode,gfaccount,qualification_name',$keywords,'');
        $criteria->order = 'id desc ';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = BaseCode::model()->getStateType();
        $data['type_code'] = MemberCard::model()->findAll('left(card_code,1)="Q" and mamber_type<>261');
		$data['type_id'] = QmddServerUsertype::model()->findAll('t_server_type_id=2 and f_member_type<>261');
        parent::_list($model, $criteria,'index', $data);
	}

	// 审核通过 | 未通过
	public function actionIndex_check($keywords='',$project='',$state='',/*$type_code='',*/$type_id='',$state_time_start='',$state_time_end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		$state = empty($state) ? '2,373,1538' : $state;
		$state_time_start = empty($state_time_start) ? date('Y-m-d') : $state_time_start;
		$state_time_end = empty($state_time_end) ? date('Y-m-d') : $state_time_end;
		$criteria->condition = 'check_state in('.$state.') and if_del=506 and if(check_state=1538,is_display in(510,509),is_display=510)';
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        // $criteria->condition=get_where($criteria->condition,!empty($state),'check_state',$state,'');
		$criteria->condition = get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
        // $criteria->condition=get_where($criteria->condition,!empty($type_code),'qualification_level',$type_code,'');
        $criteria->condition = get_where($criteria->condition,!empty($state_time_start),'left(state_time,10)>=',$state_time_start,'"');
        $criteria->condition = get_where($criteria->condition,!empty($state_time_end),'left(state_time,10)<=',$state_time_end,'"');
        $criteria->condition = get_like($criteria->condition,'qcode,server_name',$keywords,'');
		$criteria->order = 'state_time desc';
		$data = array();
		$data['state_time_start'] = $state_time_start;
		$data['state_time_end'] = $state_time_end;
        $data['project_list'] = ProjectList::model()->getAll();
        // $data['type_code'] = MemberCard::model()->getServicLevel();
        // $data['base_code'] = BaseCode::model()->getStateType();
		$data['type_id'] = QmddServerUsertype::model()->getType(2);
		$data['state_count'] = $model->count('check_state=371 and if_del=506 and is_display=510');
        parent::_list($model, $criteria,'index_check', $data);
	}

	// 服务者登记 待审核
	public function actionIndex_stay_state($keywords='',$project='',$type_id=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition = 'check_state=371 and if_del=506 and is_display=510';
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
		$criteria->condition = get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
		$criteria->condition = get_like($criteria->condition,'qcode,server_name',$keywords,'');
		$data = array();
        $data['project_list'] = ProjectList::model()->getAll();
		$data['type_id'] = QmddServerUsertype::model()->getType(2);
        parent::_list($model, $criteria,'index_stay_state', $data);
	}

	// 服务者列表
	public function actionIndex_service($keywords='',$type_id='',$project='',$is_salable=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition = get_where_club_project('club_id').' and check_state=2 and if_del=506 and is_display=510';
		if($is_salable==648){
			$criteria->condition .= ' and is_salable=0';
		}
		elseif($is_salable==649){
			$criteria->condition .= ' and is_salable=1';
		}
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
		$criteria->condition = get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
		$criteria->condition = get_like($criteria->condition,'qcode,server_name',$keywords,'');
		$criteria->order = 'id desc';
		$data = array();
        $data['project_list'] = ProjectList::model()->getAll();
		$data['type_id'] = QmddServerUsertype::model()->getType(2);
        parent::_list($model, $criteria,'index_service', $data);
	}

	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			//保存资质图片
			$data['qualification_image'] = array();
			$data['sub_product_list'] = array();
			$this->render('update', $data);
        } else{
        	$this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_image'] = explode(',', $model->qualification_image);
            //$model->introduct=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
			$basepath = BasePath::model()->getPath(269);
		    $model->introduct_temp=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
			$data['sub_product_list'] = array();
			$clubperson=QualificationClub::model()->find('id='.$model->person_id);
			if(!empty($clubperson)){
            	$data['sub_product_list'] = QualificationVideos::model()->findAll('qualificate_id='.$clubperson->qualification_person_id.' and club_id='.$model->club_id);
			}
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
	}

	//审核
	public function actionUpdate_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_image'] = explode(',', $model->qualification_image);
			$basepath = BasePath::model()->getPath(269);
		    $model->introduct_temp=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
			$data['sub_product_list'] = array();
			$clubperson=QualificationClub::model()->find('id='.$model->person_id);
			if(!empty($clubperson)){
            	$data['sub_product_list'] = QualificationVideos::model()->findAll('qualificate_id='.$clubperson->qualification_person_id.' and club_id='.$model->club_id);
			}
            $this->render('update_check', $data);
        } else {
			$model->attributes = $_POST[$modelName];
            $st=0;
			$model->check_state = get_check_code($_REQUEST['submitType']);
			$model->process_id = get_session('admin_id');
			$model->process_account = get_session('gfaccount');
			$model->process_nick = get_session('admin_name');
			$st=$model->save();
			if($model->check_state==2){
				$this->actionSave_Sourcer($model->id,1);
			}
			// 2019/12/20/17/141_qsp2017465604430.html
			$yt = '已审核';
			$nt = '审核失败';
			// $redict = $this->createUrl('qmddServerPerson/index_check');
			if($model->check_state==721){
				// $yt = '操作成功';
				// $nt = '操作失败';
				// $redict = $this->createUrl('qmddServerPerson/index');
                sleep(1);
                header("Location: index.php?r=qmddServerPerson/index");
                exit;
			}else if($model->check_state == 2 || $model->check_state == 373 || $model->check_state == 1538) {
                sleep(1);
                header("Location: index.php?r=qmddServerPerson/index_stay_state");
                exit;
            }
            // {"status":1,"msg":"\u64cd\u4f5c\u6210\u529f","redirect":"\/malltest\/admin\/qmdd2018\/index.php?r=qmddServerPerson\/index"}
			// show_status($st,$yt,$redict,$nt);
        }
  	}

 	function saveData($model,$post) {
		$model->attributes =$post;
		if(!empty($model->id)){
			$sourcer=QmddServerSourcer::model()->find('t_typeid=2 AND s_name_id='.$model->id);
		}
		if(!empty($sourcer) && $sourcer->state==2){
			ajax_status(0, '请先撤销原来的服务资源');
		} else{
			$model->check_state = get_check_code($_REQUEST['submitType']);
			$sv=$model->save();
			if(isset($post['video_list'])){
				$this->save_video($model->id,$post['video_list']);
			}
			$ctn1 = ($model->check_state==371) ? '提交成功' : '保存成功';
			$ctn2 = ($model->check_state==371) ? '提交失败' : '保存失败';
			show_status($sv,$ctn1, get_cookie('_currentUrl_'),$ctn2);
		}
	}

	//获取服务者信息
    public function actionSelect_person($person_id) {
        //$model = ClubQualificationPerson::model();
		//$clubperson=QualificationClub::model()->find('id='.$person_id);
		$arr = array();
		$person=ClubQualificationPerson::model()->find('id='.$person_id);
		$basepath = BasePath::model()->getPath(212);
		if(!empty($person)){
			$arr['qcode'] = $person->qcode;
			$arr['gfid'] = $person->gfid;
			$arr['phone'] = $person->phone;
			$arr['email'] = $person->email;
			$arr['gfaccount'] = $person->gfaccount;
			$arr['qualification_name'] = $person->qualification_name;
			$arr['code_project'] = $person->code_project;
			$arr['code_type'] = $person->code_type;
			$arr['code_year'] = $person->code_year;
			$arr['code_num'] = $person->code_num;
			$arr['gf_code'] = $person->gf_code;
			$arr['identity_num'] = $person->identity_num;
			$arr['qualification_title'] = $person->qualification_title;
			$arr['qualification_code'] = $person->qualification_code;
			$arr['qualification_image'] = explode(',', $person->qualification_image);
			$arr['head_pic'] = $person->head_pic;
			$arr['qualification_time'] = $person->qualification_time;
			$arr['synopsis'] = $person->synopsis;
			$arr['introduct'] = get_html($basepath->F_WWWPATH.$person->introduct, $basepath);
			$arr['qualification_level'] = $person->qualification_level;
			$arr['level_name'] = $person->level_name;
			$arr['qualification_score'] = $person->qualification_score;
			$arr['start_date'] = $person->start_date;
			$arr['end_date'] = $person->end_date;
			$arr['achi_h_num'] = $person->achi_h_num;
			$arr['achi_h_ratio'] = $person->achi_h_ratio;
			$arr['achi_z_num'] = $person->achi_z_num;
			$arr['achi_z_ratio'] = $person->achi_z_ratio;
			$arr['achi_c_num'] = $person->achi_c_num;
			$arr['achi_c_ratio'] = $person->achi_c_ratio;
			ajax_exit($arr);
		}
	}

  	public function actionSave_Sourcer($id,$num=0){
		$model = QmddServerPerson::model()->find('id='.$id);
		$data = array();
		$data['video_list'] = array();
		$clubperson = QualificationClub::model()->find('id='.$model->person_id);
		if(!empty($clubperson)){
			$data['video_list'] = QualificationVideos::model()->findAll('qualificate_id='.$clubperson->qualification_person_id.' and club_id='.$model->club_id);
		}
		$sourcer = QmddServerSourcer::model()->find('t_typeid=2 AND s_name_id='.$id);
		if(empty($sourcer)){
			$sourcer = new QmddServerSourcer();
			$sourcer->isNewRecord = true;
			unset($sourcer->id);
		}
		$sourcer->t_typeid=2;
		$sourcer->s_name_id=$id;
		$sourcer->club_id=$model->club_id;
		$sourcer->s_code=$model->qcode;
		$sourcer->server_name=$model->server_name;
		$sourcer->s_name=$model->qualification_name;
		$sourcer->s_levelid=$model->qualification_level;
		$sourcer->s_levelname=$model->level_name;
		$sourcer->t_stypeid=$model->qualification_type_id;
		//$sourcer->if_del=$model->if_del;
		$sourcer->area_country=$model->area_country;
		$sourcer->area_province=$model->area_province;
		$sourcer->area_city=$model->area_city;
		$sourcer->area_district=$model->area_district;
		$sourcer->area_township=$model->area_township;
		$sourcer->area_street=$model->area_street;
		$sourcer->latitude=$model->latitude;
		$sourcer->Longitude=$model->Longitude;
		$sourcer->logo_pic=$model->head_pic;
		$sourcer->s_picture=$model->qualification_image;
		$sourcer->project_ids=$model->project_id;
		$sourcer->contact_number=$model->phone;
		$sourcer->s_gfid=$model->gfid;
		$sourcer->s_gfname=$model->qualification_name;
		$sourcer->state=$model->check_state;
		$sourcer->reasons_adminID=$model->process_id;
		$sourcer->reasons_time=$model->state_time;
		$sourcer->reasons_for_failure=$model->reasons_for_failure;
		$sourcer->area=$model->area_address;
		$sourcer->area_location=$model->navigatio_address;
		$sourcer->site_id=$model->servic_site_id;
		$sourcer->site_name=$model->servic_site_name;
		$content = array(
				'email'=>$model->email,
				'gfaccount'=>$model->gfaccount,
				'code_project'=>$model->code_project,
				'code_type'=>$model->code_type,
				'code_year'=>$model->code_year,
				'code_num'=>$model->code_num,
				'gf_code'=>$model->gf_code,
				'identity_num'=>$model->identity_num,
				'qualification_title'=>$model->qualification_title,
				'qualification_code'=>$model->qualification_code,
				'video_url'=>$data['video_list'],
				'uDate'=>$model->uDate,
				'qualification_time'=>$model->qualification_time,
				'introduct'=>$model->introduct,
				'qualification_score'=>$model->qualification_score,
				'achi_h_ratio'=>$model->achi_h_ratio,
				'area_address'=>$model->area_address,
			);
		$sourcer->json_data=json_encode($content);
		$sv=$sourcer->save();
		$model->is_salable = 1;
		$model->set_salable_time = date('Y-m-d H:i:s');
		$basepath = BasePath::model()->getPath(269);
		$model->introduct_temp = get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
		// $model->introduct_temp = $model->introduct;
		$model->save();
		// $action=$this->createUrl('qmddServerPerson/index');
		if($num==0){
			show_status($sv,'设置成功',Yii::app()->request->urlReferrer,'设置失败');
		}
	}

	public function actionDel_Sourcer($id,$num=0){
		$sourcer=QmddServerSourcer::model()->find('t_typeid=2 AND s_name_id='.$id);
		if(empty($sourcer) && $num=0){
            ajax_status(0, '该项还没有设置服务资源');
        }
		$st = QmddServerPerson::model()->updateByPk($id,array('is_salable'=>0,'set_salable_time'=>date('Y-m-d H:i:s')));
		$sv = QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=2 AND s_name_id='.$id);
		// $action=$this->createUrl('qmddServerPerson/index');
		$count = ($st + $sv > 0) ? 1 : 0;
		show_status($sv,'撤销成功',Yii::app()->request->urlReferrer,'撤销失败');
	}

	//////////////////////////////// 保存视频///////////////////
	public function save_video($id,$video){
		$model= QmddServerPerson::model()->find('id='.$id);
		$clubperson=QualificationClub::model()->find('id='.$model->person_id);
		$video_list=new QualificationVideos();
		$video_list->updateAll(array('video_pic'=>'-1'),'qualificate_id='.$clubperson->qualification_person_id.' AND club_id='.$model->club_id);//做临时删除标识
		//删除原有视频
		// QualificationVideos::model()->deleteAll('qualificate_id='.$clubperson->qualification_person_id);
		if(!empty($video)){
			$model2 = new QualificationVideos();
			$club_list_pic = array();
			$club_list_pic = explode(',', $video);
			$video_list = array_unique($club_list_pic);
			foreach ($video_list as $v) {
				$model2->isNewRecord = true;
				unset($model2->id);
				$model2->qualificate_id =$clubperson->qualification_person_id;
				$model2->material_id = $v;
				$model2->club_id = $model->club_id;
				$model2->save();
			}
		}
		QualificationVideos::model()->deleteAll('qualificate_id='.$clubperson->qualification_person_id.' and video_pic="-1"');
	}

	//删除
	public function actionFrozen($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->updateAll(array('if_del'=>507),'id in('.$id.')');
		if(!empty($count)) {
			foreach ($club as $d) {
				QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=2 and s_name_id='.$d);
			}
			ajax_status(1, '删除成功');
		} else {
            ajax_status(0, '删除失败');
        }
	}

	public function actionDelete($id,$ustate=0){
        $modelName = $this->model;
		$model = $modelName::model();
		$count = QmddServerPerson::model()->updateAll(array('is_display'=>509),'id in('.$id.')');
		$count1 = QmddServerSourcer::model()->updateAll(['state'=>374,'if_del'=>509],'t_typeid=2 and s_name_id in('.$id.')');
		$cl = ($count + $count1 > 0) ? 1 : 0;
		$url = Yii::app()->request->urlReferrer;
		if($ustate==1) $url = get_cookie('_currentUrl_');
		show_status($cl,'删除成功',$url,'删除失败');
	}

	// 设置|取消 可售
	public function actionSetSalable($id,$is_salable){
		if($is_salable==0){
			$this->actionDel_Sourcer($id);
		}
		else{
			$this->actionSave_Sourcer($id);
		}
		// $count = QmddServerPerson::model()->updateByPk($id,array('is_salable'=>$is_salable,'set_salable_time'=>date('Y-m-d H:i:s')));
		// show_status($count,'设置成功',Yii::app()->request->urlReferrer,'设置失败');
	}

    public function actionUpdate_introduct($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $basepath = BasePath::model()->getPath(269);
        $model->introduct_temp=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update_introduct',$data);
        }
        else{
            // $model->attributes = $_POST[$modelName];
            // $sv = $model->save();
            // show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
            // parent::_update($model,'create',$data,get_cookie('_currentUrl_'));
            $this->saveVenueSetting($model,$_POST[$modelName]);
        }
    }
    function saveVenueSetting($model,$post){
        $model = QmddServerPerson::model()->find('id='.$id);
        if(!empty($model->id)){
            $sourcer=QmddServerSourcer::model()->find('t_typeid=2 AND s_name_id='.$model->id);
        }
        $basepath = BasePath::model()->getPath(269);
        $model->introduct_temp=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
        // $model->introduct_temp = $model->introduct;
        $model->save();
        $st = $model->save();
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
}
