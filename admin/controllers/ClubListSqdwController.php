<?php
class ClubListSqdwController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        show_status($model->save(),'保存成功',get_cookie('_currentUrl_'),'保存失败');  
     }


    public function actionIndexlist($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='待提交'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'club_code,club_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index_list', $data);
    }

    public function actionCreate() {
        $model = new ClubListSqdw;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $siteCode = setGetValue('siteCode',getAutoNo('ClubListSqdw'));
            $data['siteCode'] = $siteCode;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $model->audState = "待提交";
            $model->club_code = setGetValue('siteCode');
            $this->saveData($model,$_POST["$this->model"]);
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
            if($index == 'index_pass'){ $model->audState = "审核通过";$model->createAdminUser();}
            else $model->audState = "待提交";
            $this->saveData($model,$_POST["$this->model"]);
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
        $w1="audState='待审核'";
        $criteria->condition = get_like($w1,'club_code,club_name',$keywords,'');
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
            if($_POST['submitType'] == 'notpass') $model->audState = '审核不通过';
            if($_POST['submitType'] == 'pass') $model->audState = '审核通过';
            $this->saveData($model,$_POST["$this->model"]);
        }
    }

    public function actionIndexfail($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("audState='审核不通过'");
        $criteria->condition = get_like('1','club_code,club_name',$keywords,'');
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
            if($_POST['submitType'] == 'again'){
                $model->audState = '待审核';
                $model->reviewCom = '';
            }
            if($_POST['submitType'] == 'baocun') $model->audState = '审核不通过';
            $this->saveData($model,$_POST["$this->model"]);
        }
    }

    public function actionIndexpass($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1="audState='审核通过'";
        $criteria->condition= get_like($w1,'club_code,club_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index_pass', $data, 5);
    }

    public function actionPassdetail($id) { 
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $data['model'] = $model;
        $this->render('pass_detail', $data);
    }

    //小程序注册
    public function actionWxCreate($club_name,$club_address,$contact_phone,$email){
        $model = new ClubListSqdw;
        $model->audState = "待审核";
        $model->club_code=getAutoNo('ClubListSqdw');
        $model->club_name=$club_name;
        $model->club_address=$club_address;
        $model->contact_phone=$contact_phone;
        $model->email=$email;
        $model->save()?JsonSuccess():JsonFail();
    }

 }