<?php

class QmddServiceGameController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$project = '',$state = '',$province = '', $city = '', $area = '',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where_club_project('club_id','');
		//$criteria->condition='club_id='.get_session('club_id');
		$criteria->condition.=' ';
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_like($criteria->condition,'service_code,title',$keywords,'');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');//get_where
		if ($province !== '') {
            $criteria->condition.=' AND t.area like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.area like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.area like "%' . $area . '%"';
        }
        if ($start_date != '') {
            $criteria->condition.=' AND uDate>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND uDate<="' . $end_date . '"';
        }
        $criteria->order = 'id DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = BaseCode::model()->getStateType();
        parent::_list($model, $criteria,'index', $data);
    }
	//审核列表
	public function actionIndex_check($keywords = '',$project = '',$province = '', $city = '', $area = '',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='state in(371,2,373)';
		$criteria->condition.=' ';
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_like($criteria->condition,'service_code,title',$keywords,'');
		if ($province !== '') {
            $criteria->condition.=' AND t.area like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.area like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.area like "%' . $area . '%"';
        }
        if ($start_date != '') {
            $criteria->condition.=' AND uDate>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND uDate<="' . $end_date . '"';
        }
        $criteria->order = 'id DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        parent::_list($model, $criteria,'index_check', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['site_id'] = array();
			$data['site_list'] = array();
			$data['servant_list'] = array();
			$data['service_pic_img'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			if(!empty($model->servic_site_ids)) {
				$data['site_list'] = QmddGfSite::model()->findAll('id in('.$model->servic_site_ids.')');
			} else {
				$data['site_list'] = array();
			}
			if(!empty($model->servic_person_ids)) {
				$data['servant_list'] = QualificationClub::model()->findAll('id in('.$model->servic_person_ids.')');
			} else {
				$data['servant_list'] = array();
			}
			$data['service_pic_img'] = array();
            if ($model->service_pic_img != '') {
                $data['service_pic_img'] = explode(',', $model->service_pic_img);
            }
            $this->render('update', $data);

        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

	public function actionSite_address($site_id) {
		$arr = array();
		$person=QmddGfSite::model()->find('id='.$site_id);
		if(!empty($person)){
			$arr['site_address'] = $person->site_address;
			$arr['area_country'] = $person->area_country;
			$arr['area_province'] = $person->area_province;
			$arr['area_city'] = $person->area_city;
			$arr['area_district'] = $person->area_district;
			$arr['area_township'] = $person->area_township;
			$arr['longitude'] = $person->site_longitude;
			$arr['latitude'] = $person->site_latitude;
			ajax_exit($arr);
		}
	}
	//审核
	public function actionUpdate_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			// 获取赛事模式
            if (!empty($model->site_facilities)) {
                $data['game_item'] = ProjectListGame::model()->findAll('id in (' . $model->game_item . ')');
            } else {
                $data['game_item'] = array();
            }
			if(!empty($model->servic_site_ids)) {
				$data['site_list'] = QmddGfSite::model()->findAll('id in('.$model->servic_site_ids.')');
			} else {
				$data['site_list'] = array();
			}
			if(!empty($model->servic_person_ids)) {
				$data['servant_list'] = QualificationClub::model()->findAll('id in('.$model->servic_person_ids.')');
			} else {
				$data['servant_list'] = array();
			}
			$data['service_pic_img'] = array();
            if ($model->service_pic_img != '') {
                $data['service_pic_img'] = explode(',', $model->service_pic_img);
            }
            $this->render('update_check', $data);

        } else {
            $model->attributes =$_POST[$modelName];
			$model->state =get_check_code($_POST['submitType']);
			$st=$model->save();
			show_status($st,'已审核',$this->createUrl('qmddServiceGame/index_check'),'审核失败');
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
		if(!empty($model->id)){
			$sourcer=QmddServerSourcer::model()->find('t_typeid=3 AND s_name_id='.$model->id);
		}
		if(!empty($sourcer) && $sourcer->state==2){
			ajax_status(0, '请先撤销原来的服务资源');
		} else{
		$model->state =get_check_code($_POST['submitType']);
		$model->game_item = gf_implode(',',$post['game_item']);
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
		}
    }

	public function actionSave_Sourcer($id){
		$model= QmddServiceGame::model()->find('id='.$id);
		$sourcer=QmddServerSourcer::model()->find('t_typeid=3 AND s_name_id='.$id);
		if(empty($sourcer)){
			$sourcer = new QmddServerSourcer();
			$sourcer->isNewRecord = true;
			unset($sourcer->id);
		}
		$sourcer->t_typeid=3;
		$sourcer->s_name_id=$id;
		$sourcer->club_id=$model->club_id;
		$sourcer->s_code=$model->service_code;
		$sourcer->s_name=$model->title;
		$sourcer->server_name=$model->server_name;
		$sourcer->s_levelid=93;
		$sourcer->s_levelname='普通';
		$sourcer->t_stypeid=15;
		$sourcer->if_del=$model->if_del;
		$sourcer->area_country=$model->area_country;
		$sourcer->area_province=$model->area_province;
		$sourcer->area_city=$model->area_city;
		$sourcer->area_district=$model->area_district;
		$sourcer->area_township=$model->area_township;
		$sourcer->area_street=$model->area_street;
		$sourcer->latitude=$model->latitude;
		$sourcer->Longitude=$model->longitude;
		$sourcer->logo_pic=$model->imgUrl;
		$sourcer->s_picture=$model->service_pic_img;
		$sourcer->project_ids=$model->project_id;
		$sourcer->contact_number=$model->local_and_phone;

		$sourcer->state=$model->state;
		$sourcer->reasons_adminID=$model->reasons_adminID;
		$sourcer->reasons_time=$model->reasons_time;
		$sourcer->reasons_for_failure=$model->reasons_for_failure;
		$sourcer->area=$model->area;
		$content = array(
				'site_contain'=>$model->site_contain,
				'uDate'=>$model->uDate,
				'servic_person_ids'=>$model->servic_person_ids,
				'servic_site_ids'=>$model->servic_site_ids,
				'game_item'=>$model->game_item,
			);
		$sourcer->json_data=json_encode($content);
		$sv=$sourcer->save();
		$action=$this->createUrl('qmddServiceGame/index');
		show_status($sv,'设置成功',$action,'设置失败');
	}

	public function actionDel_Sourcer($id){
		$sourcer=QmddServerSourcer::model()->find('t_typeid=3 AND s_name_id='.$id);
		if (empty($sourcer)) {
            ajax_status(0, '该项还没有设置服务资源');
        }
		$sv=QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=3 AND s_name_id='.$id);
		$action=$this->createUrl('qmddServiceGame/index');

		show_status($sv,'撤销成功',$action,'撤销失败');
	}

    //删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->updateAll(array('if_del'=>509),'id in('.$id.')');
		if(!empty($count)) {
			foreach ($club as $d) {
				QmddServerSourcer::model()->updateAll(array('state'=>374),'t_typeid=3 and s_name_id='.$d);
			}
			ajax_status(1, '删除成功');
		} else {
            ajax_status(0, '删除失败');
        }
  }

}