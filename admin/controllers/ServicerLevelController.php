<?php

class ServicerLevelController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }


    public function actionIndex() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=501 ';
        $criteria->order = 'member_second_code DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_dwxm() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type in(1124,1125,1467,1471,1474) ';
        $criteria->order = 'member_second_code DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_dwxm', $data);
    }

    public function actionUpdate_dwxm($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update_dwxm', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate_dwxm() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update_dwxm', $data);
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
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_sqdw', $data);
    }

    public function actionUpdate_sqdw($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_zlhb', $data);
    }

    public function actionUpdate_zlhb($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_gys', $data);
    }
    public function actionUpdate_gys($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update_gys', $data);
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
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_dragon_tiger', $data);
    }
    public function actionUpdate_dragon_tiger($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
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
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update_dragon_tiger', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_gf() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=210 ';
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_gf', $data);
    }
    public function actionUpdate_gf($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update_gf', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionCreate_gf() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $this->render('update_gf', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionGetType(){
        $id = $_POST['id'];
        $cType = ClubType::model()->find('id='.$id);
        $f_code = ClubType::model()->findAll('left(f_ctcode,3)="'.$cType->f_ctcode.'" and length(f_ctcode)>3');
        $ar = array();
        if(!empty($f_code))foreach($f_code as $key => $val){
            $sType=ClubServicerType::model()->find('member_type_id='.$id.' and member_second_id='.$val->id);
            $ar[$key]['id'] = $val->id;
            $ar[$key]['f_ctcode'] = $val->f_ctcode;
            $ar[$key]['f_ctname'] = $val->f_ctname;
            if(!empty($sType)){
                $ar[$key]['entry_way'] = $sType->entry_way;
                $base=BaseCode::model()->findAll('f_id in('.$sType->entry_way.')');
                $entry_way_name='';
                foreach($base as $b){
                    $entry_way_name.=$b->F_NAME.'/';
                }
                $ar[$key]['entry_way_name'] =  rtrim($entry_way_name, "/");;
            }
        }
        echo CJSON::encode($ar);
    }
    
    function saveData($model,$post) {
        $model->attributes =$post;
        $type=ClubType::model()->find('id='.$model->member_type_id);
        $model->type=$type->f_id;
        $st=$model->save();
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        parent::_delete($id);
    }

    // 动动约 场馆等级设置
    public function actionIndex_venue_rating_setting(){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=1157 ';
        $data = array();
        parent::_list($model, $criteria, 'index_venue_rating_setting', $data);
    }

    public function actionCreate_venue_rating_setting(){
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update_venue_rating_setting',$data);
        }
        else{
            // $model->attributes = $_POST[$modelName];
            // $sv = $model->save();
            // show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
            // parent::_create($model,'create',$data,get_cookie('_currentUrl_'));
            $this->saveVenueSetting($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_venue_rating_setting($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update_venue_rating_setting',$data);
        }
        else{
            // $model->attributes = $_POST[$modelName];
            // $sv = $model->save();
            // show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
            // parent::_update($model,'create',$data,get_cookie('_currentUrl_'));
            $this->saveVenueSetting($model,$_POST[$modelName]);
        }
    }

    function saveVenueSetting($model,$post){
        $model->attributes = $post;
        $xh = ServicerLevel::model()->find('type=1157  order by card_xh desc');
        $model->card_xh = empty($model->card_xh) ? $xh->card_xh+1 : $model->card_xh;
        $model->card_level = empty($model->card_level) ? $model->card_xh : $model->card_level;
        $model->entry_way = 453;
        $st = $model->save();
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
}
