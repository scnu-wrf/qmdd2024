<?php

class GfServiceInfoController extends BaseController {

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
        $criteria->condition = '(1=1)';
        $criteria->order = 'add_time DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST);
			
        }
    }
        
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
            
        } else {
			$this-> saveData($model,$_POST);
        }
    }

	function saveData($model,$post) {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        $st=$model->save();
	    show_status($st, '保存成功', get_cookie('_currentUrl_'), '保存失败'); 
    }
    

    //删除
    public function actionDelete($id) {
        parent::_clear($id);
    }   
}
