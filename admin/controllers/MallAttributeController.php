<?php

class MallAttributeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent is NULL';
		$criteria->condition=get_like($criteria->condition,'attr_code,attr_name',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'index');
    }
	
	public function actionIndex1($keywords = '',$pid='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent=' . $pid;
        $criteria->condition=get_like($criteria->condition,'attr_code,attr_name',$keywords,'');
        $criteria->order = 'id DESC';        
        parent::_list($model, $criteria, 'index1');
    }
    
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        
        parent::_create($model, 'create', $data, get_cookie('_currentUrl_'));
      
        
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            
        }
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
    

}