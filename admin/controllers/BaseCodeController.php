<?php

class BaseCodeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_oper=1';
        $criteria->order = 'F_TYPECODE';
        $criteria->condition = get_like($criteria->condition,'F_NAME',$keywords,'');
      
        parent::_list($model, $criteria,'index');
    }
	
    public function actionIndex2($id) {
        $model = BaseCode::model();
        $criteria = New CDbCriteria;
        // $criteria->condition = 'if_oper=1';
        $criteria->condition = get_where($criteria->condition,!empty($id),'fater_id',$id,'"');
        $data = array();
        parent::_list($model, $criteria, 'index2', $data);
    }
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(!empty($_GET['id'])){
                $data['faterId']=$_GET['id'];
            }
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
          
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
    function saveData($model,$post) {
        $model->attributes = $post;
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    // 赛事设置->类型等级设置
    public function actionindex_game_type_level($keywords=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like('fater_id=158','F_NAME',$keywords,'');
        $criteria->order = 'F_TYPECODE';
        $data = array();
        parent::_list($model,$criteria,'index_game_type_level',$data);
    }

    public function actionCreate_game_type_level() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_game_type_level', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_game_type_level($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_game_type_level', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
}
