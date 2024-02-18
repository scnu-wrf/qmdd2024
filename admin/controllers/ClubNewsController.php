<?php

class ClubNewsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$start_date='',$end_date='',$state='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		// $criteria->join = "join club_news_project on t.id=club_news_project.club_news_id";
  //       $criteria->condition=get_where_club_project('club_id','club_news_project.project_id');
		$criteria->condition='if_del=506 AND ';
    $criteria->condition.=get_where_club_project('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($news_type),'news_type',$news_type,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_start>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_end<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,news_club_name',$keywords,'');//get_where
       $criteria->group='t.id';
      // $criteria->condition.='  group by t.id';
        $criteria->order = 'uDate DESC';
	      $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
		$data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        $data['news_type'] = BaseCode::model()->getCode(882);
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['news_type'] = BaseCode::model()->getCode(882);
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }

    public function actionIndex_report($keywords = '',$start_date='',$end_date='',$state='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
    // $criteria->join = "join club_news_project on t.id=club_news_project.club_news_id";
    //     $criteria->condition=get_where_club_project('club_id','club_news_project.project_id');
    $criteria->condition='if_del=506 AND state in(371) and ';
    $criteria->condition.=get_where_club_project('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($news_type),'news_type',$news_type,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_start>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_end<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,news_club_name',$keywords,'');//get_where
       $criteria->group='t.id';
      // $criteria->condition.='  group by t.id';
        $criteria->order = 'apply_time DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
    $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'index_report', $data);
    }

    public function actionReport_update($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['news_type'] = BaseCode::model()->getCode(882);
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('report_update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_nopass($keywords = '',$start_date='',$end_date='',$state='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
    // $criteria->join = "join club_news_project on t.id=club_news_project.club_news_id";
    //     $criteria->condition=get_where_club_project('club_id','club_news_project.project_id');
    $criteria->condition='if_del=506 AND state in(373) and ';
    $criteria->condition.=get_where_club_project('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($news_type),'news_type',$news_type,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_start>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_end<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,news_club_name',$keywords,'');//get_where
       $criteria->group='t.id';
      // $criteria->condition.='  group by t.id';
        $criteria->order = 'apply_time DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
    $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'index_nopass', $data);
    }

    public function actionNopass_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
    $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['news_type'] = BaseCode::model()->getCode(882);
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('nopass_check', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }

    public function actionIndex_examine($keywords = '',$start_date='',$end_date='',$state='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
    // $criteria->join = "join club_news_project on t.id=club_news_project.club_news_id";
    //     $criteria->condition=get_where_club_project('club_id','club_news_project.project_id');
    $criteria->condition='if_del=506 AND state in(2,373) and ';
    $criteria->condition.=get_where_club_project('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($news_type),'news_type',$news_type,'');
        // $criteria->condition=get_where($criteria->condition,($start_date!=""),'state_time>=',$start_date,'"');
        // $criteria->condition=get_where($criteria->condition,($start_date!=""),'state_time<=',$end_date,'"');
        if ($start_date != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$start_date.'"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$end_date.'"';
        }
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,news_club_name',$keywords,'');//get_where
       $criteria->group='t.id';
      // $criteria->condition.='  group by t.id';
        $criteria->order = 'state_time DESC';
        $data = array();
        $num=$model->count(get_where_club_project("club_id").' and state = 371 and if_del = 506');
        //统计指定条件的记录总数
        $data['num'] =$num;
        $data['state'] = BaseCode::model()->getCode(370);
    $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'index_examine', $data);
    }

    public function actionExamine_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
    $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['news_type'] = BaseCode::model()->getCode(882);
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('examine_check', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }

    public function actionExamine_list($keywords = '',$start_date='',$end_date='',$state='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
    // $criteria->join = "join club_news_project on t.id=club_news_project.club_news_id";
    //     $criteria->condition=get_where_club_project('club_id','club_news_project.project_id');
    $criteria->condition='if_del=506 AND state in(371) and ';
    $criteria->condition.=get_where_club_project('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($news_type),'news_type',$news_type,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,news_club_name',$keywords,'');//get_where
       $criteria->group='t.id';
      // $criteria->condition.='  group by t.id';
        $criteria->order = 'apply_time DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
    $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'examine_list', $data);
    }

    public function actionExamine_update($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
    $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['news_type'] = BaseCode::model()->getCode(882);
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('examine_update', $data);
        } else {
            $this-> examineData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_list($keywords = '',$start_date='',$end_date='',$state='',$news_type='',$online='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $cr='if_del=506 AND state=2';
        $cr.=' and club_id='.get_session('club_id');
        $cr=get_where($cr,!empty($news_type),'news_type',$news_type,'');
        if($online==648) $cr.=' and (news_date_start>"'.$now.'" or news_date_end<"'.$now.'")';
        if($online==649) $cr.=' and news_date_start<"'.$now.'" and news_date_end>"'.$now.'"';
        $cr=get_where($cr,($start_date!=""),'news_date_start=',$start_date.' 00:00:00','"');
        $cr=get_where($cr,($end_date!=""),'news_date_end<=',$end_date.' 23:59:59','"');
        $cr=get_like($cr,'news_title,news_code,news_club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order = 'order_num DESC, state_time DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
        $data['news_type'] = BaseCode::model()->getCode(882);
        $data['online'] = BaseCode::model()->getCode(647);
        parent::_list($model, $criteria, 'index_list', $data);
    }
    public function actionList_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
    $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('list_check', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_box($keywords = '',$start_date='',$end_date='',$state='',$news_type='',$online='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $criteria = new CDbCriteria;
        $cr='if_del=506 AND state=2';
        $cr=get_where($cr,!empty($news_type),'news_type',$news_type,'');
        if($online==648) $cr.=' and (news_date_start>"'.$now.'" or news_date_end<"'.$now.'")';
        if($online==649) $cr.=' and news_date_start<"'.$now.'" and news_date_end>"'.$now.'"';
        $cr=get_where($cr,($start_date!=""),'news_date_start=',$start_date.' 00:00:00','"');
        $cr=get_where($cr,($end_date!=""),'news_date_end<=',$end_date.' 23:59:59','"');
        $cr=get_like($cr,'news_title,news_code,news_club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order = 'order_num DESC, state_time DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
        $data['news_type'] = BaseCode::model()->getCode(882);
        $data['online'] = BaseCode::model()->getCode(647);
        parent::_list($model, $criteria, 'index_box', $data);
    }

    public function actionBox_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
    $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['news_type'] = BaseCode::model()->getCode(882);
           $basepath = BasePath::model()->getPath(222);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('box_check', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
       $model->attributes =$post;
       $old_pic=$model->news_pic;
       $model->state=($_POST['submitType']=='chexiao') ? 721 : get_check_code($_POST['submitType']);
       $sv=$model->save();  
       $this->save_pics($model->id,$post['club_news_pic']);
       $this->save_projects($model->id,$post['project_id']);
       if(($model->club_id==2450) || get_session('club_id')==2450) {
           $this->save_club_list($model->id,$post['club_list']);
         }
	     $this->save_gfmaterial($old_pic,$model->news_pic,$model->news_title);
	     $logopath=BasePath::model()->getPath(124);
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
 }

    function examineData($model,$post) {
       $model->attributes =$post;
       $old_pic=$model->news_pic;
       $model->state=($_POST['submitType']=='chexiao') ? 721 : get_check_code($_POST['submitType']);
       $sv=$model->save();  
       $this->save_pics($model->id,$post['club_news_pic']);
       $this->save_projects($model->id,$post['project_id']);
       if(($model->club_id==2450) || get_session('club_id')==2450) {
           $this->save_club_list($model->id,$post['club_list']);
         }
         $this->save_gfmaterial($old_pic,$model->news_pic,$model->news_title);
         $logopath=BasePath::model()->getPath(124);
         $model->state = get_check_code($_POST['submitType']);
         if($_POST['submitType'] == 'tongguo') {
            show_status($sv,'审核通过', get_cookie('_currentUrl_'),'操作出错');
        } else if($_POST['submitType'] == 'butongguo') {
            show_status($sv,'审核不通过', get_cookie('_currentUrl_'),'操作出错');
        }
 }
 
  //保存到素材管理	
public function save_gfmaterial($oldpic,$pic,$title){  
	$logopath=BasePath::model()->getPath(124);
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
 
     //逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $lode = explode(',', $id);
        $count=0;
        foreach($lode as $d){
            $model->updateAll(array('if_del'=>507),'id='.$d);
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

    //置顶设置
    public function actionTheFirst($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
            $news=$model->find('id='.$d);
            $num=$model->find('top_num='.$news->top_num.' and id<>'.$d.' and if_del=506 and order_num is not null order by order_num DESC');
            if(!empty($num)){
                $model->updateByPk($d,array('order_num'=>$num->order_num+1));
                $count++;
            } else{
                $model->updateByPk($d,array('order_num'=>1));
                $count++;
            }  
            
        }
        if ($count > 0) {
            ajax_status(1, '置顶成功');
        } else {
            ajax_status(0, '置顶失败');
        }
    }

    //取消置顶
    public function actionRemoveTheFirst($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
            $news=$model->find('id='.$d);
            $num=$model->find('top_num='.$news->top_num.' and id<>'.$d.' and if_del=506 and order_num is not null order by order_num DESC');
            $model->updateByPk($d,array('order_num'=>$num->order_num=0));
                $count++; 
        }
        if ($count > 0) {
            ajax_status(1, '取消置顶成功');
        } else {
            ajax_status(0, '取消置顶失败');
        }
    }

    //撤销申请
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('state'=>721, 'uDate'=>$now));
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }

    public function actionPassSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('state'=>2, 'uDate'=>$now));
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '审核通过');
        } else {
            ajax_status(0, '操作失败');
        }
    }
  
     //////////////////////////////// 保存子图集//////////////////// 
  public  function save_pics($id,$pic){
	$club_news_pic=ClubNewsPic::model()->findAll('club_news_id='.$id);
	$arr=array();
	if (isset($_POST['club_news_pic'])) {
        $newspic = new ClubNewsPic();
        foreach ($_POST['club_news_pic'] as $v) {
            if ($v['pic'] == '') {
               continue;
             }		
			 if ($v['id'] =='null') {
				 //if($v['intro']
				 $newspic->isNewRecord = true;
                 unset($newspic->id);
                 $newspic->club_news_id =$id;
			     $newspic->news_pic =$v['pic'];
                 $newspic->introduce = $v['intro'];
                 $newspic->save();
			 } else {
				 $newspic->updateByPk($v['id'],array('introduce' => $v['intro']));
				 $arr[]=$v['id'];
			 }
            
         }
     }
	 if(isset($club_news_pic)) {
		 foreach ($club_news_pic as $k) {
			 if(!in_array($k->id,$arr)) {
				 ClubNewsPic::model()->deleteAll('id='.$k->id);
			 }
		 }
	 }
	 
  }

  public  function save_projects($club_news_id,$project_id){       
    //删除原有项目
    ClubNewsProject::model()->deleteAll('club_news_id='.$club_news_id);
    if(!empty($project_id)){
        $model2 = new ClubNewsProject();
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_id);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
            unset($model2->id);
            $model2->club_news_id = $club_news_id;
            $model2->project_id = $v;
            $model2->save();
        }
    }
  }

  public  function save_club_list($news_id,$club_list){       
    //删除原有项目
    ClubNewsRecommend::model()->deleteAll('news_id='.$news_id);
    if(!empty($club_list)){
        $model2 = new ClubNewsRecommend();
        $club_list_pic = array();
        $club_list_pic = explode(',', $club_list);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
            unset($model2->id);
            $model2->news_id = $news_id;
            $model2->recommend_clubid = $v;
            $model2->save();
        }
    }
  }

   

}
