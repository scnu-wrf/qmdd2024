<?php

class GameNewsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }


    //赛事动态发布列表
    public function actionIndex($keywords = '',$news_type='') {
        $now=date('Y-m-d H:i:s');
        $this->ShowView($keywords,'','',$news_type,' t.club_id='.get_session('club_id'),721,'index');
    }
    //发布待审核列表
    public function actionIndex_submit($keywords = '',$news_type='') {
        $this->ShowView($keywords,'','',$news_type,' t.club_id='.get_session('club_id'),371,'index_submit');
    }
    //动态列表
    public function actionIndex_news($keywords = '',$start_date='',$end_date='',$news_type='') {
        $this->ShowView($keywords,$start_date,$end_date,$news_type,' t.club_id='.get_session('club_id'),2,'index_news');
    }

    //审核未通过列表
    public function actionIndex_fail($keywords = '',$start_date='',$end_date='',$news_type='') {
        $this->ShowView($keywords,$start_date,$end_date,$news_type,get_where_club_project('club_id',''),373,'index_fail');
    }

    public function ShowView($keywords = '',$start_date='',$end_date='',$news_type,$club,$state,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if($start_date!='') $start_date =$start_date.' 00:00:00'; 
        if($end_date!='') $end_date =$end_date.' 23:59:59';
        $criteria = new CDbCriteria;
        $cr=$club;
        $cr.=' and t.if_del=506';
        $cr.=' and t.state='.$state;
        $cr=get_where($cr,!empty($news_type),'news_type',$news_type,'');
        $cr=get_where($cr,($start_date!=""),'news_date_start>=',$start_date,'"');
        $cr=get_where($cr,($end_date!=""),'news_date_end<=',$end_date,'"');
        $cr=get_like($cr,'news_title,news_code,t.game_names',$keywords,'');
        $criteria->condition=$cr;
        if($viewfile=='index_news'){
            $criteria->order= 'game_id DESC, order_num DESC';
        } else{
            $criteria->order = 'id DESC,game_id DESC';
        }
        $data = array();
        $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, $viewfile, $data);
    }
//赛事动态审核
    public function actionIndex_pass($keywords = '',$start_date='',$end_date='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start_date=='') {
            $start_date=$now;
        }
        $criteria = new CDbCriteria;
        //$cr=get_where_club_project('club_id','');
        $cr='if_del=506';
        $cr.=' and state in (2,373)';
        $cr=get_where($cr,!empty($news_type),'news_type',$news_type,'');
        $cr=get_where($cr,($start_date!=""),'state_time>=',$start_date,'"');
        $cr=get_where($cr,($end_date!=""),'state_time<=',$end_date,'"');
        $cr=get_like($cr,'news_title,news_code,t.game_names',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['news_type'] = BaseCode::model()->getCode(882);
        $data['num'] = $model->count('if_del=506 and state=371');
        parent::_list($model, $criteria, 'index_pass', $data);
    }

    //赛事动态审核-待审核
    public function actionSubmit_list($keywords = '',$start_date='',$end_date='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        //$cr=get_where_club_project('club_id','');
        $cr='if_del=506';
        $cr.=' and state=371';
        $cr=get_where($cr,!empty($news_type),'news_type',$news_type,'');
        $cr=get_where($cr,($start_date!=""),'apply_date>=',$start_date,'"');
        $cr=get_where($cr,($end_date!=""),'apply_date<=',$end_date,'"');
        $cr=get_like($cr,'news_title,news_code,t.game_names',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'submit_list', $data);
    }
    public function actionIndex_gf($keywords = '',$start_date='',$end_date='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if($start_date!='') $start_date =$start_date.' 00:00:00'; 
        if($end_date!='') $end_date =$end_date.' 23:59:59';  
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('club_id','');
        $cr.=' and if_del=506';
        $cr.=' and state=2';
        $crn=get_where($cr,!empty($news_type),'news_type',$news_type,'');
        $cr=get_where($cr,($start_date!=""),'news_date_start>=',$start_date,'"');
        $cr=get_where($cr,($end_date!=""),'news_date_end<=',$end_date,'"');
        $cr=get_like($cr,'news_title,news_code,t.game_names',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'state_time DESC';
        $data = array();
        $data['news_type'] = BaseCode::model()->getCode(882);
        parent::_list($model, $criteria, 'index_gf', $data);
    }
//添加
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['flag'] = 0;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

//编辑详情
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(189);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
           $data['flag'] = 1;
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
 //保存 
    function saveData($model,$post) {
        $model->attributes =$post;
        $old_pic='';
        $model->state=get_check_code($_POST['submitType']);
        if($_POST['submitType']=='shenhe'){
            $model->apply_date=date('Y-m-d');
       }
        $sv=$model->save();
        $this->save_pics($model->id,$post['game_news_pic']); 
	    $this->save_gfmaterial($old_pic,$model->news_pic,$model->news_title);
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

       //保存到素材管理	
public function save_gfmaterial($oldpic,$pic,$title){  
	$logopath=BasePath::model()->getPath(189);
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
//查看待审核详情
    public function actionUpdate_submit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(189);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
           $this->render('update_submit', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            $st=0;
            $now=date('Y-m-d H:i:s');
            if($state!=''){
            GameNews::model()->updateAll(array('state'=>$state, 'uDate'=>$now),'id='.$model->id);
                $st++;
            }
            show_status($st,'已撤销',get_cookie('_currentUrl_'),'撤销失败');
         }
    }

    //查看待审核详情
    public function actionUpdate_checked($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(189);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
           $this->render('update_checked', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            $st=0;
            $msg=$model->reasons_for_failure;
            $state_qmddid = get_session('admin_id'); 
            $state_qmddname = get_session('admin_name');
            $now=date('Y-m-d');
            if($state!=''){
            GameNews::model()->updateAll(
                array('state'=>$state,
                    'state_time'=>$now,
                    'reasons_for_failure'=>$msg,
                    'state_qmddid'=>$state_qmddid,
                    'state_qmddname'=>$state_qmddname,
                    'uDate'=>date('Y-m-d H:i:s')
                ),'id='.$model->id);
                $st++;
            }
            show_status($st,'已审核',get_cookie('_currentUrl_'),'审核失败');
        }
    }
  //逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
			$model->updateByPk($d,array('if_del'=>507));
			$count++;
		}
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
    //置顶设置
    public function actionTheFirst($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
            $news=$model->find('id='.$d);
            $num=$model->findAll('game_id='.$news->game_id.' and id<>'.$d.' and if_del=506 and order_num is not null order by order_num DESC');
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

    //////////////////////////////// 保存子图集//////////////////// 
    public function save_pics($id,$pic){
        GameNewsPic::model()->updateAll(array('order_num'=>-1),'game_news_id='.$id);//做临时删除标识
        if (isset($_POST['game_news_pic'])) {
            $newspic = new GameNewsPic();
            foreach ($_POST['game_news_pic'] as $v) {
                if ($v['pic'] == '') {
                    continue;
                }		
                if ($v['id'] =='null') {
                    $newspic->isNewRecord = true;
                    unset($newspic->id);
                    $newspic->game_news_id =$id;
                    $newspic->news_pic =$v['pic'];
                    $newspic->introduce = $v['intro'];
                    $newspic->save();
                } else {
                    $newspic->updateByPk($v['id'],array('introduce' => $v['intro'],'order_num'=>0));
                }
            }
        }
        GameNewsPic::model()->deleteAll('order_num=-1 and game_news_id='.$id);
    }

}
