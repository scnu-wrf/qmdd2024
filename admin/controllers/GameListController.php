<?php

class GameListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	//赛事发布/发布赛事
    public function actionIndex($keywords = '',$is_excel='0') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state<>2 and game_club_id='.get_SESSION('club_id');
        $criteria->condition = get_like($criteria->condition,'game_title,game_code',$keywords,'');//get_where
        $criteria->order = 'state,uDate DESC';
        $data = array();
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index', $data);
        }
        else{
            $arclist = $model->findAll($criteria);
            $data = array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    if ($fv == 'club_list') {
                        $s = $v->club_list->game_title;
                    } else {
                        $s = $v->$fv;
                    }
                    array_push($item, $s);
                    $v->game_code='·'.$v->game_code;
                }
                array_push($data, $item);
            }
            parent::_excel($data,'赛事列表.xls');
        }
    }

    //赛事发布/发布审核/待审核
    public function actionSubmitlist($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('game_club_id','').'  and state=371';
        $criteria->condition = get_like($criteria->condition,'game_title,game_code',$keywords,'');//get_where
        $criteria->order = 'id';
        $data = array();
        $data['stay_state'] = $model->count(get_where_club_project('game_club_id','').'  and state=371');
        parent::_list($model, $criteria, 'submitlist', $data);
    }

    //赛事发布/发布审核/审核记录
    public function actionShlist($keywords='',$star_time='',$end_time='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $state = empty($state) ? '2,373' : $state;
        $search_time = ($state=='2,373') ? 'state_time' : 'publish_time';
        if($state!='371'){
            $star_time = empty($star_time) ? date("Y-m-d") : $star_time;
            $end_time = empty($end_time) ? date("Y-m-d") : $end_time;
        }
        $criteria->condition = get_where_club_project('game_club_id','').'  and state in('.$state.')';
        $criteria->condition .=$state=='371' ? '' : ' and dispay_end_time>=now()';
        $criteria->condition = get_where($criteria->condition,$star_time,'left('.$search_time.',10)>=',$star_time,'"');
        $criteria->condition = get_where($criteria->condition,$end_time,'left('.$search_time.',10)<=',$end_time,'"');
        $criteria->condition = get_like($criteria->condition,'game_title,game_code',$keywords,'');//get_where
        $criteria->order = $state=='371' ? 'id' : 'state_time DESC';
        $data = array();

        $data['star_time'] = $star_time;
        $data['end_time'] = $end_time;
        $data['state'] = $state;
        $data['state_l'] = array("2"=>"审核通过","373"=>"审核未通过","1538"=>"退回修改");
        $data['stay_state'] = $model->count(get_where_club_project('game_club_id','').'  and state=371');
        parent::_list($model, $criteria, 'shlist', $data);
    }

    public function actionIndex_list($keywords='',$game_level='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and down_type=0 and datediff(now(),game_time_end)<=70 and game_club_id='.get_SESSION('club_id');
        $criteria->condition = get_where($criteria->condition,!empty($game_level),'game_level',$game_level,'');
        $criteria->condition = get_like($criteria->condition,'game_title,game_code',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['game_level'] = BaseCode::model()->getCode(163,' order by F_CODE');
        parent::_list($model, $criteria, 'index_list', $data);
    }

    public function actionDetail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'detail');
        } else {
            $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }

    //赛事直播关联设置列表
    public function actionIndex_live($keywords='',$star_time='',$end_time='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('game_club_id','').'  and state=2 and dispay_end_time>="'.date("Y-m-d H:i:s").'"';
        $criteria->condition = get_where($criteria->condition,!empty($star_time),'state_time>=',$star_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_time),'state_time<=',$end_time,'"');
        $criteria->condition = get_like($criteria->condition,'game_title,game_code',$keywords,'');//get_where
        $criteria->order = 'state_time DESC';
        $data = array();
        $data['stay_state'] = $model->count(get_where_club_project('game_club_id','').'  and state=371');
        parent::_list($model, $criteria, 'index_live', $data);
    }

    //审核不成功列表
    public function actionFaillist($keywords = '') {
         $this->ShowView($keywords,'state not in(371,2,721)','faillist');
    }

    //审核列表，赛事未结束的时间修改
    public function actionShowsetlist($keywords = '') {
        $this->ShowView($keywords,'(state=2 and game_state<>149)','showsetlist');
    }

    //待审核列表
    public function ShowView($keywords = '',$state,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1=''.$state.' and ';
        $w1.=get_where_club_project('game_club_id','');
        $criteria->condition=get_like($w1,'game_title,game_code',$keywords,'');//get_where
        $criteria->order = 'id';
        $data = array();
        $data['stay_state'] = $model->count(get_where_club_project('game_club_id','').'  and state=371');
        parent::_list($model, $criteria, $viewfile, $data);
    }

    public function actionList($keywords = '',$province='',$city='',$area='',$start_date='',$end_date='',$game_state='',$game_level='',$game_club_id='',$game_area='',$state='',$game_type='',$game_code='',$game_id='',$is_excel='0') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1=get_where_club_project('game_club_id','').'';
        $w1=get_where($w1,$game_id,'id',$game_id,'');
        $w1=get_where($w1,$game_state,'game_state',$game_state,'');
        $w1=get_where($w1,$game_club_id,'game_club_id',$game_club_id,'');
        $w1=get_where($w1,$game_type,'game_type',$game_type,'');
        $w1=get_where($w1,$game_level,'game_level',$game_level,'');
        $w1=get_where($w1,$game_area,'game_area',$game_area,'');
        $w1=get_where($w1,$state,'state',$state,'');
        $w1=get_where($w1,($start_date!=""),'news_date_start>=',$start_date,'"');
        $w1=get_where($w1,($start_date!=""),'news_date_end<=',$start_date,'"');
        $criteria->condition=get_like($w1,'game_title,game_code',$keywords,'');//get_where
        if ($province !== '') {
            $criteria->condition.=' AND t.navigatio_address like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.navigatio_address like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.navigatio_address like "%' . $area . '%"';
        }
        $criteria->order = 'id DESC';
        $code = ($game_type==163) ? 163 : 810;
        $data = array();
        $data['game_club_id'] = ClubList::model()->findAll();
        $data['game_state'] = BaseCode::model()->getCode(144);
        $data['game_type'] = BaseCode::model()->getReturn('164,165,166,167');
        $data['game_level'] = BaseCode::model()->getCode($code);
        $data['game_area'] = BaseCode::model()->getCode(158,' order by F_CODE');
        $data['state'] = BaseCode::model()->getReturn('721,371,2,373,374');
        //$data['project'] = ProjectList::model()->getProject();
        // parent::_list($model, $criteria, 'index', $data);
        if(!isset($is_excel) || $is_excel != '1'){
            $criteria->order = 'id DESC';
            parent::_list($model, $criteria, 'index', $data);
        }
        else{
            $arclist = $model->findAll($criteria);
            $data = array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    $s = '';
                    if ($fv == 'club_list') {
                        $s = $v->club_list->game_title;
                        $v->game_code='·'.$v->game_code;
                    } else {
                        $s = $v->$fv;
                        $v->game_code='·'.$v->game_code;
                    }
                    array_push($item, $s);
                }
                array_push($data, $item);
            }
            parent::_excel($data,'赛事列表.xls');
        }
    }

    /**
     * 活动810
     */
    public function actionIndexhd($keywords = '',$province='',$city='',$area='',$start_date='',$end_date='',$game_state='',$game_level='',$game_club_id='',$game_area='',$state='',$game_type='',$game_code='',$game_id='',$is_excel='0') {
        $this->actionIndex($keywords,$province,$city,$area,$start_date,$end_date,$game_state,$game_level,$game_club_id,$game_area,$state,$game_type,$game_code,$game_id,$is_excel);
    }

    public function actionCreate($type) {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $old_title='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['game_big_pic'] = array();
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'update');
        } else {
            $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }

    public function actionUpdate_edit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'update_edit');
        } else {
			$post=$_POST[$modelName];
			$model->check_save(1);
			$model->attributes=$post;
			$st=$model->save();
			if(isset($_POST['intro_table'])){
				$this->save_intro($model->id);
			}
			if(isset($_POST['org_table'])){
				$this->save_organizational($model->id);
			}
			if(isset($_POST['game_data_table'])){
				$this->save_game_data($model->id);
			}
			if(!empty($game_title)) {
				$this->update_title($model->id,$model->game_title,$old_title);
			}
			$edit = new GameListEdit(); 
			$edit->isNewRecord = true;
			unset($edit->id);
            $edit->game_id = $id;
            $edit->admin_id = get_session('admin_id');
            $edit->admin_club_id = get_session('club_id');
            $edit->save();
			show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionUpdate_audit_fail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'update_audit_fail');
        } else {
            $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }
    public function actionUpdate_audit_return($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'update_audit_return');
        } else {
            $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }
    public function actionUpdate_audit_submit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'update_audit_submit');
        } else {
            $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }
	
	//下架赛事
    public function actionDown_index($game_level = '',$down_type = '', $keywords = '', $start_date='',$end_date='',$search_date=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(empty($search_date)){
			$start_date=date("Y-m-d");
			$end_date=date("Y-m-d");
		}
        $criteria = new CDbCriteria;
        $criteria->condition = 't.t.down_type in (1,2,3)';
        $criteria->condition .=' and '.get_where_club_project('t.game_club_id');
		$criteria->condition = get_where($criteria->condition,!empty($game_level),'t.game_level',$game_level,'');
		$criteria->condition = get_where($criteria->condition,!empty($down_type),'t.down_type',$down_type,'');
		$criteria->condition=get_like($criteria->condition,'t.game_title,t.game_code,d.project_name',$keywords,'');
		if(!empty($start_date)){
			$criteria->condition.=' and t.down_time>="'.$start_date.' 00:00:00"';
		}
		if(!empty($end_date)){
			$criteria->condition.=' and t.down_time<="'.$end_date.' 23:59:59"';
		}
		$criteria->join = " left join game_list_data d on d.game_id=t.id";
		//$criteria->group = "t.id";
        $criteria->order = 't.id DESC';
        $data = array();
        $data['game_level'] = BaseCode::model()->getCode(163,' order by F_CODE');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'down_index', $data, 10);
    }
	//下架赛事-详情
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
	//下架赛事-下架选择
    public function actionDown_select($keywords = '') {
        $data = array();
		$modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and down_type not in (1,2,3)';
        $criteria->condition .=' and '.get_where_club_project('game_club_id');
		$criteria->condition=get_like($criteria->condition,'game_title,game_code',$keywords,'');
        parent::_list($model, $criteria, 'down_select', $data,10);
    } 
	//下架赛事
    public function actionDowntype($id,$down_type=1,$down_reason='') {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        $now=date('Y-m-d H:i:s');
        foreach ($club as $d) {
			$model->updateByPk($d,array('down_type'=>$down_type,'down_time'=>$now,'down_admin_id'=>get_session('admin_id'),'down_admin_nick'=>(get_session('lang_type')==1?(get_session('club_code') .'#'. get_session('gfaccount')):(get_session('gfaccount'))),'down_reason'=>$down_reason));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	
	public function actionAdd_game_introduction() {
        $modelName = $this->model;
		$model = $this->loadModel('', $modelName);
        $data = array();
        $data['model'] = $model;
        $this->render('add_game_introduction', $data);
    }

    public function actionUpdateset($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $old_pic=$model->game_small_pic;
        $old_title=$model->game_title;
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'updateset');
        } else {
            $model->attributes = $_POST[$modelName];
            $st = $model->save();
            $game_data = GameListData::model()->findAll('game_id='.$model->id.' ');
            GfServiceData::model()->updateAll(array('servic_time_star'=>$model->game_time,'servic_time_end'=>$model->game_time_end),'service_id='.$model->id.' and order_type=351');
            MallPriceSet::model()->updateAll(
                array(
                    'star_time' => $model->Signup_date,
                    'end_time' => $model->Signup_date_end,
                    'down_time' => $model->Signup_date_end,
                    'start_sale_time' => $model->Signup_date_end,
                    'update_date' => date('Y-m-d H:i:s')
                ),
                'service_id='.$model->id.' and pricing_type=351'
            );
            if(!empty($game_data))foreach($game_data as $gd){
                $gd->signup_date = $model->Signup_date;
                $gd->signup_date_end = $model->Signup_date_end;
                $gd->save();
                MallPriceSetDetails::model()->updateByPk('service_data_id='.$gd->id,array('star_time'=>$gd->signup_date,'end_time'=>$gd->signup_date_end,'down_time'=>$gd->signup_date_end));
                MallPricingDetails::model()->updateByPk('service_data_id='.$gd->id,array('star_time'=>$gd->signup_date,'start_sale_time'=>$gd->signup_date,'end_time'=>$gd->signup_date_end,'down_time'=>$gd->signup_date_end));
            }
            //$this->saveData($model,$_POST[$modelName]);
            show_status($st,'时间更改设置成功', $this->createUrl('gameList/showsetlist'),'操作失败');
        }
    }

    //显示明细数据
    public function show_data( $model,$viewfile) {
        $data = array();
        // $basepath = BasePath::model()->getPath(132);
        // $model->entry_information_url_temp=get_html($basepath->F_WWWPATH.$model->entry_information_url, $basepath);
        $data['model'] = $model;
        $data['game_big_pic'] = array();
        $data['game_web_top'] = array();
        if (!empty($model->game_big_pic)) {
            $data['game_big_pic'] = explode(',', $model->game_big_pic);
        }
        // 获取竞赛规程
        $data['intro'] = GameIntroduction::model()->findAll('game_id=' . $model->id);
        // 获取组织单位
        $data['org'] = GameListOrganizational::model()->findAll('game_id=' . $model->id);
        // 获取比赛项目
        $data['game_data'] = GameListData::model()->findAll('game_id=' . $model->id);
        $this->render($viewfile, $data);
    }

    public function actionShupdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'shupdate');
        } else {
            $model->state = get_check_code($_POST['submitType']);
            $ta=array('state'=>$model->state,'reasons_for_failure'=>$_POST[$modelName]['reasons_for_failure']);
            $st=$model::model()->updateAll($ta,'id='.$id);
            if ($_POST['submitType'] == 'tongguo') { //t通过需要做的其他
                $game_data = new GameListData();
                $data=array(
                    'state'=>$model->state,
                );
                $s1='game_id='.$model->id;
                $game_data->updateAll($data,$s1);
            }
            show_status($st,'操作成功', $this->createUrl('gameList/shlist'),'操作失败');
          //  $this->saveData($model,$_POST[$modelName],$old_pic,$old_title);
        }
    }

    //提交的赛事，现在撤销提交，变为可编辑处理
    public function actionSubmitupdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'submitupdate');
        } else {
            $model->state = ($_POST['submitType']=='chexiao') ? 721 : get_check_code($_POST['submitType']);
            $i = ($model->state==721) ? '撤销成功' : '审核成功';
            $d = ($model->state==721) ? '撤销失败' : '审核失败';
            $for = $model->reasons_for_failure;
            if($model->state==2 || $model->state==373){
                $for = $_POST[$modelName]['reasons_for_failure'];
                $data = array(
                    'state' => $model->state,
                    'signup_date' => $model->Signup_date,
                    'signup_date_end' => $model->Signup_date_end,
                    'uDate' => date('Y-m-d H:i:s'),
                );
                GameListData::model()->updateAll($data,'game_id='.$model->id);
                $model->save_set($model);
            }
            $st=$model->updateAll(array('state'=>$model->state,'reasons_for_failure'=>$for,'state_time'=>date('Y-m-d H:i:s')),'id='.$id);
            show_status($st,$i,get_cookie('_currentUrl_'),$d);
        }
    }

    //审核不通过的赛事，或取消的赛事
    public function actionFailshow($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'failshow');
        } else {
          $st=$model::model()->updateAll(array('state'=>'721'),'id='.$id);
          show_status(1,'操作成功', $this->createUrl('gameList/faillist'),'取消失败');
        }
    }

    // 赛事签到管理列表
    public function actionEvents_signin_index($keywords='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'game_state<>149 and state=2 and game_time_end<now() and ';
        $criteria->condition .=get_where_club_project("game_club_id");
       // $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'events_signin_index', $data);
    }

    // 赛事签到管理列表
    public function actionRefereelist($keywords='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'game_state<>149 and state=2 and game_time_end<now() and ';
        $criteria->condition .=get_where_club_project("game_club_id");
        $data = array();
        parent::_list($model, $criteria, 'events_signin_index', $data);
    }


	function saveData($model,$post,$old_pic,$old_title) {
        $model->check_save(1);
        $model->attributes=$post;
        $model->state = get_check_code($_POST['submitType']);
        $st=$model->save();
        $this->save_club_list($model);
		if(isset($_POST['intro_table'])){
            $this->save_intro($model->id);
        }
		if(isset($_POST['org_table'])){
            $this->save_organizational($model->id);
        }
		if(isset($_POST['game_data_table'])){
            $this->save_game_data($model->id);
        }
        if(isset($post['game_small_pic'])){
            $this->save_gfmaterial($old_pic,$model->game_small_pic,$model->game_title);
        }
        if(!empty($game_title)) {
            $this->update_title($model->id,$model->game_title,$old_title);
        }
        if($_POST['submitType'] == 'baocun'){
            // show_status($st,'保存成功', $this->createUrl('gameList/update',array('id'=>$model->id,'type'=>$model->game_type)),'保存失败');
            show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
            // show_status($st,'保存成功', $this->createUrl('gameListData/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type)),'保存失败');
        }
        else{
            $game_data = new GameListData();
            if($model->state==2){
                $data=array(
                    'state'=>$model->state,
                );
                $s1='game_id='.$model->id;
                $game_data->updateAll($data,$s1);
            }
            $type=$model->game_type==163 ? 163 : 810;
            show_status($st,'操作成功', $this->createUrl('gameList/index',array('game_type'=>$type)),'操作失败');
        }
    }

    public function save_club_list($model){
        //删除原有项目
        // GameListRecommend::model()->deleteAll('game_id='.$model->id);
        $game_rec = new GameListRecommend();
        if(!empty($model->club_list)){
            $game_rec->deleteAll('game_id='.$model->id);
            $model2 = new GameListRecommend();
            $club_list_pic = array();
            $club_list_pic = explode(',', $model->club_list);
            $club_list_pic = array_unique($club_list_pic);
            foreach ($club_list_pic as $v) {
                $model2->isNewRecord = true;
                unset($model2->id);
                $model2->game_id = $model->id;
                $model2->recommend_clubid = $v;
                $model2->save();
            }
        }
    }
	
	//保存组织单位
    public function save_organizational($id){
        GameListOrganizational::model()->updateAll(array('organizational_type'=>'-1'),'game_id='.$id);//做临时删除标识
        if (isset($_POST['org_table'])) foreach ($_POST['org_table'] as $v) {
			if ($v['id']=='null') {
                $intro = new GameListOrganizational(); 
                $intro->isNewRecord = true;
                unset($intro->id);
            } else{
                $intro=GameListOrganizational::model()->find('id='.$v['id']);
            } 
            $intro->game_id = $id;
            $intro->organizational_type = $v['organizational_type'];
			$intro->organizational = $v['organizational'];
            $intro->save();
        }
        GameListOrganizational::model()->deleteAll('organizational_type="-1"');
    }
	
	//保存竞赛规程
    public function save_intro($id){
        GameIntroduction::model()->updateAll(array('type'=>'-1'),'game_id='.$id);//做临时删除标识
        if (isset($_POST['intro_table'])) foreach ($_POST['intro_table'] as $v) {
			if ($v['id']=='null') {
                $intro = new GameIntroduction(); 
                $intro->isNewRecord = true;
                unset($intro->id);
            } else{
                $intro=GameIntroduction::model()->find('id='.$v['id']);
            } 
            $intro->game_id = $id;
            $intro->intro_title = $v['intro_title'];
			$intro->intro_content_temp = $v['intro_content_temp'];
            $intro->type = $v['type'];
            $intro->save();
        }
        GameIntroduction::model()->deleteAll('type="-1"');
    }
	
	//保存竞赛规程
    public function save_game_data($id){
        GameListData::model()->updateAll(array('if_del'=>'-1'),'game_id='.$id);//做临时删除标识
        if (isset($_POST['game_data_table'])) foreach ($_POST['game_data_table'] as $v) {
			if ($v['id']=='null') {
                $intro = new GameListData(); 
                $intro->isNewRecord = true;
                unset($intro->id);
            } else{
                $intro=GameListData::model()->find('id='.$v['id']);
            } 
			if (empty($intro->game_data_code)) {
                $service_code = '';
                $game= GameList::model()->find('id='.$id);
                $service_code=$game->game_code;
                $code_num ='01';
                $game_data=GameListData::model()->find('game_id=' . $id . ' and game_data_code is not null order by id DESC');
                if (!empty($game_data)) {
                    $num=intval(substr($game_data->game_data_code, -2));
                    $code_num = substr('00' . strval($num + 1), -2);
                }
                $service_code.='-'.$code_num;
                $intro->game_data_code = $service_code;
            }
            $intro->game_id = $id;
            $intro->game_data_name = $v['game_data_name'];
			$intro->project_id = $v['project_id'];
            $intro->game_player_team = $v['game_player_team'];
            $intro->game_dg_level = $v['game_dg_level'];
            $intro->game_sex = $v['game_sex'];
            $intro->game_group_star = $v['game_group_star'];
            $intro->game_group_end = $v['game_group_end'];
            $intro->number_of_member = $v['number_of_member'];
            $intro->game_money = $v['game_money'];
            $intro->isSignOnline = $v['isSignOnline'];
            $intro->game_mode = $v['game_mode'];
            $intro->game_check_way = $v['game_check_way'];
            $intro->if_del = 510;
            $intro->save();
        }
        GameListData::model()->deleteAll('if_del="-1"');
    }

    //保存到素材管理
    public function save_gfmaterial($oldpic,$pic,$title){
        $logopath=BasePath::model()->getPath(118);
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

    //修改赛事成员表和赛事团队表的赛事标题
    public function update_title($id,$title,$old_title){
        if($old_title!=$title){
            GameSignList::model()->updateAll(array('sign_game_name'=>$title),'sign_game_id='.$id);
            GameTeamTable::model()->updateAll(array('game_name'=>$title),'game_id='.$id);
            GameRefereesList::model()->updateAll(array('game_name'=>$title),'game_id='.$id);
        }
    }

    //逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $lode = explode(',', $id);
        $count = 0;
		foreach ($lode as $d) {
			$model->updateByPk($d,array('if_del'=>509,'if_del_time'=>date('Y-m-d H:i:s'),'if_del_admin'=>get_session('admin_id')));
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
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
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 

    // submitlist页面待审核状态撤销提交操作
    public function actionSave_revoke($id){
        $st = GameList::model()->updateByPk($id,array('state'=>721));
        show_status($st,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 须知
    public function actionNotice($id,$index){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $team_notice = GameIntroduction::model()->find('game_id='.$id.' and type=1');
        $member_notice = GameIntroduction::model()->find('game_id='.$id.' and type=2');
        $basepath = BasePath::model()->getPath(164);
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $model->entry_member_notice = (!empty($member_notice)) ? get_html($basepath->F_WWWPATH.$member_notice->intro_content, $basepath) : '';
            $model->entry_team_notice = (!empty($team_notice)) ? get_html($basepath->F_WWWPATH.$team_notice->intro_content, $basepath) : '';
            $this->render($index, $data);
        } else {
            // $model->check_save(1);
            // $model->attributes = $_POST[$modelName];
            // $sv = $model->save();
            // show_status($sv,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
            $st = 0;
            if(empty($member_notice)){
                $member_notice = new GameIntroduction;
                $member_notice->isNewRecord = true;
                $member_notice->game_id = $id;
                $member_notice->intro_title = '运动员报名须知';
                $member_notice->type = 2;
            }
            // $member_notice->intro_content = $model->member_notice;
            $member_notice->intro_content_temp = $_POST[$modelName]['entry_member_notice'];
            $sv = $member_notice->save();

            if($model->game_apply_way_referee==642){
                if(empty($team_notice)){
                    $team_notice = new GameIntroduction;
                    $team_notice->isNewRecord = true;
                    $team_notice->game_id = $id;
                    $team_notice->intro_title = '裁判员报名须知';
                    $team_notice->type = 1;
                }
                // $team_notice->intro_content = $model->team_notice;
                $team_notice->intro_content_temp = $_POST[$modelName]['entry_team_notice'];
                $st = $team_notice->save();
            }
            $st = ($model->game_apply_way_referee!=642) ? 1 : $st;
            $sn = ($sv==1 && $st==1) ? 1 : 0;
            show_status($sn,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
        }
    }

    // // 成员须知 运动员
    // public function actionMember_notice($id){
    //     $this->actionNotice($id,'member_notice');
    // }

    // // 成员须知 裁判
    // public function actionTeam_notice($id){
    //     $this->actionNotice($id,'team_notice');
    // }

    // 报名须知
    public function actionSign_notice($id){
        $this->actionNotice($id,'sign_notice');
    }

    // 查看竞赛规则
    public function actionShowtrodu($id,$num){
        $where = ($num==0) ? 'id='.$id : 'game_id='.$id.' and type='.$num;
        $model = GameIntroduction::model()->find($where);
        $basepath = BasePath::model()->getPath(164);
        $data = '';
        if(!empty($model->intro_content)){
            $content = file_get_contents($basepath->F_WWWPATH.$model->intro_content."?_".time());
            if ($basepath != null) {
                $content = strtr($content, array('<htt></htt>' => $basepath->F_WWWPATH));
                $content = strtr($content, array('<htt></htt>' => $basepath->F_WWWPATH));
            }
            if (!empty($strtr)) {
                $content = strtr($content, $strtr);
            }
            $data = strip_html_tags(array('style','script','meta','title'),$content);
        }
        echo CJSON::encode($data);
    }

    // 查看赛事历史记录
    public function actionUpdate_history($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->show_data($model,'update_history');
        }
    }

         //关联直播设置
    public function actionLiveinstall($id) {
        set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(!empty($model->video_live_id)){
               $live=$model->video_live_id;
            } else{
                $live='-1';
            }

            //$data['video_live'] = array();
            $data['video_live'] = VideoLive::model()->findAll('id in (' . $live . ')');

            $this->render('liveinstall', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $video_live_id = $model->video_live_id;
            $st=0;
            $st=GameList::model()->updateAll(array('video_live_id'=>$video_live_id),'id='.$model->id);

            show_status($st,'设置成功','','设置失败');
        }
    }

    public function actionSettion_time($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        if(!Yii::app()->request->isPostRequest){
            $this->show_data($model,'settion_time');
        }
        else{
            $this->actionUpdateset($id);
        }
    }

    // 报名费用明细
    public function actionSign_money_details($keywords='',$game_id='',$data_id='',$star_time='',$end_time='',$Signup_date='',$Signup_date_end='',$keywords2=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'GfServiceData';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = (empty($game_id)) ? 0 : $game_id;
        $criteria->condition = 'order_type=351 and pay_confirm=1 and service_id='.$game_id;
        // $criteria->condition .= ' and exists(select * from game_list gl where '.get_where_club_project('game_club_id').' and gl.id=t.service_id and gl.Signup_date_end>now())';
        // $criteria->condition = get_where($criteria->condition,!empty($game_id),'service_id',$game_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($data_id),'service_data_id',$data_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($star_time),'left(servic_time_star,10)>=',$star_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_time),'left(servic_time_end,10)<=',$end_time,'"');
        $criteria->condition = get_like($criteria->condition,'service_code,service_name,supplier_name',$keywords,'');
        $data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2  and datediff(now(),Signup_date_end)<7');  //  and Signup_date_end>"'.date('Y-m-d H:i:s').'"
        $data['keywords2'] = $keywords2;
        $data['Signup_date'] = $Signup_date;
        $data['Signup_date_end'] = $Signup_date_end;
        parent::_list($model, $criteria, 'sign_money_details', $data);
    }

    // 报名费用详情
    public function actionMoney_details($id){
        $modelName = 'GfServiceData';
        $model = $this->loadModel($id,$modelName);
        if(!Yii::app()->request->isPostRequest){
            $this->show_data($model,'money_details');
        }
    }

    // submitupdate页面获取报名须知   已不用 废弃
    // public function actionShownotice($id,$noti){
    //     $modelName = $this->model;
    //     $model = $this->loadModel($id,$modelName);
    //     $te = ($noti==1) ? $model->member_notice : $model->team_notice;
    //     echo CJSON::encode($te);
    // }

    // 赛事收费统计
    public function actionGame_money_statistics($keywords='',$game_title='',$Signup_date='',$Signup_date_end=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $Signup_date = empty($Signup_date) ? date('Y-m-d') : $Signup_date;
        $Signup_date_end = empty($Signup_date_end) ? date('Y-m-d') : $Signup_date_end;
        $criteria->condition = get_where_club_project('game_club_id').'  and game_state<>149 and state=2';
        $criteria->condition = get_where($criteria->condition,!empty($Signup_date),'left(Signup_date,10)>=',$Signup_date,'"');
        $criteria->condition = get_where($criteria->condition,!empty($Signup_date_end),'left(Signup_date_end,10)<=',$Signup_date_end,'"');
        $criteria->condition = get_where($criteria->condition,!empty($game_title),'game_title=',$game_title,'"');
        $criteria->condition = get_like($criteria->condition,'game_code,game_club_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['money_type'] = ClubMembershipFee::model()->find('code="TS45"');
        $data['keywords'] = $keywords;
        $data['Signup_date'] = $Signup_date;
        $data['Signup_date_end'] = $Signup_date_end;
        parent::_list($model, $criteria, 'game_money_statistics', $data);
    }

    // 赛事收费方案
    public function actionGame_money_progr($keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = 'MallPriceSet';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('supplier_id').' and pricing_type=351 and if_del=648';
        $criteria->condition = get_like($criteria->condition,'event_code,event_title,supplier_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'game_money_progr', $data);
    }

    // 赛事收费方案详情
    public function actionGame_money_progr_update($id){
        $modelName = 'MallPriceSet';
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $data['mall_fee'] = ClubMembershipFee::model()->find('code="TS45"');
            $this->render('game_money_progr_update',$data);
        }
    }

    // 方案列表刷新
    public function actionRefresh($id){
		$modelName = 'MallPriceSet';
		$model = $this->loadModel($id,$modelName);
		$model->data_sourcer_bz = $model->data_sourcer_bz+1;
		$sv=$model->save();
		show_status($sv,'刷新成功',Yii::app()->request->urlReferrer,'刷新失败');
    }

    // 单位赛事查询  审核通过-比赛结束时间前的赛事
    public function actionGame_club_search($keywords='',$game_time='',$game_time_end='',$game_level=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $game_time = empty($game_time) ? date('Y-m-d') : $game_time;
        // $game_time_end = empty($game_time_end) ? date('Y-m-d') : $game_time_end;
        $criteria->condition = get_where_club_project('game_club_id').' and game_state<>149 and state=2 and down_type=0 ';
        $criteria->condition = get_where($criteria->condition,!empty($game_level),'game_level',$game_level,'');
        $criteria->condition = get_where($criteria->condition,!empty($game_time),'left(game_time,10)>=',$game_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($game_time_end),'left(game_time_end,10)<=',$game_time_end,'"');
        $criteria->condition = get_like($criteria->condition,'game_club_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['game_level'] = BaseCode::model()->getCode(163);
        parent::_list($model, $criteria, 'game_club_search', $data);
    }

    // 历史赛事查询  比赛结束时间大于7天的赛事
    public function actionGame_history_search($keywords='',$game_time='',$game_time_end='',$game_level=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('game_club_id').' and state=2 and down_type=0  and datediff(now(),game_time_end)>7';//and game_state=149
        $criteria->condition = get_where($criteria->condition,!empty($game_level),'game_level',$game_level,'');
        $criteria->condition = get_where($criteria->condition,!empty($game_time),'left(game_time,10)>=',$game_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($game_time_end),'left(game_time_end,10)<=',$game_time_end,'"');
        $criteria->condition = get_like($criteria->condition,'game_code,game_title',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['game_level'] = BaseCode::model()->getCode(163);
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'game_history_search', $data ,10);
    }

    // 单位历史赛事查询  比赛结束时间大于7天的赛事
    public function actionGame_club_history_search($keywords='',$game_time='',$game_time_end='',$game_level=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('game_club_id').' and state=2 and down_type=0  and datediff(now(),game_time_end)>7';//and game_state=149
        $criteria->condition = get_where($criteria->condition,!empty($game_level),'game_level',$game_level,'');
        $criteria->condition = get_where($criteria->condition,!empty($game_time),'left(game_time,10)>=',$game_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($game_time_end),'left(game_time_end,10)<=',$game_time_end,'"');
        $criteria->condition = get_like($criteria->condition,'game_club_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['game_level'] = BaseCode::model()->getCode(163);
        parent::_list($model, $criteria, 'game_club_history_search', $data);
    }

    // 获取项目
    public function actionData_id($game_id){
		$data = GameListData::model()->findAll('game_id='.$game_id.' ');
		$row = array();
		if(!empty($data)){
			foreach($data as $d => $val){
				$row[$d]['id'] = $val->id;
				$row[$d]['game_data_name'] = $val->game_data_name;
			}
		}
		echo CJSON::encode($row);
    }

    //直播关联列表
    public function actionIndex_video_live($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'game_club_id='.get_session('club_id').' and t.t.state=2 and !isnull(t.video_live_id)';
        $criteria->condition = get_like($criteria->condition,'t.game_title',$keywords,'');
		$criteria->join = "JOIN video_live t2 on find_in_set(t2.id ,t.video_live_id)";
        $criteria->select='t.id,t.game_title,t.video_live_id,t2.id video_id,t2.title video_title';
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
        $game=GameList::model()->find($criteria);
        $arr=explode(",", $game->video_live_id);
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
        $criteria->condition = 'id in(' . $_POST['game_id'] . ')';
        $count = $model->updateAll(array('video_live_id' => $_POST['video_live_id']), $criteria);
        VideoLive::model()->updateAll(array('uDate' => date('Y-m-d H:i:s')), 'id in('.$_POST['video_live_id'].')');
        if($count>0){
            ajax_status(1, '关联成功', get_cookie('_currentUrl_'));
        }else{
            ajax_status(0, '关联成功');
        }
    }
}
