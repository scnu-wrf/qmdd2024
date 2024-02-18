<?php

class GfArticleCatController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '', $pid ='', $type=1) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        if($type <2){
            $criteria->condition.=' AND ( cat_type = 1' . $pid .')';
        }else if ($type > 1) {
            $criteria->condition.=' AND ( cat_type = "' . $type . '" AND parent_id ="'.$pid.'") ';
        }
		$criteria->condition=get_like($criteria->condition,'cat_name,cat_type,keywords,cat_desc',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria);
    }
	
	public function actionIndex1($keywords = '',$pid='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition=get_like($criteria->condition,'cat_name,cat_type,keywords,cat_desc',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'index1');
    }
	
	
	
	 public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
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
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	function saveData($model,$post) {
       $model->attributes =$post;
       $sv=$model->save();
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
 }
 
	public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('id in(' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}
