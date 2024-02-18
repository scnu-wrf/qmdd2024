<?php

class GfSiteController extends BaseController {
	//protected $project_list = '';
    protected $model = '';

    public function init() {
        $this->model = 'GfSite';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionIndex($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='待提交'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
		$criteria->order = 'id';
		$data = array();
		parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $siteCode = setGetValue('siteCode',getAutoNo('GfSite',get_session('gfaccount')));
            $data['siteCode'] = $siteCode;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $model->site_code = setGetValue('siteCode');
            $model->site_name = $_POST['GfSite']['site_name'];
            $model->contact_phone = $_POST['GfSite']['contact_phone'];
            $model->site_level_name = $_POST['GfSite']['site_level_name'];
            $model->site_address = $_POST['GfSite']['site_address'];
            $model->site_longitude = $_POST['GfSite']['site_longitude'];
            $model->site_latitude = $_POST['GfSite']['site_latitude'];
            $model->site_area = $_POST['GfSite']['site_area'];
            $model->gem_project = implode(",",$_POST['GfSite']['gem_project']);
            $model->reasons_time = date('Y-m-d H:i:s');
            $model->reasons_adminname = get_session('admin_name');
            $model->reasons_gfaccount = get_session('gfaccount');
            if($_POST['submitType'] == 'baocun') $model->site_state_name = '待提交';
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionUpdate($id,$index='') { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if($index == 'index_pass') $data['sign'] = 'index_pass';
            else $data['sign'] = 'update';
            $this->render('update', $data);
        } else {
            $model->site_name = $_POST['GfSite']['site_name'];
            $model->contact_phone = $_POST['GfSite']['contact_phone'];
            $model->site_level_name = $_POST['GfSite']['site_level_name'];
            $model->site_address = $_POST['GfSite']['site_address'];
            $model->site_longitude = $_POST['GfSite']['site_longitude'];
            $model->site_latitude = $_POST['GfSite']['site_latitude'];
            $model->site_area = $_POST['GfSite']['site_area'];
            $model->gem_project = implode(",",$_POST['GfSite']['gem_project']);
            $model->reasons_time = date('Y-m-d H:i:s');
            $model->reasons_adminname = get_session('admin_name');
            $model->reasons_gfaccount = get_session('gfaccount');
            if($index == 'index_pass') $model->site_state_name = '审核通过';
            else $model->site_state_name = '待提交';
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionTijiao(){
        $modelid = $_REQUEST['modelid'];
        $modelName = $this->model;
        $model = $modelName::model()->find("id='$modelid'");
        $model->site_state_name = '待审核';
        $model->reasons_time = date('Y-m-d H:i:s');
        $model->reasons_adminname = get_session('admin_name');
        $model->reasons_gfaccount = get_session('gfaccount');
        $model->save(false);
        $data = array('modelid'=>$modelid);
        echo CJSON::encode($data);
    }

    public function actionIndexcheck($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='待审核'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index_check', $data);
    }

    public function actionUpdatecheck($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_check', $data);
        } else {
            $model->reasons_for_failure = $_POST['GfSite']['reasons_for_failure'];
            $model->reasons_time = date('Y-m-d H:i:s');
            $model->reasons_adminname = get_session('admin_name');
            $model->reasons_gfaccount = get_session('gfaccount');
            if($_POST['submitType'] == 'notpass') $model->site_state_name = '审核不通过';
            show_status($model->save(),'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }
    }

    public function actionTongguo() {   
        $modelid = $_REQUEST['modelid'];
        $modelName = $this->model;
        $model = $this->loadModel($modelid, $modelName);
        $model->reasons_for_failure = '同意';
        $model->reasons_time = date('Y-m-d H:i:s');
        $model->reasons_adminname = get_session('admin_name');
        $model->reasons_gfaccount = get_session('gfaccount');
        $model->site_state_name = '审核通过';
        $model->save();
        $data = array('modelid'=>$modelid);
        echo CJSON::encode($data);
    }

    public function actionIndexfail($startdate='',$enddate='',$keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='审核不通过'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index_fail', $data);
    }

    public function actionUpdatefail($id) { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_fail', $data);
        } else {
            $model->site_name = $_POST['GfSite']['site_name'];
            $model->contact_phone = $_POST['GfSite']['contact_phone'];
            $model->site_level_name = $_POST['GfSite']['site_level_name'];
            $model->site_address = $_POST['GfSite']['site_address'];
            $model->site_longitude = $_POST['GfSite']['site_longitude'];
            $model->site_latitude = $_POST['GfSite']['site_latitude'];
            $model->site_area = $_POST['GfSite']['site_area'];
            $model->gem_project = implode(",",$_POST['GfSite']['gem_project']);
            $model->reasons_time = date('Y-m-d H:i:s');
            $model->reasons_adminname = get_session('admin_name');
            $model->reasons_gfaccount = get_session('gfaccount');
            if($_POST['submitType'] == 'again') $model->site_state_name = '待审核';
            if($_POST['submitType'] == 'baocun') $model->site_state_name = '审核不通过';
            show_status($model->save(false),'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }
    }

    public function actionIndexpass($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='审核通过'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index_pass', $data);
    }

    public function actionPassdetail($id) { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $data['model'] = $model;
        $this->render('pass_detail', $data);
    }

}
