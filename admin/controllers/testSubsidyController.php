<?php
class testSubsidyController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    function saveData($model,$post,$index) {
        $model->attributes = $post;
        switch ($index) {
            case 'Create':
            $model->code = setGetValue('siteCode');
            $model->audState = '待提交';
            break;

            case 'Update':
            if($_POST['submitType'] == 'baocun1') $model->audState = '待提交';
            else $model->audState = '审核通过';
            break;

            case 'Updatecheck':
            if($_POST['submitType'] == 'pass') $model->audState = '审核通过';
            else $model->audState = '审核不通过';
            break;

            case 'Updatefail':
            if($_POST['submitType'] == 'again'){
                $model->reviewCom = '';
                $model->audState = '待审核';
            }
            else $model->audState = '审核不通过';
            break;  
        }
        show_status($model->save(),'保存成功',get_cookie('_currentUrl_'),'保存失败');  
     }

    public function actionCreate() {
        $model = new testSubsidy;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $siteCode = setGetValue('siteCode',getAutoNo('testSubsidy'));
            $data['siteCode'] = $siteCode;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST["$this->model"],'Create');
        }
    }

    public function actionStaIndex($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = testStadium::model();
        $criteria = new CDbCriteria;
        if(!empty($keywords)) 
        $criteria->condition = get_like('1=1','comCode,comName,code,name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'sta_index', $data);
    }

    public function actionVenIndex($keywords='',$staCode) {     
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $data = array();
        $model = testVenue::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("staCode='$staCode'");
        if(!empty($keywords))
        $criteria->condition = get_like($criteria->condition,'code,name',$keywords,'');
        $data['staCode'] = $staCode;
        parent::_list($model, $criteria, 'ven_index', $data);
    }

    public function actionIndex($keywords='',$venCode,$staCode) {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='待提交'");
        $criteria->addCondition("venCode='$venCode'");
        if(!empty($keywords)) 
        $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,venCode,venName,code,name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        $data['venCode'] = $venCode;
        $data['staCode'] = $staCode;
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
            $this->saveData($model,$_POST["$this->model"],'Update');
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
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,venCode,venName,code,name',$keywords,'');
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
            $this->saveData($model,$_POST["$this->model"],'Updatecheck');
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
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,venCode,venName,code,name',$keywords,'');
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
            $this->saveData($model,$_POST["$this->model"],'Updatefail');
        }
    }

    public function actionIndexpass($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='审核通过'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'comCode,comName,staCode,staName,venCode,venName,code,name',$keywords,'');
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