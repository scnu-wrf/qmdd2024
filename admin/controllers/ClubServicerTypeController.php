<?php

class ClubServicerTypeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionIndex() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=501 ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(501) order by f_ctcode');
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(501) order by f_ctcode');
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_sqdw() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=1467 ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_sqdw', $data);
    }
    public function actionUpdate_sqdw($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1467) order by f_ctcode');
            $this->render('update_sqdw', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate_sqdw() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1467) order by f_ctcode');
            $this->render('update_sqdw', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_zlhb() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=1124 ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_zlhb', $data);
    }
    public function actionUpdate_zlhb($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1124) order by f_ctcode');
            $this->render('update_zlhb', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate_zlhb() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1124) order by f_ctcode');
            $this->render('update_zlhb', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_gys() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=1471 ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_gys', $data);
    }
    public function actionUpdate_gys($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1471) order by f_ctcode');
            $this->render('update_gys', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate_gys() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1471) order by f_ctcode');
            $this->render('update_gys', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    public function actionIndex_gldw() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type in(1479,1125) ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_gldw', $data);
    }
    public function actionUpdate_gldw($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1125,1479) order by f_ctcode');
            $this->render('update_gldw', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate_gldw() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1125,1479) order by f_ctcode');
            $this->render('update_gldw', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_dragon_tiger() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=1472 ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_dragon_tiger', $data);
    }
    public function actionUpdate_dragon_tiger($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1472) order by f_ctcode');
            $this->render('update_dragon_tiger', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionCreate_dragon_tiger() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1472) order by f_ctcode');
            $this->render('update_dragon_tiger', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
        public function actionIndex_fxs() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=1471 ';
        $criteria->order = 'f_id DESC';
        $data = array();
        parent::_list($model, $criteria, 'Index_fxs', $data);
    }
    public function actionUpdate_fxs($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1471) order by f_ctcode');
            $this->render('update_gys', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate_fxs() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 and f_id in(1471) order by f_ctcode');
            $this->render('update_gys', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    
    function saveData($model,$post) {
        $name='';
        if(!empty($post['entry_way'])&&is_array($post['entry_way'])){
            $post['entry_way']=implode(",",$post['entry_way']);
        }
        if(!empty($post['get_type'])&&is_array($post['get_type'])){
            $post['get_type']=implode(",",$post['get_type']);
        }
        $model->attributes =$post;
        $type=ClubType::model()->find('id='.$model->member_type_id);
        $model->type=$type->f_id;
        $sType=ClubServicerType::model()->find('member_type_id='.$model->member_type_id.' and member_second_id='.$model->member_second_id);
        $error='保存失败';
        if(!empty($sType)&&$sType->f_id!=$model->f_id){
            $st=0;
            $error='保存失败,该会员类型已存在';
        }else{
            $st=$model->save();
            
            if($st==1&&$model->is_club_qualification==1){
                $project=ProjectList::model()->findAll('project_type=1');
                foreach($project as $v){ 
                    $projectSerivce=ProjectSerivce::model()->find('project_id='.$v->id.' and qualification_type_id='.$model->member_second_id);
                    if(empty($projectSerivce)){
                        $projectSerivce = new ProjectSerivce();
                        $projectSerivce->isNewRecord = true;
                        unset($projectSerivce->id);
                        $projectSerivce->qualification_type_id=$model->member_second_id;
                        $projectSerivce->project_id=$v->id;
                        $projectSerivce->min_count=1;
                        $projectSerivce->save();
                    }
                }
            }
        }
         show_status($st,'保存成功',get_cookie('_currentUrl_'),$error);
    }

    public function actionGetType(){
        $id = $_POST['id'];
        $cType = ClubType::model()->find('id='.$id);
        $f_code = ClubType::model()->findAll('left(f_ctcode,3)="'.$cType->f_ctcode.'" and length(f_ctcode)>3');
        $ar = array();
        if(!empty($f_code))foreach($f_code as $key => $val){
            $ar[$key]['id'] = $val->id;
            $ar[$key]['f_ctcode'] = $val->f_ctcode;
            $ar[$key]['f_ctname'] = $val->f_ctname;
        }
        echo CJSON::encode($ar);
    }


    // 保存‘添加动作’
    public function actionSendInvite() {
        ajax_status(1, '保存成功', get_cookie('_currentUrl_'));
    }


    // 保存‘编辑动作’
    public function actionSaveEdit() {
        $modelName = $this->model;
        $model = $modelName::model();

        $data = array();
        $id = $_GET['id'];
        $f_ctcode = $_GET['f_ctcode'];
        $f_ctname = $_GET['f_ctname'];
        $check_val_edit = $_GET['check_val_edit'];
        $check_val_edit2 = implode(",", $check_val_edit);
        $club_type1 = ClubType::model()->find('if_del=510 id='.$id);
        $club_type1->f_ctcode = $f_ctcode;
        $club_type1->f_ctname = $f_ctname;
        $club_type1->member_attribute = $check_val_edit2;
        if (mb_strlen($f_ctcode) > 3){
            $club_type1->f_level = 2;
        }else{
            $club_type1->f_level = 1;
        }
        if($sv=1){
            $sv=$club_type1->save();
        }
        ajax_status(1, '保存成功', get_cookie('_currentUrl_'));

    }


    public function actionDelete($id) {
        // 基础伪删除方法
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $count=0;
        if($id!='id'){
            $criteria->condition = 'f_id in(' . $id . ')';
            $count = $model->updateAll(array('if_del' => 509), $criteria);
        }
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }


}
