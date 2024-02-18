<?php
class testVenueController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionCreate() {
        $model = new testVenue;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $siteCode = setGetValue('siteCode',getAutoNo('testVenue'));
            $data['siteCode'] = $siteCode;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $model->code = setGetValue('siteCode');
            $model->serType = implode(",",$_POST['testVenue']['serType']);

            $model->name = $_POST['testVenue']['name'];
            $model->project = $_POST['testVenue']['project'];
            $model->capacity = $_POST['testVenue']['capacity'];
            $model->group = $_POST['testVenue']['group'];
            $model->staName = $_POST['testVenue']['staName'];
            $model->audState = '待提交';
            show_status($model->save(),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionIndex($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='待提交'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,code,name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
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
            $model->serType = implode(",",$_POST['testVenue']['serType']);

            $model->name = $_POST['testVenue']['name'];
            $model->project = $_POST['testVenue']['project'];
            $model->capacity = $_POST['testVenue']['capacity'];
            $model->group = $_POST['testVenue']['group'];
            $model->staName = $_POST['testVenue']['staName'];

            if($index == 'index_pass') $model->audState = '审核通过';
            else $model->audState = '待提交';
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionTijiao(){
        $modelid = $_REQUEST['modelid'];
        $modelName = $this->model;
        $model = $modelName::model()->find("id='$modelid'");
        $model->audState = '待审核';
        $model->save();
        $data = array('modelid'=>$modelid);
        echo CJSON::encode($data);
    }

    public function actionIndexcheck($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='待审核'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,code,name',$keywords,'');
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
            $model->reviewCom = $_POST['testVenue']['reviewCom'];
            if($_POST['submitType'] == 'notpass') $model->audState = '审核不通过';
            if($_POST['submitType'] == 'pass') $model->audState = '审核通过';
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

    public function actionIndexfail($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='审核不通过'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,code,name',$keywords,'');
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
            $model->serType = implode(",",$_POST['testVenue']['serType']);

            $model->name = $_POST['testVenue']['name'];
            $model->project = $_POST['testVenue']['project'];
            $model->capacity = $_POST['testVenue']['capacity'];
            $model->group = $_POST['testVenue']['group'];
            $model->staName = $_POST['testVenue']['staName'];

            if($_POST['submitType'] == 'again'){
                $model->audState = '待审核';
                $model->reviewCom = '';
            }
            if($_POST['submitType'] == 'baocun') $model->audState = '审核不通过';
            show_status($model->save(),'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }
    }

    public function actionIndexpass($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='审核通过'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,code,name',$keywords,'');
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