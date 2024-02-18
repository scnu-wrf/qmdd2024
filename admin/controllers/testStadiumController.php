<?php
class testStadiumController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }
    
    public function actionGetCity($cityKeywords){ 
        $w1=get_like('level=2','areaName',$cityKeywords,'');
        $tmp=new eg_region;
        $findCity=$tmp->findAll($w1);
        $findCityArea=array();
        $w1='level=3 and parent_code=';
        if(!empty($findCity)){
            foreach($findCity as $v){
             array_push($findCityArea, $tmp->findAll($w1.$v->id) );
           }
        }
        $rs=array('findCity'=>$findCity,'findCityArea'=>$findCityArea);
        echo CJSON::encode($rs);
     }


    public function actionGetStadiumList($offset){ 
        $criteria=new CDbCriteria;
        $criteria->limit=10;
        $criteria->offset=$offset;
        $tmp=testStadium::model()->findAll($criteria);
        //foreach($tmp as $k=>$v){
          //  $tmp[$k]->base=explode(",", $v->base);
        //}
        echo CJSON::encode($tmp);
     }

    public function actionGetVenueList(){
        $type=$_GET['type'];
        $orderType=$_GET['orderType'];
        $baseType=$_GET['baseType'];
        $district=$_GET['district'];
        $criteria=new CDbCriteria;
        $criteria->condition=get_like('1','name,address,base',$_GET['keywords'],'');
        $criteria->addCondition('city="'.$_GET['city'].'"');
        $criteria->limit=10;
        $criteria->offset=$_GET['offset'];
        if($district!='地址区域'){
            $criteria->addCondition('district="'.$district.'"');
        }
        if($type!="全部")
           $criteria->addcondition(get_like('','project',$type,''));
        if($orderType=='浏览量最高'){
           $criteria->order='view desc';
        }else if($orderType=='预定量最高'){
           $criteria->order='sale desc';
        }
        $result=testStadium::model()->findAll($criteria);
        if($baseType!='筛选'){
            $result=array();
            foreach($temp as $key =>$t){
                $itemArray=$t->base;
                if(in_array($baseType,$itemArray)){
                   array_push($result,$t);
                }
            }
        }
        echo CJSON::encode($result);
      
     }

    //小程序获取场馆详情信息
    public function actionGetVenueInfo($staId) {   
        $tmp = testStadium::model()->find("id='".$staId."'");
        echo CJSON::encode($tmp);
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionCreate() {
        $model = new testStadium;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $siteCode = setGetValue('siteCode',getAutoNo('testStadium'));
            $data['siteCode'] = $siteCode;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $model->attributes =$_POST['testStadium'];
            $model->code = setGetValue('siteCode');
            $model->audState = '待提交';
            show_status($model->save(),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionIndex($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1="audState='待提交'";
        $criteria->condition = get_like($w1,'name,code',$keywords,'');
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
            $data['sign'] =($index=='index_pass') ? 'index_pass' : 'update';
            $this->render('update', $data);
        } else {
            $model->attributes =$_POST['testStadium'];
            $model->audState=($index == 'index_pass') ?'审核通过' : '待提交';
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionTijiao(){
        $id = $_REQUEST['modelid'];
        $modelName = $this->model;
        $ds=array('audState' => '待审核');
        $modelName::model()->updateAll($ds,"id='".$id."'");
        $data = array('modelid'=>$id);
        echo CJSON::encode($data);
    }

    public function actionIndexcheck($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1="audState='待审核'";
        $criteria->condition = get_like($w1,'code,name',$keywords,'');
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
            $s1=$_POST['submitType'];
            $model->reviewCom = $_POST['testStadium']['reviewCom'];
            if($s1 == 'notpass') $model->audState = '审核不通过';
            if($s1 == 'pass') $model->audState = '审核通过';
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
        $w1="audState='审核不通过'";
        $criteria->condition = get_like($w1,'code,name',$keywords,'');
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
            $model->attributes =$_POST['testStadium'];
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
        $w1="audState='审核通过'";
        $criteria->condition = get_like($w1,'code,name',$keywords,'');
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

 }