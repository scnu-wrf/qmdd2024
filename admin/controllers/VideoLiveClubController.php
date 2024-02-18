<?php

class VideoLiveClubController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
//直播单位申请列表
    public function actionIndex($keywords = '',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr='state in (721,371,374)';
        $cr=get_where($cr,$start,'apply_time>=',$start,"'");
        $cr=get_where($cr,$end,'apply_time<=',$end,"'");
        $cr=get_like($cr,'club_code,club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
//直播单位审核列表-待审核
    public function actionIndex_checked($keywords = '',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='state=371';
        $cr=get_where($cr,$start,'apply_time>=',$start,"'");
        $cr=get_where($cr,$end,'apply_time<=',$end,"'");
        $cr=get_like($cr,'club_code,club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_checked', $data);
    }
//直播单位审核列表
    public function actionIndex_pass($keywords = '',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d');
        if ($start=='') {
            $start=$now;
        }
        $cr='state in (2,373)';
        $cr=get_where($cr,$start,'state_time>=',$start,"'");
        $cr=get_where($cr,$end,'state_time<=',$end,"'");
        $cr=get_like($cr,'club_code,club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['num'] = $model->count('state=371');
        parent::_list($model, $criteria, 'index_pass', $data);
    }
//直播单位审核列表
    public function actionIndex_live($keywords = '',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($start=='') {
            $start=$now_m;
        }
        $cr='state in (2,373)';
        $cr=get_where($cr,$start,'state_time>=',$start,"'");
        $cr=get_where($cr,$end,'state_time<=',$end,"'");
        $cr=get_like($cr,'club_code,club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['num'] = $model->count('state=371');
        parent::_list($model, $criteria, 'index_live', $data);
    }

    //取消/审核未通过
    public function actionIndex_fail($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='state=373';
        $cr=get_like($cr,'club_code,club_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_fail', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['flag'] = 0;
            $data['model']->server_type=explode(',',$data['model']->server_type); //把字符串打散为数组
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_apply($id) {
        $id=get_session('club_id');
        $modelName = $this->model;
        $liveclub=VideoLiveClub::model()->find('club_id='.$id);
        if (!empty($liveclub)){
            $model = $this->loadModel($liveclub->id, $modelName);
        } else{
            $model = new $modelName('create');
            $club_list=ClubList::model()->find('id='.$id);
            $model->club_id=$club_list->id;
            $model->club_code=$club_list->club_code;
            $model->club_name=$club_list->club_name;
            $model->club_type=$club_list->club_type;
            $model->partnership_type=$club_list->partnership_type;
            $model->apply_name=$club_list->apply_name;
            $model->contact_phone=$club_list->contact_phone;
            $model->email=$club_list->email;
            $model->contact_address=$club_list->con_address;
        }
        
        
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->server_type=explode(',',$data['model']->server_type); //把字符串打散为数组
            $data['model']->is_read=explode(',',$data['model']->is_read); //把字符串打散为数组
            $this->render('update_apply', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $model->state=get_check_code($_POST['submitType']);
            $model->server_type=gf_implode(',',$model->server_type); //把数组元素组合为一个字符串
            $model->is_read=gf_implode(',',$model->is_read); //把数组元素组合为一个字符串
            $txt1='保存成功';
            $txt2='保存失败';
            if($_POST['submitType']=='shenhe'){
                $model->apply_time = date('Y-m-d');
                $txt1='提交成功';
                $txt2='提交失败';
            } 
            $st=$model->save();
            show_status($st,$txt1,Yii::app()->request->urlReferrer,$txt2);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['model']->server_type=explode(',',$data['model']->server_type); //把字符串打散为数组
            $data['model']->is_read=explode(',',$data['model']->is_read); //把字符串打散为数组
            $data['flag'] = 1;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
    public function actionUpdate_checked($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['model']->server_type=explode(',',$data['model']->server_type); //把字符串打散为数组
          
            $this->render('update_checked', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
  
    function saveData($model,$post) {
       $model->attributes =$post;
       $now=date('Y-m-d');
       if($_POST['submitType']=='tongguo' || $_POST['submitType']=='butongguo'){
            $state=get_check_code($_POST['submitType']);
            $st=0;
            if($state!=''){
                VideoLiveClub::model()->updateAll(array('state'=>$state,'state_time'=>$now),'id='.$model->id);
                $st++;
            }
            show_status($st,'已审核',get_cookie('_currentUrl_'),'审核失败');

       } else{
           $model->state=get_check_code($_POST['submitType']);
           $model->server_type=gf_implode(',',$post['server_type']); //把数组元素组合为一个字符串
           $model->is_read=gf_implode(',',$post['is_read']); //把数组元素组合为一个字符串
            $txt1='保存成功';
            $txt2='保存失败';
            if($_POST['submitType']=='shenhe'){
                $model->apply_time =$now;
                $txt1='提交成功';
                $txt2='提交失败';
            }
            $sv=$model->save(); 
            show_status($sv,$txt1,get_cookie('_currentUrl_'),$txt2);
       }
        
    }

 //根据安慰帐号获取单位信息
    public function actionValidate($code) {
      $arr = array();
      $club_list= ClubList::model()->find('club_code="'.$code.'"');
      if(!empty($club_list)) {
        $arr['status'] = 1;
        $arr['club_id'] = $club_list->id;
        $arr['club_code'] = $club_list->club_code;
        $arr['club_name'] = $club_list->club_name;
        $arr['club_type'] = $club_list->club_type;
        $arr['partnership_type'] = $club_list->partnership_type;
        $arr['partnership_name'] = $club_list->partnership_name;
        $arr['apply_name'] = $club_list->apply_name;
        $arr['contact_address'] = $club_list->con_address;
        $arr['contact_phone'] = $club_list->contact_phone;
        $arr['email'] = $club_list->email;
       } else{
        $arr['status'] = 0;
       } 
        ajax_exit($arr);
    }
 
  
 
     //删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count=0;
        $count=$model->deleteAll('id in (' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }


    //撤销申请
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('state'=>721));
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }
  
  
   

}
