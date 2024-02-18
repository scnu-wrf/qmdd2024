<?php

class GfSiteDemandController extends BaseController {
	//protected $project_list = '';
    protected $model = '';

    public function init() {
        $this->model = 'GfSiteDemand';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$site_envir='',$site_belong='',$site_level='',$site_state='',$province = '', $city = '', $area = '',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
		if ($province !== '') {
            $criteria->condition.=' AND t.site_address like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.site_address like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.site_address like "%' . $area . '%"';
        }
        
        if ($start_date != '') {
            $criteria->condition.=' AND site_date_end>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND site_date_end<="' . $end_date . '"';
        }

        // $criteria->join = "JOIN gf_site_project on t.site_code=gf_site_project.site_code";
        // $criteria->condition=get_where_club_project('user_club_id','gf_site_project.project_id');
		$criteria->condition=get_where($criteria->condition,!empty($site_envir),'site_envir',$site_envir,'');
		$criteria->condition=get_where($criteria->condition,!empty($site_belong),'site_belong',$site_belong,'');
		$criteria->condition=get_where($criteria->condition,!empty($site_level),'site_level',$site_level,'');
		$criteria->condition=get_where($criteria->condition,!empty($site_state),'site_state',$site_state,'');
        $criteria->condition=get_like($criteria->condition,'site_code,site_name,belong_name',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array(); 
        $data['site_envir'] = BaseCode::model()->getCode(667);
		$data['site_belong'] = BaseCode::model()->getCode(208);
		$data['site_level'] = BaseCode::model()->getCode(386);
		$data['site_state'] = BaseCode::model()->getCode(370);
		parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['site_prove'] = array();
			$data['site_facilities'] = array();
            
            $this->render('update', $data);
			
        }else{
            $this-> saveData($model,$_POST[$modelName]);
			
        }
    }

  
  /*public  function save_club_id($site_code,$club_id){       
    //删除认领单位
    GfSiteUser::model()->deleteAll('site_code='.$site_code);
    if(!empty($club_id)){
        $model2 = new GfSiteUser();
        $club_list_pic = array();
        $club_list_pic = explode(',', $club_id);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
            unset($model2->id);
            $model2->site_code =$site_code;
            $model2->club_id = $v;
            $model2->save();
        }
    }
	if ($_POST['submitType'] == 'shenhe') {
		$model->state = 371;
	} else if ($_POST['submitType'] == 'tongguo') {
		$model->state = 2;
	} else if ($_POST['submitType'] == 'butongguo') {
		$model->state = 373;
	} 
  }*/
  

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(171);
            $model->site_description_temp=get_html($basepath->F_WWWPATH.$model->site_description, $basepath);
            $data['model'] = $model;
			//获取场地证明
			$data['project_list'] = GfSiteProject::model()->findAll('site_code='.$model->site_code);
			$data['site_prove'] = array();
            if ($model->site_prove != '') {
                $data['site_prove'] = explode(',', $model->site_prove);
            }
            // 获取经营类目
            if (!empty($model->site_facilities)) {
                $data['site_facilities'] = AutoFilterSet::model()->findAll('id in (' . $model->site_facilities . ')');
            } else {
                $data['site_facilities'] = array();
            }
            $data['cluSite_id'] = GfSiteUser::model()->findAll('site_code="' . $model->site_code . '"');
            // if(!empty($data['cluSite_id'])) {
            //     foreach($data['cluSite_id'] as $v2) {
            //         // $v2->site_code = $model->site_code;
            //         // $v2->club_contacts = $model->belong_name;
            //         // $v2->club_id = $model->belong_id;
            //         // $v2->club_name = $model->user_club_name;
            //         // $v2->club_contacts_phone = $model->contact_phone;
            //         // $v2->state = $model->site_state;
            //         // $v2->if_del = $model->if_del;
            //     }
            // }
            $this->render('update', $data);
            
        } else {
			$this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
		if ($_POST['submitType'] == 'shenhe') {
			$model->site_state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->site_state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->site_state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->site_state = 373;
        } else {
            $model->site_state = 721;
        }
        $st=$model->save();
        $this->save_project_list($model->site_code,$post['project_list']);
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
	
	public function save_project_list($site_code,$project_list){
        //删除原有项目
        GfSiteProject::model()->deleteAll('site_code='.$site_code);
        if(!empty($project_list)){
            $model2 = new GfSiteProject();
            $club_list_pic = array();
            $club_list_pic = explode(',', $project_list);
            $club_list_pic = array_unique($club_list_pic);
            foreach ($club_list_pic as $v) {
                $model2->isNewRecord = true;
                unset($model2->id);
                $model2->site_code =$site_code;
                $model2->project_id = $v;
                $model2->save();
            }
        }
    }
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function actionGfDeman($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        // $model = $modelName::model();
        $site_code = $_POST['site_code'];
        $user_club_name = $_POST['user_club_name'];
        if(isset($site_code) && isset($user_club_name)) {
            $gf_site_demand = new GfSiteUser();
            $gf_site_demand->isNewRecord = true;
            unset($gf_site_demand->id);
            $gf_site_demand->site_code = $model->site_code;
            $gf_site_demand->club_id = get_session('club_id');
            $gf_site_demand->club_name = get_session('club_name');
            $gf_site_demand->club_contacts_phone = $model->contact_phone;
            $gf_site_demand->state = 371;
            // $gf_site_demand->if_del = $model->if_del;
            $gf_site_demand->save();
            ajax_status(1, '申请成功',Yii::app()->request->urlReferrer);
        } else {
            ajax_status(0, '申请失败');
        }
    }

}
