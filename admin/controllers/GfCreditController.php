<?php

class GfCreditController extends BaseController {

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
		$criteria->condition = 'object=1476';
		$criteria->condition=get_like($criteria->condition,'item_type_name',$keywords,'');
        $criteria->order = 'code DESC';
        parent::_list($model, $criteria, 'index');
    }
	
	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
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
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_scrve($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'object=1477';
		$criteria->condition=get_like($criteria->condition,'item_type_name',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'index_scrve');
    }

	public function actionCreate_scrve() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_scrve', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_scrve($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_scrve', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_tyd($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'object=734';
		$criteria->condition=get_like($criteria->condition,'item_type_name',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'index_tyd');
    }

	public function actionCreate_tyd() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_tyd', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_tyd($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_tyd', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
         $st=$model->save();
         show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

}
