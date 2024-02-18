<?php

class QmddServerSetInfoController extends BaseController {

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
		$cr=get_where_club_project('supplier_id','');
		$cr= 'down_up>=0 and f_check in(721,371,373,1538)';
		$cr.=' and supplier_id='.get_session('club_id');
		$cr=get_where($cr,!empty($server_type),' t.f_typeid',$server_type,'');
        $cr=get_like($cr,'set_code,set_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
     	$data = array();
		$data['server_type'] = QmddServerType::model()->getServertype();
        parent::_list($model, $criteria, 'index', $data);
    }

// 服务上下架-服务者
    public function actionIndex_server_person($keywords = '',$server_type = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr=get_where_club_project('supplier_id','');
        $cr= 'down_up>=0 and f_check in(721,371,373,1538)';
        $cr.=' and supplier_id='.get_session('club_id');
        $cr=get_where($cr,!empty($server_type),' t.f_typeid',$server_type,'');
        $cr=get_like($cr,'set_code,set_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['server_type'] = QmddServerType::model()->getServertype();
        parent::_list($model, $criteria, 'index_server_person', $data);
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
			$data['server_time'] = QmddServerTime::model()->findAll('state in(2,0)');
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
			$data['server_time'] = QmddServerTime::model()->findAll('state in(2,0)');
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
	 //////////////////////////////// 保存服务时间价格/////////////////////
    public function save_data($id,$product){
    	$model= QmddServerSetInfo::model()->find('id='.$id);
    	$stime=$model->server_start;//开始时间
		$etime=$model->server_end;//结束时间
        $datearr = range(strtotime($stime), strtotime($etime), 24*60*60);
        $data1 = array();

    	if (isset($_POST['setdata'])) {
            $cn=array('condition'=>'info_id='.$id,'select'=>'id,list_id,s_date,s_timename');
    		$stime = QmddServerTime::model()->findAll('state in(2,0)');
			$data_old=QmddServerSetData::model()->findAll($cn);
			$id_check=array();
			foreach($data_old as $k => $v){
				$id_check[$v['list_id']][$v['server_sourcer_id']][$v['s_date']][$v['s_timename']]=$v['id'];
        	}
			QmddServerSetData::model()->updateAll(array('server_order'=>-1),'info_id='.$id);

			$rr=0;
			$data1=array();
	        foreach ($_POST['setdata'] as $v) {
				if ($v['server_sourcer_id'] == '') {
				   continue;
				}
				$list=QmddServerSetList::model()->find('server_sourcer_id='.$v['server_sourcer_id'].' and info_id='.$id);
				$sourcer=QmddServerSourcer::model()->find('id='.$v['server_sourcer_id']);
				if($list){
					$s_id=$list->server_sourcer_id;
					$l_id=$list->id;
					$arr=array();
					$arr['id']="";
					$arr['info_id']=$id;
					$arr['list_id']=$l_id;
					$arr['server_sourcer_id']=$s_id;
					$arr['server_order']=0;
					$arr['club_id']=$model->supplier_id;
					$arr['star_time']=$list->star_time;
					$arr['end_time']=$list->end_time;
					$arr['s_code']=$list->s_code;
					$arr['s_name']=$list->s_name;
					$arr['s_gfid']=$list->s_gfid;
					$arr['s_gfname']=$list->s_gfname;
					$arr['t_typeid']=$list->t_typeid;
					$arr['t_stypeid']=$list->t_stypeid;
					$arr['level_id']=$list->s_levelid;
					$arr['project_ids']=$list->project_ids;
					$arr['f_check']=$model->f_check;
					$arr['json_data']=$sourcer->json_data;
					$arr['longitude']=$sourcer->Longitude;
					$arr['latitude']=$sourcer->latitude;
					$arr['area']=$sourcer->area;
					$arr['area_location']=$sourcer->area_location;
					$arr['site_id']=$sourcer->site_id;
					$arr['site_type']=$sourcer->site_type;
					foreach ($stime as $t){
						if($v[$t->timename]){
 							$arr['s_timename']=$t->timename;
							$arr['sale_price']=$v[$t->timename];
						 	foreach($datearr as $key => $j){
								$arr['s_date']=date("Y-m-d",$j);
								$arr['id']="";
                                if(isset($id_check[$l_id][$s_id][$arr['s_date']][$t->timename])){
                                  	$arr['id']=$id_check[$l_id][$s_id][$arr['s_date']][$t->timename];
                                }
								$data1[]=$arr;$rr++;
								if($rr==100){
									batch_update_datas('qmdd_server_set_data',$data1);
									$data1=array();$rr=0;
								}
							}
						}
					}
				} //if
			} //for
			if($rr){
			  batch_update_datas('qmdd_server_set_data',$data1);
			}
			QmddServerSetData::model()->deleteAll('server_order=-1 and info_id='.$id);
    	} //if
    }


    public function CCsave_data($id,$product){
    	$model= QmddServerSetInfo::model()->find('id='.$id);
    	QmddServerSetData::model()->updateAll(array('server_order'=>-1),'info_id='.$id);
    	$stime=$model->server_start;//开始时间
		$etime=$model->server_end;//结束时间
        $datearr = range(strtotime($stime), strtotime($etime), 24*60*60);
        $data1 = array();
    	if (isset($_POST['setdata'])) {
    	    foreach ($_POST['setdata'] as $v) {
				if ($v['server_sourcer_id'] == '') {
				   continue;
				}
				$list=QmddServerSetList::model()->find('server_sourcer_id='.$v['server_sourcer_id'].' and info_id='.$id);
				$stime = QmddServerTime::model()->findAll('state in(2,0)');
				$sourcer=QmddServerSourcer::model()->find('id='.$v['server_sourcer_id']);
				if(!empty($list)){
					foreach ($stime as $t){
						if($v[$t->timename]!='') foreach($datearr as $key => $j){
							$date=date("Y-m-d",$j);
							$sql1='server_sourcer_id='.$v['server_sourcer_id'].' and info_id='.$id.' and s_date="'.$date.'" and s_timename="'.$t->timename.'"';
							$sdata=QmddServerSetData::model()->find($sql1.' AND special=1');
							$arr=array();
							$listdata=QmddServerSetData::model()->find($sql1);
							if(empty($sdata)){
								$arr['id'] = (empty($listdata)) ? '' : $listdata->id;
								$arr['info_id']=$id;
								$arr['list_id']=$list->id;
								$arr['server_sourcer_id']=$list->server_sourcer_id;
								$arr['server_order']=0;
								$arr['club_id']=$model->supplier_id;
								$arr['star_time']=$list->star_time;
								$arr['end_time']=$list->end_time;
								$arr['s_code']=$list->s_code;
								$arr['s_name']=$list->s_name;
								$arr['s_timename']=$t->timename;
								$arr['sale_price']=$v[$t->timename];
								$arr['s_date']=$date;
								$arr['s_gfid']=$list->s_gfid;
								$arr['s_gfname']=$list->s_gfname;
								$arr['t_typeid']=$list->t_typeid;
								$arr['t_stypeid']=$list->t_stypeid;
								$arr['level_id']=$list->s_levelid;
								$arr['project_ids']=$list->project_ids;
								$arr['f_check']=$model->f_check;
								$arr['json_data']=$sourcer->json_data;
								$arr['longitude']=$sourcer->Longitude;
								$arr['latitude']=$sourcer->latitude;
								$arr['area']=$sourcer->area;
								$arr['area_location']=$sourcer->area_location;
								$arr['site_id']=$sourcer->site_id;
								$arr['site_type']=$sourcer->site_type;
								$data1[]=$arr;
							}
						}
					}
					QmddServerSetData::model()->updateAll(array('server_order'=>0,'f_check'=>$model->f_check),'list_id='.$list->id.' AND special=1');
				}
			}

			$field='id,info_id,list_id,server_sourcer_id,server_order,club_id,star_time,end_time,s_code,s_name,s_timename,sale_price,s_date,s_gfid,s_gfname,t_typeid,t_stypeid,level_id,project_ids,f_check,json_data,longitude,latitude,area,area_location,site_id,site_type';
			if(!empty($data1)){
				$count = batch_update_datas('qmdd_server_set_data',$data1);
			}
    	}
	     QmddServerSetData::model()->deleteAll('info_id='.$id.' and server_order=-1');
    }


	//查看服务时间价格
	public function actionMemberprice($detail_id) {
        $model = QmddServerSetData::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'list_id='.$detail_id;
		$criteria->group = 's_date';
        $criteria->order = 's_date ASC';
		$data = array();
		$data['setlist'] = QmddServerSetList::model()->find('id='.$detail_id);
		$data['s_data'] = QmddServerSetData::model()->findAll('list_id='.$detail_id);
        $data['s_time'] = QmddServerSetData::model()->findAll('(list_id='.$detail_id.') group by s_timename');
		//$data['date'] = QmddServerSetData::model()->findAll('list_id='.$detail_id.' group by s_date');
        parent::_list($model, $criteria, 'memberprice', $data);
    }

	//特殊价格设置
	public function actionSpecial($id=0,$sdate='') {
        $model = QmddServerSetList::model();
        $info= QmddServerSetInfo::model()->find('id='.$id);
        $criteria = new CDbCriteria;
        $criteria->condition = 'info_id='.$id;
		//$criteria->group = 's_date';
        $criteria->order = 'id ASC';
		$data = array();
		$data['server_time'] = QmddServerTime::model()->findAll('state in(2,0)');
		$stime=$info->server_start;//开始时间
		$etime=$info->server_end;//结束时间
        $datearr = range(strtotime($stime), strtotime($etime), 24*60*60);
        $data['datearr'] = $datearr;
        $data['sdate'] = $sdate;
        $data['id'] = $id;
        parent::_list($model, $criteria, 'special', $data);
    }

    //保存特殊价格
	public function actionSpecial_save() {
        $modelName = $this->model;
     	$model = $modelName::model();
     	$stime = QmddServerTime::model()->findAll('state in(2,0)');
     	$id = $_POST['id'];
		$arr = $_POST['arr'];
		$sdate = $_POST['sdate'];
        $data = array();
		$count=0;
        if (isset($arr)) foreach ($arr as $v) {
            if ($v['id'] == '' || $v['server_sourcer_id'] == '') {
               continue;
            }
            $sql='list_id='.$v['id'].' and s_date="'.$sdate.'"';
            $list=QmddServerSetList::model()->find('id='.$v['id']);
            $sourcer=QmddServerSourcer::model()->find('id='.$v['server_sourcer_id']);
            QmddServerSetData::model()->updateAll(array('server_order'=>-1),$sql);
            if(!empty($list) && !empty($sourcer))foreach ($stime as $t) {
				if(($v[$t->timename]!='')){
					$listdata=QmddServerSetData::model()->find('list_id='.$v['id'].' and s_date="'.$sdate.'" and s_timename="'.$t->timename.'"');
					if(empty($listdata)){
					    $listdata = new QmddServerSetData();
					    $listdata->isNewRecord = true;
					    unset($listdata->id);
				    	$listdata->info_id=$list->info_id;
						$listdata->list_id=$list->id;
						$listdata->server_sourcer_id=$list->server_sourcer_id;
						$listdata->server_order=0;//标识
						$listdata->club_id=$list->club_id;
						$listdata->star_time=$list->star_time;
						$listdata->end_time=$list->end_time;
						$listdata->s_code=$list->s_code;
						$listdata->s_name=$list->s_name;
						$listdata->s_timename=$t->timename;
						$listdata->sale_price=$v[$t->timename];
						$listdata->s_date=$sdate;
						$listdata->s_gfid=$list->s_gfid;
						$listdata->s_gfname=$list->s_gfname;
						$listdata->special=1;

						$listdata->t_typeid=$list->t_typeid;
						$listdata->t_stypeid=$list->t_stypeid;
						$listdata->level_id=$list->s_levelid;
						$listdata->project_ids=$list->project_ids;
						$listdata->f_check = $list->f_check;
						$listdata->json_data= $sourcer->json_data;
						$listdata->longitude= $sourcer->Longitude;
						$listdata->latitude= $sourcer->latitude;
						$listdata->area= $sourcer->area;
						$listdata->area_location=$sourcer->area_location;
						$listdata->site_id= $sourcer->site_id;
						$listdata->site_type= $sourcer->site_type;
						$listdata->save();
				    } else{
				    	if($listdata->sale_price==$v[$t->timename]){
				    		$listdata->updateByPk($listdata->id,array('server_order'=>0));
				    	} else{
				    		$listdata->updateByPk($listdata->id,array('server_order'=>0,'sale_price'=>$v[$t->timename],'special'=>1));
				    	}

				    }

				}
			}
			QmddServerSetData::model()->deleteAll($sql.' and server_order=-1');
			$count++;
         }
         $action=$this->createUrl('special', array('id'=>$id));
		 if($count>0){
			 ajax_status(1, '设置成功');
		 } else {
			 ajax_status(0, '设置失败');
		 }
    }
	//服务审核详情
    public function actionUpdate_check($id) {
		set_cookie('_updatecurrent_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['server_time'] = QmddServerTime::model()->findAll('state in(2,0)');
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
		$club=explode(',', $id);
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
