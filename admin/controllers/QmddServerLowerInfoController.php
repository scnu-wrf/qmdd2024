<?php

class QmddServerLowerInfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
//服务发布	
	public function actionIndex($keywords = '',$server_type = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr= 'f_check in(721,371,373,1538)';
		$cr.=' and supplier_id='.get_session('club_id');
		$cr=get_where($cr,!empty($server_type),' t.f_typeid',$server_type,'');
        $cr=get_like($cr,'set_code,set_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
     	$data = array();
		$data['server_type'] = QmddServerType::model()->getServertype();
        parent::_list($model, $criteria, 'index', $data);
    }
//服务发布审核	
	public function actionIndex_pass($keywords = '',$star='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$now=date('Y-m-d');
        if ($star=='') $star=$now;
        $criteria = new CDbCriteria;
		$cr='down_up>=0';
		$cr.=' and f_check in(2,373,1538)';
		$cr.=' and supplier_id='.get_session('club_id');
		$cr=get_where($cr,($star!=""),'reasons_time>=',$star.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'reasons_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'set_code,set_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
     	$data = array();
     	$data['star'] =$star;
     	$data['end'] =$end;
     	$data['server_type'] = QmddServerType::model()->getServertype();
        $data['num'] = $model->count('down_up>=0 and f_check=371 and supplier_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_pass', $data);
    }
//服务发布审核-待审核	
	public function actionIndex_check($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr='down_up>=0';
		$cr.=' and f_check=371';
		$cr.=' and supplier_id='.get_session('club_id');
        $cr=get_like($cr,'set_code,set_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
     	$data = array();
     	$data['server_type'] = QmddServerType::model()->getServertype();
        parent::_list($model, $criteria, 'index_check', $data);
    }
//审核未通过列表
	public function actionIndex_fail($keywords = '',$star='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$now=date('Y-m-d');
        if ($star=='') $star=$now;
        $criteria = new CDbCriteria;
		$cr='down_up>=0';
		$cr.=' and f_check=373';
		//$cr.=' and supplier_id='.get_session('club_id');
		$cr=get_where($cr,($star!=""),'reasons_time>=',$star.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'reasons_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'set_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
     	$data = array();
     	$data['star'] =$star;
     	$data['end'] =$end;
     	$data['server_type'] = QmddServerType::model()->getServertype();
        parent::_list($model, $criteria, 'index_fail', $data);
    }
//服务发布查询
	public function actionIndex_list($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr='down_up>=0';
		$cr.=' and f_check=2';
		$cr.=' and supplier_id='.get_session('club_id');
        $cr=get_like($cr,'set_code,set_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
     	$data = array();
        parent::_list($model, $criteria, 'index_list', $data);
    }
	
	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['server_time'] = QmddServerTime::model()->findAll('state=2');
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
		set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['server_time'] = QmddServerTime::model()->findAll('state=2');
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

	function saveData($model,$post) {
       $model->attributes =$post;
       $model->supplier_id=get_session('club_id');
	   $model->f_check =get_check_code($_POST['submitType']);
	   //$model->f_check=2;
       $sv=$model->save();
	   $this->save_list($model->id,$post['product']);
	   $this->save_data($model->id,$post['setdata']);
	   if($_POST['submitType']=='shenhe'){
           $action=get_cookie('_currentUrl_');
           $s='提交成功';$f='提交失败';
        } else {
        	$action=$this->createUrl('update', array('id'=>$model->id,'cur'=>1));
        	$s='保存成功';$f='保存失败';
        }
       show_status($sv,$s, $action,$f); 
    }
	 //////////////////////////////// 保存服务信息///////////////////// 
    public function save_list($id,$product){
    	$model= QmddServerSetInfo::model()->find('id='.$id);
    	QmddServerSetList::model()->updateAll(array('if_del'=>509),'info_id='.$id);
    	if (isset($_POST['product'])) {
	        foreach ($_POST['product'] as $v) {
				if ($v['server_sourcer_id'] == '') {
				   continue;
				}	
				$sourcer=QmddServerSourcer::model()->find('id ='.$v['server_sourcer_id'].' order by id DESC');
				if ($v['id']=='null') {
					$setlist = new QmddServerSetList();
					$setlist->isNewRecord = true;
	                unset($setlist->id);
				} else{
					$setlist=QmddServerSetList::model()->find('id='.$v['id']);
				}
				$setlist->info_id = $id;
                $setlist->server_sourcer_id = $v['server_sourcer_id'];
			    $setlist->Inventory_quantity =1;
				$setlist->star_time=$model->star_time;
				$setlist->end_time=$model->end_time;
				$setlist->server_start=$model->server_start;
				$setlist->server_end=$model->server_end;
				$setlist->club_id = $model->supplier_id;
				$setlist->f_check = $model->f_check;

				$setlist->project_ids = $sourcer->project_ids;
				$setlist->s_code = $sourcer->s_code;
				$setlist->s_name = $sourcer->s_name;
				$setlist->s_value = $sourcer->s_value;
				$setlist->s_gfid = $sourcer->s_gfid;
				$setlist->s_gfname = $sourcer->s_gfname;
				$setlist->t_typeid = $model->f_typeid;
				$setlist->t_stypeid = $sourcer->t_stypeid;
				$setlist->s_levelid = $sourcer->s_levelid;
				$setlist->s_levelname = $sourcer->s_levelname;
				$setlist->site_id = $sourcer->site_id;
				$setlist->site_type = $sourcer->site_type;
				$setlist->if_del = 510;
				$setlist->save();
			}
    	}
    	QmddServerSetList::model()->deleteAll('info_id='.$id.' and if_del=509');

    }

	
	//查看服务时间价格
	public function actionMemberprice($detail_id) {
        $model = QmddServerSetData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'list_id='.$detail_id;
		//$criteria->group = 's_date';
        $criteria->order = 's_date ASC';
		$data = array();
		$data['setlist'] = QmddServerSetList::model()->find('id='.$detail_id);
		$data['s_data'] = QmddServerSetData::model()->findAll('list_id='.$detail_id);
        $data['s_time'] = QmddServerSetData::model()->findAll('(list_id='.$detail_id.') group by s_timename');
		//$data['date'] = QmddServerSetData::model()->findAll('list_id='.$detail_id.' group by s_date');
        parent::_list($model, $criteria, 'memberprice', $data);
    }


	//服务审核详情
    public function actionUpdate_check($id) {
		set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['server_time'] = QmddServerTime::model()->findAll('state=2');
            $this->render('update_check', $data);
        } else {
            $model->attributes =$_POST[$modelName];
			$state=get_check_code($_POST['submitType']);
			$adminID = get_session('admin_id');
            $gfaccount = get_session('gfaccount');
		    $admin_name = get_session('admin_name');
		    $msg=$model->reasons_for_failure;
		    $now = date('Y-m-d H:i:s');
			$st=0;
			if($state==721){
				QmddServerSetInfo::model()->updateAll(array('f_check'=>$state),'id='.$model->id);
				QmddServerSetList::model()->updateAll(array('f_check'=>$state),'info_id='.$model->id);
		    	QmddServerSetData::model()->updateAll(array('f_check'=>$state),'info_id='.$model->id);
		    	$st++;
		    	$s='撤销成功';$f='撤销失败';
			}else{
				QmddServerSetInfo::model()->updateAll(array('f_check'=>$state,'reasons_adminID'=>$adminID,'reasons_gfaccount'=>$gfaccount,'reasons_admin_nick'=>$admin_name,'reasons_time'=>$now,'reasons_for_failure'=>$msg),'id='.$model->id);
				QmddServerSetList::model()->updateAll(array('f_check'=>$state),'info_id='.$model->id);
		    	QmddServerSetData::model()->updateAll(array('f_check'=>$state),'info_id='.$model->id);
		    	$st++;
		    	$s='操作成功';$f='操作失败';
			}
			show_status($st,$s,get_cookie('_currentUrl_'),$f);
        }
    }

	//逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->deleteAll('id in('.$id.')');
		if($count>0) {
			foreach ($club as $d) {
				QmddServerSetList::model()->deleteAll('info_id='.$d);
				QmddServerSetData::model()->deleteAll('info_id ='.$d);
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
        $st=0;
        $count=$model->deleteAll('id='.$id);
        if($count>0) {
			foreach ($club as $d) {
				QmddServerSetList::model()->deleteAll('info_id='.$d);
				QmddServerSetData::model()->deleteAll('info_id ='.$d);
			}
			$st++;
		}
        show_status($st,'删除成功',get_cookie('_currentUrl_'),'删除失败');
    }
//撤销审核
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('f_check'=>721));
                QmddServerSetList::model()->updateAll(array('f_check'=>721),'info_id='.$d);
		    	QmddServerSetData::model()->updateAll(array('f_check'=>721),'info_id='.$d);
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }

	

}
